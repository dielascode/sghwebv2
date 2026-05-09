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