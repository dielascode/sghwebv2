<?php
error_reporting(0);      // tambah ini
ini_set('display_errors', 0);  // dan ini
// HAPUS error_reporting dan echo debug
session_name('sghwebv2_session');
session_start();

require_once __DIR__ . '/../../config/connection.php';

$db = new Database();
$conn = $db->getConnection();

if (!isset($_SESSION['id'])) {
    header("Location: ../../index.php");
    exit;
}

$id_costumer = $_SESSION['id'];

$query = mysqli_query($conn, "
    SELECT 
        users.*,
        costumer.jenis_kelamin,
        costumer.foto_profil
    FROM users
    LEFT JOIN costumer 
        ON users.id = costumer.id_costumer
    WHERE users.id = '$id_costumer'
");

$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Data user tidak ditemukan");
}

?>

<body>

    <div class="container-pesanan d-flex">

        <!-- SIDEBAR -->
        <?php include __DIR__ . "/../elemen/sidebar_profil.php"; ?>

        <main class="content-profil" style="margin-top: 80px;">

            <!-- HEADER -->
            <div class="header-content">

                <h1>Informasi Akun</h1>

                <p>
                    Kelola Informasi profil Anda untuk mengontrol,
                    melindungi dan mengamankan akun
                </p>

            </div>

            <!-- =====================================
                 PROFILE GRID
                 ===================================== -->
            <div class="profile-grid">

                <!-- =====================================
                     FORM UPLOAD FOTO
                     ===================================== -->
                <form action="logic/costumer/fotoProfileApi.php" method="POST"
                    enctype="multipart/form-data" class="card-profil photo-card" id="uploadFotoForm">

                    <div class="photo-container">

                        <?php
                        $foto = !empty($data['foto_profil'])
                            ? "../asset/image/profile/" . $data['foto_profil']
                            : "../asset/image/Anonim.jpg";
                        ?>

                        <img src="<?= $foto ?>" alt="Foto Profil">

                    </div>

                    <p class="display-name">
                        <?= $data['username']; ?>
                    </p>

                    <!-- BUTTON GANTI FOTO -->
                    <label for="upload-photo" class="btn-photo">

                        <i class="fa-solid fa-camera"></i>

                        Ganti Foto

                    </label>

                    <!-- INPUT FILE -->
                    <input type="file" id="upload-photo" name="profile_image" accept="image/*" hidden onchange="document.getElementById('uploadFotoForm').submit();">
                    

                </form>

                <!-- =====================================
                     FORM EDIT PROFILE
                     ===================================== -->
                <form action="logic/costumer/profileApi.php" method="POST">

                    <div class="ps-card">

                        <!-- HEADER -->
                        <div class="ps-head">

                            <p class="ps-title">
                                Profil Saya
                            </p>

                            <button type="button" class="ps-edit-btn" id="editBtn" onclick="toggleEdit()">

                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">

                                    <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" />

                                    <path d="M18.5 2.5a2.12 2.12 0 013 3L12 15l-4 1 1-4z" />

                                </svg>

                                Edit Profil

                            </button>

                        </div>

                        <div class="ps-divider"></div>

                        <!-- =====================================
                             VIEW MODE
                             ===================================== -->
                        <div class="ps-fields" id="viewMode">

                            <div class="ps-row">

                                <span class="ps-row__label">
                                    Username
                                </span>

                                <span class="ps-row__value" id="v-username">
                                    <?= $data['username']; ?>
                                </span>

                            </div>

                            <div class="ps-row">

                                <span class="ps-row__label">
                                    Nama Lengkap
                                </span>

                                <span class="ps-row__value" id="v-nama">
                                    <?= $data['nama']; ?>
                                </span>

                            </div>

                            <div class="ps-row">

                                <span class="ps-row__label">
                                    Email
                                </span>

                                <span class="ps-row__value" id="v-email">
                                    <?= $data['email']; ?>
                                </span>

                            </div>

                            <div class="ps-row">

                                <span class="ps-row__label">
                                    Nomor Telepon
                                </span>

                                <span class="ps-row__value" id="v-telepon">
                                    <?= $data['nomor_telepon']; ?>
                                </span>

                            </div>

                            <div class="ps-row">

                                <span class="ps-row__label">
                                    Jenis Kelamin
                                </span>

                                <span class="ps-pill" id="v-gender">

                                    <?php
                                    if ($data['jenis_kelamin'] == 'l') {

                                        echo 'Laki-Laki';

                                    } elseif ($data['jenis_kelamin'] == 'p') {

                                        echo 'Perempuan';

                                    } else {

                                        echo '-';

                                    }
                                    ?>

                                </span>

                            </div>

                        </div>

                        <!-- =====================================
                             EDIT MODE
                             ===================================== -->
                        <div id="editMode" style="display:none;">

                            <div class="ps-fields">

                                <!-- USERNAME -->
                                <div class="ps-edit-row">

                                    <span class="ps-edit-row__label">
                                        Username
                                    </span>

                                    <input class="ps-input" name="username" id="e-username" type="text"
                                        value="<?= $data['username']; ?>" />

                                </div>

                                <!-- NAMA -->
                                <div class="ps-edit-row">

                                    <span class="ps-edit-row__label">
                                        Nama Lengkap
                                    </span>

                                    <input class="ps-input" name="nama" id="e-nama" type="text"
                                        value="<?= $data['nama']; ?>" />

                                </div>

                                <!-- EMAIL -->
                                <div class="ps-edit-row">

                                    <span class="ps-edit-row__label">
                                        Email
                                    </span>

                                    <input class="ps-input" name="email" id="e-email" type="email"
                                        value="<?= $data['email']; ?>" />

                                </div>

                                <!-- TELEPON -->
                                <div class="ps-edit-row">

                                    <span class="ps-edit-row__label">
                                        Nomor Telepon
                                    </span>

                                    <input class="ps-input" name="nomor_telepon" id="e-telepon" type="text"
                                        value="<?= $data['nomor_telepon']; ?>" />

                                </div>

                                <!-- GENDER -->
                                <div class="ps-edit-row">

                                    <span class="ps-edit-row__label">
                                        Jenis Kelamin
                                    </span>

                                    <div class="ps-gender-wrap">

                                        <!-- LAKI-LAKI -->
                                        <label class="ps-radio">

                                            <input type="radio" name="jenis_kelamin" value="l"
                                                <?= ($data['jenis_kelamin'] == 'l') ? 'checked' : ''; ?>>

                                            Laki-laki

                                        </label>

                                        <!-- PEREMPUAN -->
                                        <label class="ps-radio">

                                            <input type="radio" name="jenis_kelamin" value="p"
                                                <?= ($data['jenis_kelamin'] == 'p') ? 'checked' : ''; ?>>

                                            Perempuan

                                        </label>

                                    </div>

                                </div>

                                <!-- ACTION -->
                                <div class="ps-actions">

                                    <button type="button" class="ps-btn ps-btn--ghost" onclick="toggleEdit()">

                                        Batal

                                    </button>

                                    <button type="submit" class="ps-btn ps-btn--primary">

                                        Simpan Perubahan

                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>

                </form>

            </div>

        </main>

    </div>

    <!-- =====================================
         SCRIPT
         ===================================== -->
    <script>

        let editing = false;

        function toggleEdit() {

            editing = !editing;

            document.getElementById('viewMode').style.display =
                editing ? 'none' : 'flex';

            document.getElementById('editMode').style.display =
                editing ? 'block' : 'none';

            const btn = document.getElementById('editBtn');

            if (editing) {

                btn.innerHTML = 'Batal';
                btn.classList.add('cancel');

            } else {

                btn.innerHTML = 'Edit Profil';
                btn.classList.remove('cancel');
            }
        }

    </script>

</body>