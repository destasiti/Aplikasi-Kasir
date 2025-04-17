<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo d-flex justify-content-center align-items-center py-4">
    <a href="#" class="app-brand-link d-block w-100 px-3">
      <img src="{{ asset('assets/img/avatars/framed Logo.png') }}" alt="Logo"
           style="max-height: 120px; width: 100%; object-fit: contain; display: block; margin: 0 auto;">
    </a>
  </div>  
    

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    <!-- Home Header -->
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Home</span>
    </li>
    @if(Auth::user()->role_as == 'admin')
      <li class="menu-item" id="menu-dashboard">
        <a href="/admin/dashboard" class="menu-link">
          <i class="menu-icon bx bx-home"></i>
          <div data-i18n="Dashboard">Dashboard</div>
        </a>
      </li>
    @elseif(Auth::user()->role_as == 'kasir')
      <li class="menu-item" id="menu-dashboard-kasir">
        <a href="/kasir/dashboard" class="menu-link">
          <i class="menu-icon bx bx-home"></i>
          <div data-i18n="Dashboard">Dashboard Kasir</div>
        </a>
      </li>
    @endif

    @if(Auth::user()->role_as == 'admin')
      <!-- Smart Kasir Header -->
      <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Smart Kasir</span>
      </li>
      <li class="menu-item" id="menu-toko">
        <a href="{{ route('toko.index') }}" class="menu-link">
          <i class="menu-icon bx bx-store"></i>
          <div data-i18n="ProfileToko">Profil Toko</div>
        </a>
      </li>
      <li class="menu-item" id="menu-kategori">
        <a href="/kategori" class="menu-link">
          <i class="menu-icon bx bx-category"></i>
          <div data-i18n="Kategori">Data Kategori Produk</div>
        </a>
      </li>
      <!-- Manajemen Header -->
      <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Manajemen</span>
      </li>
      <li class="menu-item" id="menu-supplier">
        <a href="/supplier" class="menu-link">
          <i class="menu-icon bx bx-box"></i>
          <div data-i18n="Supplier">Data Supplier</div>
        </a>
      </li>
      <li class="menu-item" id="menu-transaksi">
        <a href="/stock" class="menu-link">
          <i class="menu-icon bx bx-log-in"></i>
          <div data-i18n="Transaksi">Data Pemasukan</div>
        </a>
      </li>
      <li class="menu-item" id="menu-stockout">
        <a href="{{ route('stock_out.index') }}" class="menu-link">
            <i class="menu-icon bx bx-log-out"></i>
            <div data-i18n="Pengeluaran">Data Pengeluaran</div>
        </a></li>   
      
      <li class="menu-item" id="menu-laporan">
        <a href="/laporan/penjualan" class="menu-link">
          <i class="menu-icon bx bx-file"></i>
          <div data-i18n="Laporan">Laporan Penjualan</div>
        </a>
      </li>
      <li class="menu-item" id="menu-kasir">
        <a href="/kasir/create" class="menu-link">
          <i class="menu-icon bx bx-user-pin"></i>
          <div data-i18n="Kasir">Daftar Akun Kasir</div>
        </a>
      </li>
      
    @endif

    @if(Auth::user()->role_as == 'admin' || Auth::user()->role_as == 'kasir')
      <!-- Smart Payment Header -->
      <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Smart Payment</span>
      </li>
      <li class="menu-item" id="menu-pelanggan">
        <a href="/pelanggan" class="menu-link">
          <i class="menu-icon bx bx-user"></i>
          <div data-i18n="Pelanggan">Data Pelanggan</div>
        </a>
      </li>
      <li class="menu-item" id="menu-produk">
        <a href="/produk" class="menu-link">
          <i class="menu-icon bx bx-package"></i>
          <div data-i18n="Produk">Data Produk</div>
        </a>
      </li>
      <li class="menu-item" id="menu-penjualan">
        <a href="/penjualan" class="menu-link">
          <i class="menu-icon bx bx-cart"></i>
          <div data-i18n="Penjualan">Data Penjualan</div>
        </a>
      </li>
    @endif
  </ul><p>&nbsp;</p> 

</aside>

<p>&nbsp;</p>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const menuItems = document.querySelectorAll(".menu-item");
    const currentUrl = window.location.pathname;

    menuItems.forEach(item => {
      const link = item.querySelector("a");
      if (link && link.getAttribute("href") === currentUrl) {
        item.classList.add("active");
      }
    });
  });
</script>

<p>&nbsp;</p>
