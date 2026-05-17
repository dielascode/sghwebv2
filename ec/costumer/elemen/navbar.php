<?php
$totalQty = 0;

if (isset($_SESSION['cart'])) {
  foreach ($_SESSION['cart'] as $item) {
    $totalQty++;
  }
}

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../config/connection.php';

$db = new Database();
$conn = $db->getConnection();

$id_costumer = $_SESSION['id'] ?? null;

if ($id_costumer) {
    $userQuery = mysqli_prepare($conn, "
        SELECT users.username, costumer.foto_profil
        FROM costumer
        JOIN users 
        ON users.id = costumer.id_costumer
        WHERE costumer.id_costumer = ?
    ");
    mysqli_stmt_bind_param($userQuery, "s", $id_costumer);
    mysqli_stmt_execute($userQuery);
    $userResult = mysqli_stmt_get_result($userQuery);
    $user = mysqli_fetch_assoc($userResult);
}
?>

<!-- NAVBAR -->
<header class="bg-[#1C2B10] shadow-sm text-[#C8D8A8] w-full fixed top-0 left-0 right-0 z-50">
  <div class="w-full px-4 md:px-8">
    <div class="flex h-16 items-center justify-between">

      <!-- LOGO -->
      <div>
        <img src="/sghwebv2/ec/images/logosghputih.png" class="h-14 w-auto object-contain">
      </div>

      <!-- NAV DESKTOP -->
      <nav class="hidden absolute left-1/2 -translate-x-1/2 md:flex items-center h-16">
        <ul class="flex items-center gap-3 text-sm h-full">
          <li>
            <a class="nav-link" href="../../sghwebv2/index.php">Beranda</a>
          </li>
          <li>
            <a class="nav-link" href="#" onclick="loadPage('costumer/page/katalog.php')">Produk</a>
          </li>
          <li>
            <a class="cart-nav-icon flex items-center gap-2 no-underline text-[#C8D8A8] opacity-70 hover:opacity-100 transition-opacity duration-200"
              href="#" onclick="loadPage('costumer/page/keranjang.php')">
              <div class="cart-icon-wrapper">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 6h13M7 13L5.4 5M10 21a1 1 0 100-2 1 1 0 000 2zm7 0a1 1 0 100-2 1 1 0 000 2z" />
                </svg>
                <?php if ($totalQty > 0): ?>
                  <span class="cart-badge"><?= $totalQty ?></span>
                <?php endif; ?>
              </div>
            </a>
          </li>
        </ul>
      </nav>

      <!-- KANAN: Profile (desktop) + Hamburger (mobile) -->
      <div class="flex items-center gap-3">

        <!-- PROFILE DESKTOP -->
        <div class="relative hidden md:inline-block">
          <button id="profileBtn" class="flex items-center justify-start w-52 px-3 py-2 rounded-lg">
            <div class="flex items-center gap-3">
              <div class="rounded-full overflow-hidden w-8 h-8 bg-gray-200">
                <img src="/sghwebv2/asset/image/profile/<?= $user['foto_profil'] ?? 'Anonim.jpg' ?>" class="w-full h-full object-cover">
              </div>
              <span class="text-[#C8D8A8] font-medium text-base">
                <?= $user['username'] ?? 'User'; ?>
              </span>
            </div>
            <svg class="w-4 h-4 text-[#C8D8A8] ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
          </button>

          <!-- DROPDOWN DESKTOP -->
          <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-md">
            <div class="py-2 text-black">
              <a href="#" onclick="loadPage('/sghwebv2/ec/costumer/page/profile.php')"
                class="flex items-center gap-3 px-4 py-2 text-sm hover:bg-gray-100 no-underline text-black">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <circle cx="12" cy="8" r="4" stroke-width="1.8" />
                  <path stroke-width="1.8" stroke-linecap="round" d="M4 20c0-3.314 3.582-6 8-6s8 2.686 8 6" />
                </svg>
                Profil
              </a>
              <a href="#" onclick="loadPage('/sghwebv2/ec/costumer/page/pesanan.php')"
                class="flex items-center gap-3 px-4 py-2 text-sm hover:bg-gray-100 no-underline text-black">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-width="1.8" stroke-linecap="round"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" />
                  <rect x="9" y="3" width="6" height="4" rx="1" stroke-width="1.8" />
                  <path stroke-width="1.8" stroke-linecap="round" d="M9 12h6M9 16h4" />
                </svg>
                Pesanan
              </a>
              <a href="#" onclick="loadPage('/sghwebv2/ec/costumer/page/pengaduan.php')"
                class="flex items-center gap-3 px-4 py-2 text-sm hover:bg-gray-100 no-underline text-black">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-width="1.8" stroke-linecap="round"
                    d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                Pengaduan
              </a>
              <a href="../../sghwebv2/ec/logoutCostumer.php"
                class="flex items-center gap-3 px-4 py-2 text-sm text-red-600 hover:bg-red-50 no-underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-width="1.8" stroke-linecap="round" d="M17 16l4-4m0 0l-4-4m4 4H7" />
                  <path stroke-width="1.8" stroke-linecap="round" d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4" />
                </svg>
                Logout
              </a>
            </div>
          </div>
        </div>

        <!-- CART MOBILE (tampil di mobile saja) -->
        <a class="md:hidden relative text-[#C8D8A8] opacity-80"
          href="#" onclick="loadPage('costumer/page/keranjang.php')">
          <div class="cart-icon-wrapper">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 6h13M7 13L5.4 5M10 21a1 1 0 100-2 1 1 0 000 2zm7 0a1 1 0 100-2 1 1 0 000 2z" />
            </svg>
            <span class="cart-badge <?= $totalQty <= 0 ? 'hidden' : '' ?>">
    <?= $totalQty ?>
</span>
          </div>
        </a>

        <!-- HAMBURGER BUTTON (mobile) -->
        <button id="hamburgerBtn" class="md:hidden flex flex-col justify-center items-center w-9 h-9 gap-[5px] rounded-lg focus:outline-none" aria-label="Menu">
          <span class="hamburger-bar"></span>
          <span class="hamburger-bar"></span>
          <span class="hamburger-bar"></span>
        </button>

      </div>
    </div>
  </div>

  <!-- MOBILE DROPDOWN MENU -->
  <div id="mobileMenu" class="mobile-menu-dropdown md:hidden">
    <div class="mobile-menu-inner">

      <!-- Info user -->
      <div class="mobile-user-info">
        <div class="rounded-full overflow-hidden w-10 h-10 bg-gray-200 flex-shrink-0">
          <img src="/sghwebv2/asset/image/profile/<?= $user['foto_profil'] ?? 'Anonim.jpg' ?>" class="w-full h-full object-cover">
        </div>
        <div>
          <p class="text-[#C8D8A8] font-semibold text-sm"><?= $user['username'] ?? 'User' ?></p>
          <p class="text-[#8aaa6a] text-xs">Customer</p>
        </div>
      </div>

      <div class="mobile-menu-divider"></div>

      <!-- Nav links -->
      <nav class="mobile-nav">
        <a href="../../sghwebv2/ec/logoutCostumer.php" class="mobile-nav-link">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-width="1.8" stroke-linecap="round" d="M3 12h18M3 6h18M3 18h18"/>
          </svg>
          Beranda
        </a>
        <a href="#" onclick="loadPage('costumer/page/katalog.php'); closeMobileMenu()" class="mobile-nav-link">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-width="1.8" stroke-linecap="round" d="M20 7H4a1 1 0 00-1 1v10a1 1 0 001 1h16a1 1 0 001-1V8a1 1 0 00-1-1zM16 3H8l-1 4h10l-1-4z"/>
          </svg>
          Produk
        </a>
        <a href="#" onclick="loadPage('/sghwebv2/ec/costumer/page/profile.php'); closeMobileMenu()" class="mobile-nav-link">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <circle cx="12" cy="8" r="4" stroke-width="1.8"/>
            <path stroke-width="1.8" stroke-linecap="round" d="M4 20c0-3.314 3.582-6 8-6s8 2.686 8 6"/>
          </svg>
          Profil
        </a>
        <a href="#" onclick="loadPage('/sghwebv2/ec/costumer/page/pesanan.php'); closeMobileMenu()" class="mobile-nav-link">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-width="1.8" stroke-linecap="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
            <rect x="9" y="3" width="6" height="4" rx="1" stroke-width="1.8"/>
            <path stroke-width="1.8" stroke-linecap="round" d="M9 12h6M9 16h4"/>
          </svg>
          Pesanan
        </a>
        <a href="#" onclick="loadPage('/sghwebv2/ec/costumer/page/pengaduan.php'); closeMobileMenu()" class="mobile-nav-link">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-width="1.8" stroke-linecap="round"
              d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
          </svg>
          Pengaduan
        </a>
      </nav>

      <div class="mobile-menu-divider"></div>

      <!-- Logout -->
      <a href="../../sghwebv2/ec/logoutCostumer.php" class="mobile-logout">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-width="1.8" stroke-linecap="round" d="M17 16l4-4m0 0l-4-4m4 4H7"/>
          <path stroke-width="1.8" stroke-linecap="round" d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/>
        </svg>
        Logout
      </a>

    </div>
  </div>
</header>


<style>
/* =====================
   GLOBAL LINK FIX
   ===================== */
header a {
  text-decoration: none !important;
  color: inherit !important;
}

/* =====================
   NAV LINK DESKTOP
   ===================== */
.nav-link {
  display: flex;
  align-items: center;
  height: 100%;
  color: #C8D8A8;
  font-weight: 500;
  font-size: 1rem;
  text-decoration: none !important;
  position: relative;
}

.nav-link::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  height: 2px;
  width: 0;
  background: #C8D8A8;
  transition: width 0.3s ease;
}

