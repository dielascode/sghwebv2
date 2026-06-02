

var nilaiRating = 0;

var nilaiLabels = [
    '',
    'Kurang baik',
    'Cukup',
    'Baik',
    'Sangat baik',
    'Luar biasa'
];

function openNilaiPopup(namaProduk, imgSrc, nomorPesanan) {

    nilaiRating = 0;

    nilaiRenderStars(0);

    document.getElementById('nilai-rating-desc').textContent = '';

    document.getElementById('nilai-quality').value = '';

    document.getElementById('nilai-preview-area').innerHTML = '';

    document.getElementById('nilai-nama').textContent = namaProduk || '-';

    document.getElementById('nilai-img').src = imgSrc || '';

    document.getElementById('nilai-nomor-pesanan').value = nomorPesanan;

    document.getElementById('overlay-nilai').classList.add('active');

    document.body.style.overflow = 'hidden';
}

function closeNilaiPopup() {
    document.getElementById('overlay-nilai').classList.remove('active');
    document.body.style.overflow = '';
}

function handleNilaiOverlay(e) {
    if (e.target === document.getElementById('overlay-nilai')) {
        closeNilaiPopup();
    }
}

function nilaiSetRating(val) {
    nilaiRating = val;
    nilaiRenderStars(val);
    document.getElementById('nilai-rating-desc').textContent =
        nilaiLabels[val];
}

function nilaiHover(val) {
    nilaiRenderStars(val);
}

function nilaiResetHover() {
    nilaiRenderStars(nilaiRating);
}

function nilaiRenderStars(val) {
    document.querySelectorAll('.nilai-star').forEach(function (s, i) {
        s.classList.toggle('active', i < val);
    });
}

function nilaiHandleFiles(input) {

    var area = document.getElementById('nilai-preview-area');

    Array.from(input.files).forEach(function (file) {

        var url = URL.createObjectURL(file);

        var wrap = document.createElement('div');

        wrap.className = 'nilai-thumb';

        var img = document.createElement('img');

        img.src = url;

        wrap.appendChild(img);

        var del = document.createElement('button');

        del.className = 'del-btn';

        del.textContent = '✕';

        del.onclick = function () {

            area.removeChild(wrap);

        };

        wrap.appendChild(del);

        area.appendChild(wrap);

    });

    // HAPUS BARIS INI
    // input.value = '';
}

function nilaiShowToast(msg) {
    var t = document.getElementById('nilai-toast');
    t.textContent = msg;
    t.style.display = 'block';
    setTimeout(function () {
        t.style.display = 'none';
    }, 2500);
}

function nilaiSubmit() {

    if (!nilaiRating) {
        nilaiShowToast('Pilih bintang terlebih dahulu');
        return;
    }

    let komentar = document
        .getElementById('nilai-quality')
        .value
        .trim();

    if (!komentar) {
        nilaiShowToast('Isi deskripsi terlebih dahulu');
        return;
    }

    let nomorPesanan = document.getElementById('nilai-nomor-pesanan').value;

    let formData = new FormData();

    formData.append('rating', nilaiRating);
    formData.append('komentar', komentar);
    formData.append('nomor_pesanan', nomorPesanan);

    // FOTO
    let photoInput = document.getElementById('nilai-photo');

    if (photoInput.files.length > 0) {

        Array.from(photoInput.files).forEach(file => {
            formData.append('photos[]', file);
        });

    }
    console.log(photoInput.files);
    fetch('./../logic/costumer/reviewApi.php', {
        method: 'POST',
        body: formData
    })

        .then(res => res.json())

        .then(data => {

            if (data.status) {

                nilaiShowToast('Review berhasil dikirim');

                setTimeout(() => {
                    closeNilaiPopup();
                    location.reload();
                }, 1500);

            } else {

                nilaiShowToast(data.message);

            }

        })

        .catch(err => {

            console.log(err);

            nilaiShowToast('Terjadi kesalahan');

        });

}

document.addEventListener('DOMContentLoaded', function () {

    nilaiRenderStars(0);

    document.addEventListener('keydown', function (e) {

        if (e.key === 'Escape') {

            closeNilaiPopup();

        }

    });

});


