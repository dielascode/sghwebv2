// nilai-produk.js
// Taruh di: /sghwebv2/ec/js/nilai-produk.js
// Load di index.php dengan 1 baris:
// <script src="/sghwebv2/ec/js/nilai-produk.js"></script>

var nilaiRating = 0;
var nilaiLabels = ['', 'Kurang baik', 'Cukup', 'Baik', 'Sangat baik', 'Luar biasa'];

function openNilaiPopup(namaProduk, imgSrc) {
    nilaiRating = 0;
    nilaiRenderStars(0);
    document.getElementById('nilai-rating-desc').textContent = '';
    document.getElementById('nilai-quality').value           = '';
    document.getElementById('nilai-taste').value             = '';
    document.getElementById('nilai-preview-area').innerHTML  = '';
    document.getElementById('nilai-nama').textContent        = namaProduk || '-';
    document.getElementById('nilai-img').src                 = imgSrc     || '';
    document.getElementById('overlay-nilai').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeNilaiPopup() {
    document.getElementById('overlay-nilai').classList.remove('active');
    document.body.style.overflow = '';
}

function handleNilaiOverlay(e) {
    if (e.target === document.getElementById('overlay-nilai')) closeNilaiPopup();
}

function nilaiSetRating(val) {
    nilaiRating = val;
    nilaiRenderStars(val);
    document.getElementById('nilai-rating-desc').textContent = nilaiLabels[val];
}
function nilaiHover(val)   { nilaiRenderStars(val); }
function nilaiResetHover() { nilaiRenderStars(nilaiRating); }
function nilaiRenderStars(val) {
    document.querySelectorAll('.nilai-star').forEach(function (s, i) {
        s.classList.toggle('active', i < val);
    });
}

function nilaiHandleFiles(input, type) {
    var area = document.getElementById('nilai-preview-area');
    Array.from(input.files).forEach(function (file) {
        var url  = URL.createObjectURL(file);
        var wrap = document.createElement('div');
        wrap.className = 'nilai-thumb';
        if (type === 'photo') {
            var img = document.createElement('img');
            img.src = url;
            wrap.appendChild(img);
        } else {
            var vid = document.createElement('video');
            vid.src = url;
            wrap.appendChild(vid);
            var badge       = document.createElement('div');
            badge.className   = 'play-badge';
            badge.textContent = '▶';
            wrap.appendChild(badge);
        }
        var del         = document.createElement('button');
        del.className   = 'del-btn';
        del.textContent = '✕';
        del.onclick = function () { area.removeChild(wrap); };
        wrap.appendChild(del);
        area.appendChild(wrap);
    });
    input.value = '';
}

function nilaiShowToast(msg) {
    var t = document.getElementById('nilai-toast');
    t.textContent   = msg;
    t.style.display = 'block';
    setTimeout(function () { t.style.display = 'none'; }, 2500);
}

function nilaiSubmit() {
    if (!nilaiRating) { nilaiShowToast('Pilih bintang terlebih dahulu'); return; }
    var quality = document.getElementById('nilai-quality').value.trim();
    var taste   = document.getElementById('nilai-taste').value.trim();
    if (!quality && !taste) { nilaiShowToast('Tulis ulasan terlebih dahulu'); return; }

    var formData = new FormData();
    formData.append('rating',  nilaiRating);
    formData.append('quality', quality);
    formData.append('taste',   taste);
    document.querySelectorAll('.nilai-upload-btn input[type="file"]').forEach(function (inp) {
        Array.from(inp.files).forEach(function (f) {
            formData.append(inp.accept.startsWith('video') ? 'videos[]' : 'photos[]', f);
        });
    });

    fetch('/sghwebv2/ec/costumer/page/submit_review.php', {
        method: 'POST',
        body:   formData
    })
    .then(function (res)  { return res.json(); })
    .then(function (data) {
        if (data.success) {
            nilaiShowToast('Ulasan berhasil dikirim! Terima kasih 🎉');
            setTimeout(closeNilaiPopup, 1500);
        } else {
            nilaiShowToast('Gagal: ' + (data.message || 'Coba lagi'));
        }
    })
    .catch(function () { nilaiShowToast('Koneksi gagal, coba lagi'); });
}

document.addEventListener('DOMContentLoaded', function () {
    nilaiRenderStars(0);
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeNilaiPopup();
    });
});


//INVOICE
    async function printInvoice(nomor_pesanan) {
        try {
            const baseUrl = window.location.origin + '/sghwebv2/ec/admin/crud/pesananController.php';

            let res = await fetch(`${baseUrl}?action=get_detail&nomor_pesanan=${nomor_pesanan}`);
            let data = await res.json();

            let itemsHTML = '';
            let total = 0;

            data.items.forEach(item => {
                let subtotal = item.kuantitas * item.harga;
                total += subtotal;

                itemsHTML += `
                <tr>
                    <td>${item.nama_produk}</td>
                    <td>${item.kuantitas}</td>
                    <td>Rp ${parseInt(item.harga).toLocaleString()}</td>
                    <td>Rp ${parseInt(subtotal).toLocaleString()}</td>
                </tr>
            `;
            });

            let html = `
        <html>
        <head>
            <title>Invoice ${data.nomor_pesanan}</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    padding: 30px;
                    color: #333;
                }
                .header {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: 30px;
                }
                .title {
                    font-size: 24px;
                    font-weight: bold;
                }
                .box {
                    margin-bottom: 20px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 10px;
                }
                th, td {
                    border: 1px solid #ddd;
                    padding: 10px;
                    text-align: left;
                }
                th {
                    background: #f5f5f5;
                }
                .text-end {
                    text-align: right;
                }
                .total {
                    font-size: 18px;
                    font-weight: bold;
                }
                .footer {
                    margin-top: 40px;
                    text-align: center;
                    font-size: 12px;
                    color: #777;
                }
                @media print {
                    button { display: none; }
                }
            </style>
        </head>

        <body>

            <div class="header">
                <div>
                    <div class="title">INVOICE</div>
                    <div>No: ${data.nomor_pesanan}</div>
                    <div>Tanggal: ${data.tanggal_order}</div>
                </div>
                <div>
                    <strong>Smart Greenhouse</strong><br>
                    Agrinexa Store
                </div>
            </div>

            <div class="box">
                <strong>Dikirim ke:</strong><br>
                ${data.nama}<br>
                ${data.alamat ?? '-'}
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    ${itemsHTML}
                </tbody>
            </table>

            <table style="margin-top:20px;">
                <tr>
                    <td class="text-end total">Total</td>
                    <td class="text-end total">Rp ${total.toLocaleString()}</td>
                </tr>
            </table>

            <div class="footer">
                Terima kasih telah berbelanja 🌱
            </div>

            <scrip>
                window.print();
                window.onafterprint = () => window.close();
            <\/script>

        </body>
        </html>
        `;

            let printWindow = window.open('', '', 'width=900,height=700');
            printWindow.document.write(html);
            printWindow.document.close();

        } catch (error) {
            console.error("Error:", error);
        }
    }