.nav-link:hover::after {
  width: 100%;
}

/* =====================
   CART BADGE
   ===================== */
.cart-icon-wrapper {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
}

.cart-badge {
  position: absolute;
  top: -6px;
  right: -8px;
  min-width: 18px;
  height: 18px;
  padding: 0 5px;
  border-radius: 999px;
  background: #C8D8A8;
  color: #1C2B10;
  font-size: 10px;
  font-weight: 700;
  display: flex;
  align-items: center;
  justify-content: center;
  border: 2px solid #1C2B10;
  box-shadow: 0 2px 10px rgba(0,0,0,.15);
  animation: popBadge 0.2s ease;
}

@keyframes popBadge {
  0%  { transform: scale(0.7); opacity: 0; }
  100%{ transform: scale(1);   opacity: 1; }
}

/* =====================
   HAMBURGER BUTTON
   ===================== */
.hamburger-bar {
  display: block;
  width: 22px;
  height: 2px;
  background: #C8D8A8;
  border-radius: 2px;
  transition: transform 0.25s ease, opacity 0.25s ease;
  transform-origin: center;
}

/* Animasi X saat terbuka */
#hamburgerBtn.open .hamburger-bar:nth-child(1) {
  transform: translateY(7px) rotate(45deg);
}
#hamburgerBtn.open .hamburger-bar:nth-child(2) {
  opacity: 0;
  transform: scaleX(0);
}
#hamburgerBtn.open .hamburger-bar:nth-child(3) {
  transform: translateY(-7px) rotate(-45deg);
}

