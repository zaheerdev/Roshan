<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $page_title;?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= ASSETS ?>adminlte/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= ASSETS ?>adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= ASSETS ?>adminlte/dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <img class="w-75" src="<?=BASE_URL.'assets/images/logo.jpg'?>" style="mix-blend-mode:darken;">
    </div>
    <!-- <div class="login-logo">
      <a href="#"><b>ROSHAN</b> Dashboard</a>
    </div> -->
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
				<!-- credential required errors -->
				<?php if($auth_errors) :?>
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
							<?=$auth_errors?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
				<?php endif;?>
				<!-- credentials wrong error -->
				<?php if($this->session->flashdata('login_failed')) :?>
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
							<?=$this->session->flashdata('login_failed')?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
				<?php endif;?>
        <p class="login-box-msg">Sign in to start your session</p>
        <form action="<?php echo BASE_URL?>/auth/login" method="post">
          <div class="form-group">
            <select class="form-control" name="login_as">
              <option value="">Select login as</option>
              <option value="1">Admin</option>
              <option value="2">Sales Manager</option>
            </select>
          </div>
          <div class="input-group mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="<?= ASSETS ?>adminlte/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?= ASSETS ?>adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= ASSETS ?>adminlte/dist/js/adminlte.min.js"></script>
</body>

</html>
