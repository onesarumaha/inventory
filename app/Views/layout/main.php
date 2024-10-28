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
                  <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>Are you sure you want to logout?</p>
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
            <span>copyright &copy; <script> document.write(new Date().getFullYear()); </script> - distributed by
              <b><a href="https://themewagon.com/" target="_blank">themewagon</a></b>
            </span>
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
  <script src="<?= base_url('frontend/assets/') ?>js/demo/chart-area-demo.js"></script>  

   <!-- Page level plugins -->
   <script src="<?= base_url('frontend/assets/') ?>vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?= base_url('frontend/assets/') ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script src="<?= base_url('frontend/assets/') ?>vendor/select2/dist/js/select2.min.js"></script>
  <!-- Page level custom scripts -->
  <script src="<?= base_url('frontend/assets/') ?>vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
  

  <script>
    $(document).ready(function () {
      $('#dataTable').DataTable(); 
      $('#dataTableHover').DataTable(); 

      $('.select2-single').select2();


        // Bootstrap Date Picker
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
    <?php if (session()->getFlashdata('message')): ?>
        Swal.fire({
            icon: 'success',
            title: 'Success !',
            text: '<?= session()->getFlashdata('message'); ?>',
            showConfirmButton: false,
            timer: 2000
        });
    <?php endif; ?>
    
    function confirmDelete() {
        Swal.fire({
            title: 'Yakin hapus data ?',
            text: "Aapakah yakin ingin menghapus data ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Iya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form').submit();
            }
        });
    }

    <?php if (session()->getFlashdata('message')): ?>
        Swal.fire({
            icon: 'success',
            title: 'Deleted !',
            text: '<?= session()->getFlashdata('message'); ?>',
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
</script>
</script>

</html>