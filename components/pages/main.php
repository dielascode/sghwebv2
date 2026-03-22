<section class="banner-beranda">
    <div class="container-beranda">
        <div class="desc-main">
            <p class="sub-tag">Selamat Datang</p>
            <h1 class="judul">SMART GREEN HOUSE</h1>
            <h1 class="judul">POLITEKNIK NEGERI JEMBER</h1>
            <p>Smart Green House Politeknik Negeri Jember merupakan inovasi pertanian modern berbasis teknologi yang
                dirancang untuk mendukung kegiatan pembelajaran, penelitian, serta pengabdian masyarakat. Kami berfokus
                pada
                sistem pertanian berkelanjutan yang efisien, ramah lingkungan, dan berbasis Internet of Things (IoT).
            </p>
        </div>
        <div class="btn-main">
            <button class="btn-main-hijau"><a href="#tentang-beranda">Selengkapnya</a></button>
            <button class="btn-main-hijau2"><a href="#" onclick="loadPage('components/pages/hubungi.php')">Hubungi Kami</a></button>
        </div>
    </div>
</section>
<section id="tentang-beranda">
    <div class="tentang-beranda-left">
        <div class="tentang-beranda-left-left">
            <img class="image-satu d-none d-lg-block" src="/images/beranda/beranda2.png" alt="" srcset="">
            <img class="image-dua d-none d-lg-block" src="/images/beranda/beranda3.png" alt="" srcset="">
        </div>
        <div class="tentang-beranda-left-right d-none d-lg-block">
            <img src="/images/beranda/beranda1.png" alt="" srcset="">
        </div>
    </div>
    <div class="tentang-beranda-right">
        <h1>Tentang Kami</h1>
        <p>Smart Green House adalah fasilitas pertanian cerdas yang dikembangkan oleh Politeknik Negeri Jember. Sistem ini memanfaatkan teknologi otomatisasi seperti sensor suhu, kelembapan, serta penyiraman otomatis untuk memantau dan mengontrol pertumbuhan tanaman secara real time..</p>

        <button class="btn-main-hijau"><a href="#" onclick="loadPage('components/pages/tentang.php')">Selengkapnya</a></button>
    </div>
</section>
<section class="layanan-beranda">
    <div class="desc-layanan-beranda">
        <h1>Layanan <span>Green House</span>
            untuk Kebutuhan Ruang <span>Hijau</span> Kamu</h1>
        <p>Kami menyediakan berbagai layanan yang mendukung kegiatan pembelajaran, penelitian, dan pengembangan
            teknologi pertanian modern berbasis sistem Smart Greenhouse. Melalui layanan ini, kami berkomitmen untuk
            menciptakan lingkungan belajar yang inovatif dan aplikatif bagi mahasiswa maupun masyarakat.</p>
    </div>
    <div class="grid-layanan-beranda">
        <div class="layanan-child">
            <img src="/images/magang/Magang.png" alt="" srcset="">
            <div class="layanan-child-desc">
                <h2 class="judul-layanan-child">Layanan Magang</h2>
                <p>Program Magang di Smart Green House merupakan kesempatan 
                    bagi mahasiswa untuk memperoleh pengalaman langsung 
                    dalam penerapan teknologi pertanian modern berbasis I
                    nternet of Things (IoT). Melalui kegiatan ini, peserta 
                    akan belajar bagaimana sistem otomatisasi digunakan untuk 
                    memantau kondisi lingkungan, mengatur penyiraman tanaman, 
                    serta mengoptimalkan pertumbuhan tanaman secara berkelanjutan.</p>
                <button class="btn-main-hijau"><a href="#" onclick="loadPage('components/pages/layanan-magang.php')">Selengkapnya</a></button>
            </div>

        </div>
        <div class="layanan-child">
            <div class="layanan-child-desc">
                <h2 class="judul-layanan-child">Layanan Penelitian</h2>
                <p>Program Penelitian Smart Green House merupakan kesempatan 
                    berharga bagi mahasiswa untuk memperoleh pengalaman langsung 
                    dalam menjalankan metodologi riset dan eksperimen terapan 
                    di bidang pertanian cerdas berbasis Internet of Things (IoT).</p>
                <button class="btn-main-hijau"><a href="#" onclick="loadPage('components/pages/layanan-penelitian.php')">Selengkapnya</a></button>
            </div>
            <img src="/images/penelitian/Penelitian.png" alt="" srcset="">
        </div>
        <div class="layanan-child">
            <img src="/images/praktikum/Praktikum.png" alt="" srcset="">
            <div class="layanan-child-desc">
                <h2 class="judul-layanan-child">Layanan Praktikum</h2>
                <p>Program Praktikum Smart Green House menawarkan kesempatan 
                    hands-on bagi mahasiswa untuk menerapkan dan memverifikasi 
                    secara langsung konsep teknologi pertanian modern berbasis 
                    Internet of Things (IoT) yang telah dipelajari di kelas.</p>
                <button class="btn-main-hijau"><a href="#" onclick="loadPage('components/pages/layanan-praktik.php')">Selengkapnya</a></button>
            </div>
        </div>
        <div class="layanan-child">
            <div class="layanan-child-desc">
                <h2 class="judul-layanan-child">Layanan Studi Banding</h2>
                <p>Program Studi Banding Smart Green House merupakan kesempatan strategis 
                    bagi institusi atau kelompok profesional untuk mengamati secara 
                    langsung, membandingkan, dan mendokumentasikan penerapan teknologi 
                    pertanian modern berbasis Internet of Things (IoT) yang telah berhasil 
                    diimplementasikan.</p>
                <button class="btn-main-hijau"><a href="#" onclick="loadPage('components/pages/layanan-studibanding.php')">Selengkapnya</a></button>
            </div>
            <img src="/images/studibanding/kunjungan.jpg" alt="" srcset="">
        </div>
    </div>
