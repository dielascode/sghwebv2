 <?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../config/connection.php';

$db = new Database();
$conn = $db->getConnection();

echo "CONNECTION JALAN <br>";

if (!isset($_SESSION['id_user'])) {

    echo "SESSION TIDAK ADA";
    exit;
}

echo "SESSION ADA <br>";

$id_user = $_SESSION['id_user'];

echo "ID USER : " . $id_user;

// ambil data profile
$query = mysqli_query($conn, "
    SELECT 
        users.*,
        costumer.jenis_kelamin,
        costumer.foto_profil
    FROM users
    LEFT JOIN costumer 
        ON users.id = costumer.id_costumer
    WHERE users.id = '$id_user'
");

$data = mysqli_fetch_assoc($query);


if (!$data) {
    die("Data user tidak ditemukan");
}
?>
 
 <aside class="sidebar-profil">
 
    <div class="sidebar-profil__header">
      <img class="sidebar-profil__avatar" src="<?= $data['foto_profil'] ?? '/sghwebv2/ec/images/Anonim.jpg' ?>" alt="Avatar" />
      <div class="sidebar-profil__info">
        <p class="sidebar-profil__name"><?= $data['nama'] ?></p>
        <p class="sidebar-profil__sub">Jember, East Java</p>
      </div>
    </div>
 
    <div class="sidebar-menu-profil">
    <p class="menu-title-profil">AKUN SAYA</p>

    <a href="#" onclick="loadPage('costumer/page/profile.php')" class="menu-item-profil ">
        <i class="fa-solid fa-user"></i>
        <span>Profil</span>
    </a>

    <a href="#" onclick="loadPage('costumer/page/alamatcustomer.php')" class="menu-item-profil">
        <i class="fa-solid fa-location-dot"></i>
        <span>Alamat</span>
    </a>

    <a href="#" onclick="loadPage('costumer/page/ubahPassword.php')" class="menu-item-profil">
        <i class="fa-solid fa-lock"></i>
        <span>Ubah Password</span>
    </a>

    <div class="divider-profil"></div>

   
</div>
  </aside>
 
