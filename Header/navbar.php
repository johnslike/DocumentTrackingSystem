<?php

require_once('../db/connect_db.php');


?>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="setting_accounts.php" class="navbar-brand">
        <img src="../dist/img/LOGO.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?php echo $userdetails['fname']." ".$userdetails['minitial']." ".$userdetails['lname']." ".$userdetails['suffix'] ?></span>
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <!-- <li class="nav-item">
            <a href="index3.html" class="nav-link">Home</a>
          </li> -->
              <li class="nav-item">
                <a href="documents" class="nav-link">Home</a>
              </li>
              <li class="nav-item">
              <a href="DocumentList" class="nav-link">List of Documents</a>
              </li>
        </ul>

      </div>

      <!-- Right navbar links -->
    <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        <!-- Messages Dropdown Menu -->
              <!-- <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                  <i class="fas fa-tools"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-xs dropdown-menu-right">
                  <a href="setting_places.php" class="dropdown-item dropdown-footer"><i class="fas fa-map-marker-alt"></i> Places of Exam</a>
                  <div class="dropdown-divider"></div>
                  <a href="setting_types.php" class="dropdown-item dropdown-footer"><i class="fas fa-envelope-open-text"></i> Types of Exam</a>
                  <div class="dropdown-divider"></div>
                  <a href="setting_accounts.php" class="dropdown-item dropdown-footer"><i class="fas fa-user-alt"></i> Accounts</a>
                </div>
              </li> -->
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="fas fa-sign-out-alt"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-xs dropdown-menu-right">
            <a href="../login_logout/logout" class="dropdown-item dropdown-footer"><i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </li>
    </ul>

    </div>
</nav>
  <!-- /.navbar -->