/* =====================
   MOBILE DROPDOWN MENU
   ===================== */
.mobile-menu-dropdown {
  overflow: hidden;
  max-height: 0;
  transition: max-height 0.35s ease, opacity 0.3s ease;
  opacity: 0;
  background: #1C2B10;
  border-top: 1px solid rgba(200, 216, 168, 0.15);
}

.mobile-menu-dropdown.open {
  max-height: 500px;
  opacity: 1;
}

.mobile-menu-inner {
  padding: 16px;
  display: flex;
  flex-direction: column;
  gap: 4px;
}

/* User info */
.mobile-user-info {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 6px 0 12px;
}

/* Divider */
.mobile-menu-divider {
  height: 1px;
  background: rgba(200, 216, 168, 0.15);
  margin: 6px 0;
}

/* Nav links */
.mobile-nav {
  display: flex;
  flex-direction: column;
  gap: 2px;
}

.mobile-nav-link {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px 12px;
  border-radius: 10px;
  color: #C8D8A8 !important;
  font-size: 14px;
  font-weight: 500;
  text-decoration: none !important;
  transition: background 0.15s ease;
}

.mobile-nav-link:hover {
  background: rgba(200, 216, 168, 0.1);
}

/* Logout */
.mobile-logout {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px 12px;
  border-radius: 10px;
  color: #f87171 !important;
  font-size: 14px;
  font-weight: 500;
  text-decoration: none !important;
  transition: background 0.15s ease;
  margin-top: 4px;
}

.mobile-logout:hover {
  background: rgba(248, 113, 113, 0.1);
}
</style>


<script>
document.addEventListener('DOMContentLoaded', function () {
  updateCartBadge();

  /* ---- Profile dropdown (desktop) ---- */
  const profileBtn  = document.getElementById('profileBtn');
  const dropdownMenu = document.getElementById('dropdownMenu');

  if (profileBtn && dropdownMenu) {
    profileBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      dropdownMenu.classList.toggle('hidden');
    });

    document.addEventListener('click', (e) => {
      if (!profileBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
        dropdownMenu.classList.add('hidden');
      }
    });
  }

  /* ---- Hamburger menu (mobile) ---- */
  const hamburgerBtn = document.getElementById('hamburgerBtn');
  const mobileMenu   = document.getElementById('mobileMenu');

  hamburgerBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    hamburgerBtn.classList.toggle('open');
    mobileMenu.classList.toggle('open');
  });

  // Tutup saat klik di luar
  document.addEventListener('click', (e) => {
    if (!hamburgerBtn.contains(e.target) && !mobileMenu.contains(e.target)) {
      closeMobileMenu();
    }
  });
});

function closeMobileMenu() {
  const hamburgerBtn = document.getElementById('hamburgerBtn');
  const mobileMenu   = document.getElementById('mobileMenu');
  if (hamburgerBtn) hamburgerBtn.classList.remove('open');
  if (mobileMenu)   mobileMenu.classList.remove('open');
}
</script>