//INVOICE
async function printInvoice(nomor_pesanan) {

    try {

        const baseUrl = window.location.origin + '/admin/crud/pesananController.php';

        let res = await fetch(
            `${baseUrl}?action=get_detail&nomor_pesanan=${nomor_pesanan}`
        );

        let data = await res.json();

        let alamatText = '-';

        try {

            let alamatObj = JSON.parse(data.alamat);

            alamatText =
                `${alamatObj.jalan}, ` +
                `${alamatObj.kelurahan}, ` +
                `${alamatObj.kecamatan}, ` +
                `${alamatObj.kota}, ` +
                `${alamatObj.provinsi}`;

            if (alamatObj.detail) {

                alamatText =
                    `${alamatObj.jalan}, ${alamatObj.detail}, ` +
                    `${alamatObj.kelurahan}, ${alamatObj.kecamatan}, ` +
                    `${alamatObj.kota}, ${alamatObj.provinsi}`;

            }

        } catch (e) {

            alamatText = data.alamat ?? '-';

        }

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

        // STATUS STYLE
        let statusText = '';
        let statusColor = '#2e7d32';
        let statusBg = '#e8f5e9';

        if (data.status == 'menunggu_konfirmasi') {

            statusText = 'Menunggu Konfirmasi';
            statusColor = '#966238';
            statusBg = '#fff3e0';

        } else if (data.status == 'diproses') {

            statusText = 'Sedang Diproses';
            statusColor = '#1565c0';
            statusBg = '#e3f2fd';

        } else if (data.status == 'dikirim') {

            statusText = 'Sedang Dikirim';
            statusColor = '#6a1b9a';
            statusBg = '#f3e5f5';

        } else if (data.status == 'selesai') {

            statusText = 'Selesai';
            statusColor = '#2e7d32';
            statusBg = '#e8f5e9';

        } else if (data.status == 'dibatalkan') {

            statusText = 'Dibatalkan';
            statusColor = '#c62828';
            statusBg = '#ffebee';

        } else {

            statusText = data.status;

        }

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
                    align-items: flex-start;
                    margin-bottom: 30px;
                }

                .title {
                    font-size: 24px;
                    font-weight: bold;
                    margin-bottom: 10px;
                }

                .box {
                    margin-bottom: 20px;
                    line-height: 1.7;
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

                .status-badge {
                    margin-top: 12px;
                    display: inline-block;
                    padding: 7px 16px;
                    border-radius: 20px;
                    font-size: 13px;
                    font-weight: bold;
                }

                .footer {
                    margin-top: 40px;
                    text-align: center;
                    font-size: 12px;
                    color: #777;
                }

                @media print {
                    button {
                        display: none;
                    }
                }

            </style>

        </head>

        <body>

            <div class="header">

                <div>

                    <div class="title">INVOICE</div>

                    <div>
                        <strong>No:</strong> ${data.nomor_pesanan}
                    </div>

                    <div>
                        <strong>Tanggal:</strong> ${data.tanggal_order}
                    </div>

                    <div 
                        class="status-badge"
                        style="
                            background:${statusBg};
                            color:${statusColor};
                        "
                    >
                        Status: ${statusText}
                    </div>

                </div>

                <div style="text-align:right;">

                    <strong style="font-size:18px;">
                        Smart Greenhouse
                    </strong>
                    <br>

                    Agrinexa Store

                </div>

            </div>

            <div class="box">

                <strong>Dikirim ke:</strong><br>

                ${data.nama}<br>

                ${alamatText}

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

                    <td class="text-end total">
                        Total
                    </td>

                    <td class="text-end total">
                        Rp ${total.toLocaleString()}
                    </td>

                </tr>

            </table>

            <div class="footer">

                Terima kasih telah berbelanja 🌱

            </div>

        </body>

        </html>
        `;

        let printWindow = window.open(
            '',
            '',
            'width=900,height=700'
        );

        printWindow.document.write(html);

        printWindow.document.close();

        printWindow.focus();

        printWindow.onload = function () {

            printWindow.print();

            printWindow.onafterprint = () => printWindow.close();

        };

    } catch (error) {

        console.error("Error:", error);

    }
}

//Pindah Pesanan Selesai
async function selesaikanPesanan(nomor_pesanan) {

    let konfirmasi = confirm(
        "Apakah Anda yakin pesanan sudah selesai?"
    );

    if (!konfirmasi) return;

    try {

        const response = await fetch(
            `./../costumer/controller/pesananSelesaiController.php?action=selesai&nomor_pesanan=${nomor_pesanan}`
        );

        const text = await response.text();

        console.log(text);

        const result = JSON.parse(text);

        if (result.status) {

            alert(result.message);

            location.reload();

        } else {

            alert(result.message);

        }

    } catch (error) {

        console.error(error);

        alert(error);

    }
}