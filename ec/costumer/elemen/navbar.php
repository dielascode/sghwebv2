<!-- NAVBAR -->
<header class="bg-[#1C2B10] shadow-sm text-[#C8D8A8] w-full fixed top-0 left-0 right-0 z-50">
  <div class="w-full px-4 md:px-8">
    <div class="flex h-16 items-center justify-between">

      <!-- LOGO -->
      <div>
        <img src="/sghwebv2/ec/images/logosghputih.png" class="h-14 w-auto object-contain">
      </div>

      <nav class="hidden absolute left-1/2 -translate-x-1/2 md:flex items-center h-16">
          <ul class="flex items-center gap-6 text-sm h-full">

            <li>
              <a class="flex items-center h-full text-[#C8D8A8] font-medium text-base !no-underline
       relative after:absolute after:bottom-0 after:left-0 after:h-[2px]
       after:w-0 after:bg-[#C8D8A8] after:transition-all after:duration-300
       hover:after:w-full"href="#">Beranda</a>
            </li>

            <li>
              <a class="flex items-center h-full text-[#C8D8A8] font-medium text-base !no-underline
       relative after:absolute after:bottom-0 after:left-0 after:h-[2px]
       after:w-0 after:bg-[#C8D8A8] after:transition-all after:duration-300
       hover:after:w-full"href="#"  onclick="loadPage('costumer/page/katalog.php')">Produk</a>
            </li>

            <!-- CART -->
            <li>
              <a class="flex items-center gap-2 no-underline text-[#C8D8A8]
       opacity-70 hover:opacity-100 transition-opacity duration-200" href="#" onclick="loadPage('costumer/page/keranjang.php')">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 6h13M7 13L5.4 5M10 21a1 1 0 100-2 1 1 0 000 2zm7 0a1 1 0 100-2 1 1 0 000 2z"/>
                </svg>
              </a>
            </li>

          </ul>
        </nav>
      <!-- MENU -->
      <div class="flex items-center gap-8">

        

        <!-- PROFILE -->
       <div class="relative inline-block">

  <!-- PROFILE BUTTON -->
  <button id="profileBtn" class="flex items-center justify-start w-52 px-3 py-2 rounded-lg ">

    <!-- FOTO -->
     <div class="flex items-center gap-3">
    <div class="rounded-full overflow-hidden w-8 h-8 bg-gray-200">
      <img src="/sghwebv2/ec/images/profil.jpg" class="w-full h-full object-cover">
    </div>

    <span class="text-[#C8D8A8] font-medium text-base">
      <?= $_SESSION['user']['name'] ?? 'Faiq imup'; ?>
    </span>
  </div>

    <!-- ICON DROPDOWN -->
    <svg class="w-4 h-4 text-[#C8D8A8] ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
        d="M19 9l-7 7-7-7" />
    </svg>

  </button>

          <!-- DROPDOWN -->
          <div id="dropdownMenu"
            class="hidden absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-md">

            <div class="py-2 text-black">

              <!-- PROFIL -->
              <a href="#" onclick="loadPage('/sghwebv2/ec/costumer/page/profile.php')" class="flex items-center gap-3 px-4 py-2 text-sm hover:bg-gray-100 no-underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    d="M12 12c2.761 0 5-2.239 5-5S14.761 2 12 2 7 4.239 7 7s2.239 5 5 5z" />
                  <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    d="M4 20c0-3.314 3.582-6 8-6s8 2.686 8 6" />
                </svg>
                Profil
              </a>

              <!-- PESANAN -->
              <a href="#" onclick="loadPage('/sghwebv2/ec/costumer/page/pesanan.php')" class="flex items-center gap-3 px-4 py-2 text-sm hover:bg-gray-100 no-underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    d="M3 7l9-4 9 4-9 4-9-4z" />
                  <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    d="M3 7v10l9 4 9-4V7" />
                </svg>
                Pesanan
              </a>

              <!-- LOGOUT -->
              <a href="#" class="flex items-center gap-3 px-4 py-2 text-sm text-red-600 hover:bg-red-50 no-underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    d="M17 16l4-4m0 0l-4-4m4 4H7" />
                </svg>
                Logout
              </a>

            </div>

          </div>
        </div>

      </div>

    </div>
  </div>
</header>

<!-- FIX GLOBAL LINK -->
<style>
  header a {
    text-decoration: none !important;
    color: inherit !important;
  }
</style>

<!-- SCRIPT -->
<script>
  const btn = document.getElementById("profileBtn");
  const menu = document.getElementById("dropdownMenu");

  btn.addEventListener("click", () => {
    menu.classList.toggle("hidden");
  });

  document.addEventListener("click", (e) => {
    if (!btn.contains(e.target) && !menu.contains(e.target)) {
      menu.classList.add("hidden");
    }
  });
</script>