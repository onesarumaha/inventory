<!-- TopBar -->
<script>
    const BASE_URL = "<?= base_url(); ?>";
</script>
<nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
  <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
    <i class="fa fa-bars"></i>
  </button>
  <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown no-arrow mx-1">
      <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-bell fa-fw"></i>
          <span class="badge badge-danger badge-counter" id="notification-count">0</span>
      </a>
      <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
          aria-labelledby="alertsDropdown">
          <h6 class="dropdown-header">Pengadaan Barang</h6>
          <div id="notification-list">
              <p class="text-center text-gray-500">Loading...</p>
          </div>
          <a class="dropdown-item text-center small text-gray-500" href="<?= base_url('/pemasukan') ?>">Lihat Semua</a>
      </div>
  </li>

    <div class="topbar-divider d-none d-sm-block"></div>
    <li class="nav-item dropdown no-arrow">
      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <img class="img-profile rounded-circle" src="<?= base_url('frontend/assets/') ?>img/boy.png" style="max-width: 60px">
        <span class="ml-2 d-none d-lg-inline text-white small"><?= session()->get('username') ?: 'Guest'; ?></span>
      </a>
      <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
        <a class="dropdown-item" href="<?= base_url('/profile') ?>">
          <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
          Profile
        </a>
        <a class="dropdown-item" href="<?= base_url('/profile/ganti-password/') ?>">
          <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
          Ganti Password
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#logoutModal" id="logoutButton">
          <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
          Logout
        </a>
      </div>
    </li>
  </ul>
</nav>
<!-- Topbar -->


<script>
    function loadNotifications() {
        $.ajax({
            url: '<?= site_url('notifikasi') ?>', 
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#notification-count').text(response.count > 0 ? response.count : '');

                $('#notification-list').empty();

                if (response.notifications.length > 0) {
                    response.notifications.forEach(function(notification) {
                      let statusText = '';
                        if (notification.status == 0) {
                            statusText = 'Menunggu di approve admin';
                        } else if (notification.status == 1) {
                            statusText = 'Approve Admin';
                        } else {
                            statusText = 'Status tidak diketahui';
                        }
                        $('#notification-list').append(`
                          <a class="dropdown-item d-flex align-items-center" href="${BASE_URL}pemasukan/view/${notification.id}">
                                <div class="mr-3">
                                    <div class="icon-circle bg-primary">
                                        <i class="fas fa-file-alt text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <span class="font-weight-bold">${notification.username}</span> <br>
                                   ${notification.name}<br>
                                   ${statusText}

                                </div>
                            </a>
                        `);
                    });
                } else {
                    $('#notification-list').html('<p class="text-center text-gray-500">Tidak ada notifikasi baru</p>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }

    $(document).ready(function() {
        loadNotifications();

        setInterval(loadNotifications, 30000); 
    });
</script>