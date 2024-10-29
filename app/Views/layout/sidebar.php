 <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('/dashboard') ?>">
        <div class="sidebar-brand-icon">
          <img src="<?= base_url('frontend/assets/') ?>img/logo/logo2.png">
        </div>
        <div class="sidebar-brand-text mx-3">Inventory</div>
      </a>
      <hr class="sidebar-divider my-0">
      <li class="nav-item <?= is_active('/dashboard') ?>">
        <a class="nav-link" href="<?= base_url('/dashboard') ?>">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Menu
      </div>
      <li class="nav-item <?= is_active('/users') || is_active('/product') || is_active('/supplier') ? 'active' : '' ?>">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap"
          aria-expanded="true" aria-controls="collapseBootstrap">
          <i class="far fa-fw fa-window-maximize"></i>
          <span>Master</span>
        </a>
        <div id="collapseBootstrap" class="collapse <?= is_active('/users') || is_active('/customer') ||  is_active('/product') || is_active('/supplier') ? 'show' : '' ?>" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Master</h6>
            <a class="collapse-item <?= is_active('/users') ?>" href="<?= base_url('/users') ?>">User</a>
            <a class="collapse-item <?= is_active('/product') ?>" href="<?= base_url('/product') ?>">Product</a>
            <a class="collapse-item <?= is_active('/customer') ?>" href="<?= base_url('/customer') ?>">Customer</a>
            <a class="collapse-item <?= is_active('/supplier') ?>" href="<?= base_url('/supplier') ?>">Supplier</a>
          </div>
        </div>
      </li>

      <li class="nav-item <?= is_active('/pengeluaran') ?>">
        <a class="nav-link" href="<?= base_url('pengeluaran') ?>">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Pengeluaran</span>
        </a>
      </li>
 
      <li class="nav-item <?= is_active('/pemasukan') ?>">
        <a class="nav-link" href="<?= base_url('pemasukan') ?>">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Pemasukan</span>
        </a>
      </li>

      <li class="nav-item <?= is_active('/omset') || is_active('/stoct') ? 'active' : '' ?>">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstraps"
          aria-expanded="true" aria-controls="collapseBootstraps">
          <i class="far fa-fw fa-window-maximize"></i>
          <span>Laporan</span>
        </a>
        <div id="collapseBootstraps" class="collapse <?= is_active('/omset') || is_active('/stock') ? 'show' : '' ?>" aria-labelledby="headingBootstraps" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Laporan</h6>
            <a class="collapse-item <?= is_active('/omset') ?>" href="<?= base_url('/omset') ?>">Omset</a>
            <a class="collapse-item <?= is_active('/stock') ?>" href="<?= base_url('/stock') ?>">Stock Barang</a>
          </div>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="<?= base_url('/logout') ?>">
          <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
          <span>Logout</span>
        </a>
      </li>


    </ul>
