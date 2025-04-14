<nav class="navbar navbar-expand-xl align-items-center border-0 shadow-none" id="layout-navbar">
  <div class="container-xxl d-flex justify-content-between align-items-center">

    <!-- Kiri: Nama dan Role -->
    <div class="d-flex align-items-center">
      <div style="font-family: Arial, sans-serif; color: #004aad; text-align: left;">
        <div style="font-weight: bold; font-size: 20px;">
          {{ ucwords(Auth::user()->name) }}
          <span style="font-weight: normal; font-size: 14px;">/ {{ strtolower(Auth::user()->role_as) }}</span>
        </div>
      </div>
    </div>

    <!-- Kanan: Tombol Logout -->
    <div class="d-flex align-items-center no-print">
      <form action="{{ route('logout') }}" method="POST" class="mb-0">
        @csrf
        <button type="submit" class="btn btn-primary rounded-pill px-4">
          <i class="bx bx-power-off me-2"></i>
          Logout
        </button>
      </form>
    </div>

  </div>
</nav>
