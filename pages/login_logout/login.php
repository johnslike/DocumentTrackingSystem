<?php

require_once('../db/connect_db.php');
$store->login($_POST);

include('../Header/header.php');
?>


<title>Log-in</title>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <p href="" class="h4"><b>Login as Admin</b></p>
      <small>Name of the System</small>
    </div>
    <div class="card-body">
      <!-- <p class="login-box-msg">Sign in to start your session</p> -->

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="username" placeholder="Username" autofocus required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
        </div>

      <div class="social-auth-links text-center mt-2 mb-3">
      <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>

                  <!-- <h5><i class="icon fas fa-ban"></i> Alert!</h5> -->
          <?php if (isset($_GET["msg"]) && $_GET["msg"] == 'failed') {
          echo "<br><p class='text-danger'>Username or password is incorrect</p>";
          } ?>

      </div>
        </form>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->


<?php include('../Footer/Script.php'); ?>