</section>

<section class="contact-beranda">
    <div class="container-contact">
        <div class="contact-left">
            <h2 class="judul-contact">KONSULTASI GRATIS</h2>
            <p>Dapatkan layanan konsultasi gratis seputar teknologi Smart Greenhouse. Tim kami siap membantu menjawab
                pertanyaan Anda mengenai sistem, instalasi, maupun pengelolaannya.</p>
            <form onsubmit="sendToWA(event)">
                <div class="grid-contact-beranda">
                    <div>
                        <label for="">Nama</label>
                        <input type="text" name="" id="nama">
                    </div>
                    <div>
                        <label for="">Email</label>
                        <input type="text" name="" id="email">
                    </div>
                </div>
                <div class="tunggal-contact-beranda">
                    <label for="">Pesan</label>
                    <textarea name="" id="pesan" cols="20" rows="10"></textarea>
                </div>

                <button type="submit" class="btn-main-hijau">Kirim</button>
            </form>
        </div>
        <div class="faq-section">
            <h2>FAQ SMART<br>GREEN HOUSE</h2>
            <p class="faq-desc">
                Temukan jawaban dari pertanyaan yang sering diajukan tentang sistem Smart Greenhouse Politeknik Negeri
                Jember.
                Pelajari manfaat, cara kerja, serta perawatan teknologi pertanian cerdas ini.
            </p>

            <div class="accordion accordion-flush" id="accordionFlushExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                            Apa itu Smart Green House Polije?
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <p>Smart Green House adalah sistem rumah kaca modern yang dilengkapi dengan sensor dan
                                teknologi otomatisasi untuk mengatur suhu, kelembaban, cahaya, dan penyiraman tanaman
                                secara cerdas sehingga pertumbuhan tanaman lebih optimal.</p>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                            Apa keuntungan menggunakan Smart Green House dibandingkan rumah kaca biasa?
                        </button>
                    </h2>
                    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <p>Dengan Smart Green House, pemilik bisa menghemat waktu dan tenaga karena pengaturan
                                kondisi tanaman dilakukan secara otomatis. Selain itu, tanaman lebih terjaga
                                kesehatannya, hasil panen lebih maksimal, serta penggunaan air dan energi lebih efisien.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseThree" aria-expanded="false"
                            aria-controls="flush-collapseThree">
                            Apakah saya bisa memantau Smart Green House dari jarak jauh?
                        </button>
                    </h2>
                    <div id="flush-collapseThree" class="accordion-collapse collapse"
                        aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <p>Ya, Smart Green House dilengkapi dengan aplikasi berbasis web atau mobile yang
                                memungkinkan pengguna memantau kondisi tanaman secara real-time dan mengontrol sistem
                                dari mana saja.</p>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingfour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapsefour" aria-expanded="false"
                            aria-controls="flush-collapsefour">
                            Apakah Smart Green House bisa digunakan untuk semua jenis tanaman?
                        </button>
                    </h2>
                    <div id="flush-collapsefour" class="accordion-collapse collapse" aria-labelledby="flush-headingfour"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <p>Smart Green House dapat digunakan untuk berbagai jenis tanaman, terutama sayuran, buah,
                                dan tanaman hias. Namun, pengaturan sensor dan sistem perlu disesuaikan dengan kebutuhan
                                spesifik masing-masing tanaman.</p>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingfive">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapsefive" aria-expanded="false"
                            aria-controls="flush-collapsefive">
                            Bagaimana cara perawatan Smart Green House?
                        </button>
                    </h2>
                    <div id="flush-collapsefive" class="accordion-collapse collapse" aria-labelledby="flush-headingfive"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <p>Perawatannya cukup mudah. Pengguna hanya perlu memastikan sensor tetap bersih, melakukan
                                pengecekan rutin pada sistem otomatisasi, dan memperbarui software aplikasi jika ada
                                pembaruan. Sistem ini didesain agar awet dan mudah digunakan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>