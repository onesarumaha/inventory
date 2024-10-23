<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="<?= base_url('frontend/assets/') ?>img/logo/logo.png" rel="icon">
  <title>Login</title>
  <link href="<?= base_url('frontend/assets/') ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="<?= base_url('frontend/assets/') ?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="<?= base_url('frontend/assets/') ?>css/ruang-admin.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-login">
  <!-- Login Content -->
  <div class="container-login">
    <div class="row justify-content-center">
      <div class="col-xl-4 col-lg-12 col-md-9">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Login</h1>
                  </div>
                  <form class="user">
                    <div class="form-group">
                      <input type="text" class="form-control" name="username" id="exampleInputEmail" aria-describedby="emailHelp"
                        placeholder=" Username">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" name="password" id="exampleInputPassword" placeholder="Password">
                    </div>
                   
                    <div class="form-group">
                      <button class=" btn btn-primary btn-block">Login</button>
                    </div>
                    <hr>
                  </form>
                  <div class="text-center">
                    <!-- <a class="font-weight-bold small" href="register.html">Create an Account!</a> -->
                  </div>
                  <div class="text-center">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Login Content -->
  <script src="<?= base_url('frontend/assets/') ?>vendor/jquery/jquery.min.js"></script>
  <script src="<?= base_url('frontend/assets/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url('frontend/assets/') ?>vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="<?= base_url('frontend/assets/') ?>js/ruang-admin.min.js"></script>
</body>

</html>