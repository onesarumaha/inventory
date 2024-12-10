<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="<?= base_url('frontend/assets/') ?>img/logo/logo.png" rel="icon">
  <title><?= $title ?></title>
  <link href="<?= base_url('frontend/assets/') ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="<?= base_url('frontend/assets/') ?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="<?= base_url('frontend/assets/') ?>css/ruang-admin.min.css" rel="stylesheet">
  <link href="<?= base_url('frontend/assets/') ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="<?= base_url('frontend/assets/') ?>vendor/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css">
  <link href="<?= base_url('frontend/assets/') ?>vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" >
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    <?= $this->include('layout/sidebar') ?>
  
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <?= $this->include('layout/topbar') ?>
       
        <!-- Topbar -->

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="<?= base_url('/dashboard') ?>">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
            </ol>
          </div>

          <?= $this->renderSection('content') ?>


          <!-- Modal Logout -->
          <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabelLogout">Logout !</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>Yakin ingin keluar dari sistem ?</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                  <a href="<?= base_url('/logout') ?>" class="btn btn-primary">Logout</a>
                </div>
              </div>
            </div>
          </div>

        </div>
        <!---Container Fluid-->
      </div>
      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto py-2">
          <div class="copyright text-center my-auto">
            <span> 
                <b>PT. ALPHA KUMALA WARDHANA JAKARTA</b> 
            </span>
             <div class="version" id="version-ruangadmin"></div>
          </div>
        </div>
      </footer>
      <!-- Footer -->
    </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="<?= base_url('frontend/assets/') ?>vendor/jquery/jquery.min.js"></script>
  <script src="<?= base_url('frontend/assets/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url('frontend/assets/') ?>vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="<?= base_url('frontend/assets/') ?>js/ruang-admin.min.js"></script>
  <script src="<?= base_url('frontend/assets/') ?>vendor/chart.js/Chart.min.js"></script>
  <script src="<?= base_url('frontend/assets/') ?>js/demo/chart-bar-demo.js"></script>

   <!-- Page level plugins -->
   <script src="<?= base_url('frontend/assets/') ?>vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?= base_url('frontend/assets/') ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script src="<?= base_url('frontend/assets/') ?>vendor/select2/dist/js/select2.min.js"></script>
  <!-- Page level custom scripts -->
  <script src="<?= base_url('frontend/assets/') ?>vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
  <script src="<?= base_url('frontend/assets/') ?>js/demo/chart-pie-demo.js"></script>


  <script>
    $(document).ready(function () {
      $('#dataTable').DataTable(); 
      $('#dataTableHover').DataTable(); 

      $('.select2-single').select2();

      $('#simple-date1 .input-group.date').datepicker({
        format: 'dd/mm/yyyy',
        todayBtn: 'linked',
        todayHighlight: true,
        autoclose: true,        
      }).datepicker('setDate', new Date());;


    });
  </script>
</body>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    <?php if (session()->getFlashdata('messages')): ?>
       const Toast = Swal.mixin({
           toast: true,
           position: "top-end",
           showConfirmButton: false,
           timer: 3000,
           timerProgressBar: true,
           didOpen: (toast) => {
               toast.onmouseenter = Swal.stopTimer;
               toast.onmouseleave = Swal.resumeTimer;
           }
       });

       Toast.fire({
           icon: "success",
           title: "Login berhasil"
       });
   <?php endif; ?>
    <?php if (session()->getFlashdata('message')): ?>
        Swal.fire({
            icon: 'success',
            title: 'Success !',
            text: '<?= session()->getFlashdata('message'); ?>',
            showConfirmButton: false,
            timer: 2000
        });
    <?php endif; ?>
    

    <?php if (session()->getFlashdata('messageDelete')): ?>
        Swal.fire({
            icon: 'success',
            title: 'Deleted !',
            text: '<?= session()->getFlashdata('messageDelete'); ?>',
            showConfirmButton: false,
            timer: 2000
        });
    <?php elseif (session()->getFlashdata('error')): ?>
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '<?= session()->getFlashdata('error'); ?>',
            showConfirmButton: false,
            timer: 2000
        });
    <?php endif; ?>

    function confirmDeleteSupplier(id) {
          Swal.fire({
              title: 'Hapus Supplier ?',
              text: "Yakin ingin menghapus data ini?",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#d33',
              cancelButtonColor: '#3085d6',
              confirmButtonText: 'Iya',
              cancelButtonText: 'Tidak'
          }).then((result) => {
              if (result.isConfirmed) {
                  $.ajax({
                      url: '<?= base_url('/supplier') ?>/' + id,
                      type: 'DELETE',
                      data: {
                          
                          '_csrf': '<?= csrf_hash() ?>' 
                      },
                      success: function(response) {
                        if(response.success) {
                              Swal.fire({
                                  title: 'Berhasil!',
                                  text: 'Berhasil hapus data supplier.',
                                  icon: 'success',
                                  timer: 2000,  
                                  showConfirmButton: false
                              });
                              setTimeout(() => {
                                  window.location.href = '/supplier'; 
                              }, 2000); 
                          } else {
                              Swal.fire('Gagal!', 'Data tidak dapat di hapus.', 'error');
                          }
                      },
                      error: function() {
                          Swal.fire('Error!', 'Terjadi kesalahan saat menghubungi server.', 'error');
                      }
                  });
              }
          });
      }


      function confirmDeleteCustomer(id) {
          Swal.fire({
              title: 'Hapus Customer ?',
              text: "Yakin ingin menghapus data ini?",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#d33',
              cancelButtonColor: '#3085d6',
              confirmButtonText: 'Iya',
              cancelButtonText: 'Tidak'
          }).then((result) => {
              if (result.isConfirmed) {
                  $.ajax({
                      url: '<?= base_url('/customer') ?>/' + id,
                      type: 'DELETE',
                      data: {
                          
                          '_csrf': '<?= csrf_hash() ?>' 
                      },
                      success: function(response) {
                        if(response.success) {
                              Swal.fire({
                                  title: 'Berhasil!',
                                  text: 'Berhasil hapus data customer.',
                                  icon: 'success',
                                  timer: 2000,  
                                  showConfirmButton: false
                              });
                              setTimeout(() => {
                                  window.location.href = '/customer'; 
                              }, 2000); 
                          } else {
                              Swal.fire('Gagal!', 'Data tidak dapat di hapus.', 'error');
                          }
                      },
                      error: function() {
                          Swal.fire('Error!', 'Terjadi kesalahan saat menghubungi server.', 'error');
                      }
                  });
              }
          });
      }

      function confirmDeleteProduct(id) {
          Swal.fire({
              title: 'Hapus Product ?',
              text: "Yakin ingin menghapus data ini?",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#d33',
              cancelButtonColor: '#3085d6',
              confirmButtonText: 'Iya',
              cancelButtonText: 'Tidak'
          }).then((result) => {
              if (result.isConfirmed) {
                  $.ajax({
                      url: '<?= base_url('/product') ?>/' + id,
                      type: 'DELETE',
                      data: {
                          
                          '_csrf': '<?= csrf_hash() ?>' 
                      },
                      success: function(response) {
                        if(response.success) {
                              Swal.fire({
                                  title: 'Berhasil!',
                                  text: 'Berhasil hapus data product.',
                                  icon: 'success',
                                  timer: 2000,  
                                  showConfirmButton: false
                              });
                              setTimeout(() => {
                                  window.location.href = '/product'; 
                              }, 2000); 
                          } else {
                              Swal.fire('Gagal!', 'Data tidak dapat di hapus.', 'error');
                          }
                      },
                      error: function() {
                          Swal.fire('Error!', 'Terjadi kesalahan saat menghubungi server.', 'error');
                      }
                  });
              }
          });
      }

      function confirmDeleteUser(id) {
          Swal.fire({
              title: 'Hapus User ?',
              text: "Yakin ingin menghapus data ini?",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#d33',
              cancelButtonColor: '#3085d6',
              confirmButtonText: 'Iya',
              cancelButtonText: 'Tidak'
          }).then((result) => {
              if (result.isConfirmed) {
                  $.ajax({
                      url: '<?= base_url('/users') ?>/' + id,
                      type: 'DELETE',
                      data: {
                          
                          '_csrf': '<?= csrf_hash() ?>' 
                      },
                      success: function(response) {
                        if(response.success) {
                              Swal.fire({
                                  title: 'Berhasil!',
                                  text: 'Berhasil hapus data user.',
                                  icon: 'success',
                                  timer: 2000,  
                                  showConfirmButton: false
                              });
                              setTimeout(() => {
                                  window.location.href = '/users'; 
                              }, 2000); 
                          } else {
                              Swal.fire('Gagal!', 'Data tidak dapat di hapus.', 'error');
                          }
                      },
                      error: function() {
                          Swal.fire('Error!', 'Terjadi kesalahan saat menghubungi server.', 'error');
                      }
                  });
              }
          });
      }



    function confirmDelete(id) {
          Swal.fire({
              title: 'Yakin hapus data ?',
              text: "Apakah yakin ingin menghapus data ini?",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#d33',
              cancelButtonColor: '#3085d6',
              confirmButtonText: 'Iya',
              cancelButtonText: 'Tidak'
          }).then((result) => {
              if (result.isConfirmed) {
                  $.ajax({
                      url: '<?= base_url('/pemasukan') ?>/' + id,
                      type: 'DELETE',
                      data: {
                          
                          '_csrf': '<?= csrf_hash() ?>' 
                      },
                      success: function(response) {
                        if(response.success) {
                              Swal.fire({
                                  title: 'Berhasil!',
                                  text: 'Berhasil hapus data pemasukan.',
                                  icon: 'success',
                                  timer: 2000,  
                                  showConfirmButton: false
                              });
                              setTimeout(() => {
                                  window.location.href = '/pemasukan'; 
                              }, 2000); 
                          } else {
                              Swal.fire('Gagal!', 'Data tidak dapat di hapus.', 'error');
                          }
                      },
                      error: function() {
                          Swal.fire('Error!', 'Terjadi kesalahan saat menghubungi server.', 'error');
                      }
                  });
              }
          });
      }


      function confirmAdmin(id) {
          Swal.fire({
              title: 'Approve data?',
              text: "Yakin ingin approve data?",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#d33',
              cancelButtonColor: '#3085d6',
              confirmButtonText: 'Iya',
              cancelButtonText: 'Tidak'
          }).then((result) => {
              if (result.isConfirmed) {
                  $.ajax({
                      url: '<?= base_url('/pemasukan/approve-admin') ?>/' + id,
                      type: 'POST',
                      data: {
                          
                          '_csrf': '<?= csrf_hash() ?>' 
                      },
                      success: function(response) {
                        if(response.success) {
                              Swal.fire({
                                  title: 'Berhasil!',
                                  text: 'Data telah di-approve.',
                                  icon: 'success',
                                  timer: 2000,  
                                  showConfirmButton: false
                              });
                              setTimeout(() => {
                                  window.location.href = '/pemasukan'; 
                              }, 2000); 
                          } else {
                              Swal.fire('Gagal!', 'Data tidak dapat di-approve.', 'error');
                          }
                      },
                      error: function() {
                          Swal.fire('Error!', 'Terjadi kesalahan saat menghubungi server.', 'error');
                      }
                  });
              }
          });
      }


      function confirmOwner(id) {
          Swal.fire({
              title: 'Approve data?',
              text: "Apakah yakin ingin approve data ini?",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#d33',
              cancelButtonColor: '#3085d6',
              confirmButtonText: 'Iya',
              cancelButtonText: 'Tidak'
          }).then((result) => {
              if (result.isConfirmed) {
                  $.ajax({
                      url: '<?= base_url('/pemasukan/approve-owner') ?>/' + id,
                      type: 'POST',
                      data: {
                          
                          '_csrf': '<?= csrf_hash() ?>' 
                      },
                      success: function(response) {
                        if(response.success) {
                              Swal.fire({
                                  title: 'Berhasil!',
                                  text: 'Data telah di-approve.',
                                  icon: 'success',
                                  timer: 2000,  
                                  showConfirmButton: false
                              });
                              setTimeout(() => {
                                  window.location.href = '/pemasukan'; 
                              }, 2000); 
                          } else {
                              Swal.fire('Gagal!', 'Data tidak dapat di-approve.', 'error');
                          }
                      },
                      error: function() {
                          Swal.fire('Error!', 'Terjadi kesalahan saat menghubungi server.', 'error');
                      }
                  });
              }
          });
      }

      function confirmDeletePengeluaran(id) {
          Swal.fire({
              title: 'Yakin hapus data ?',
              text: "Apakah yakin ingin menghapus data ini?",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#d33',
              cancelButtonColor: '#3085d6',
              confirmButtonText: 'Iya',
              cancelButtonText: 'Tidak'
          }).then((result) => {
              if (result.isConfirmed) {
                  $.ajax({
                      url: '<?= base_url('/pengeluaran') ?>/' + id,
                      type: 'DELETE',
                      data: {
                          
                          '_csrf': '<?= csrf_hash() ?>' 
                      },
                      success: function(response) {
                        if(response.success) {
                              Swal.fire({
                                  title: 'Berhasil!',
                                  text: 'Berhasil hapus data pengeluaran.',
                                  icon: 'success',
                                  timer: 2000,  
                                  showConfirmButton: false
                              });
                              setTimeout(() => {
                                  window.location.href = '/pengeluaran'; 
                              }, 2000); 
                          } else {
                              Swal.fire('Gagal!', 'Data tidak dapat di hapus.', 'error');
                          }
                      },
                      error: function() {
                          Swal.fire('Error!', 'Terjadi kesalahan saat menghubungi server.', 'error');
                      }
                  });
              }
          });
      }


      document.getElementById('logoutButton').addEventListener('click', function() {
        localStorage.removeItem('modalShown'); 
    });

</script>


</html>