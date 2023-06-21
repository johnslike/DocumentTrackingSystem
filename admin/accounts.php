
<?php
require_once('../db/connect_db.php');

// $information=$store->getAccounts();
$store->add_account($_POST);
$store->update_account($_POST);
$store->delete_account($_POST);
$accounts=$store->getAccounts();

include('adminaccess.php');
include('../Header/Header.php');


?>

<title>List of Accounts</title>
<body class="hold-transition layout-top-nav">
<div class="wrapper">


      <!-- Navbar -->
  <?php include('../Header/navbaradmin.php'); ?>
  <!-- /.navbar -->


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"> List of Accounts</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home">Home</a></li>
              <li class="breadcrumb-item active">Accounts</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

              <?php
                $con = mysqli_connect('localhost','root','123456','dts_database');

                mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
              ?>

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
            <div class="card-header">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_account">
              <i class="fas fa-user-plus"></i>
              </button>
            </div>
              <div class="card-body">
              <table id="datatable" class="table table-bordered table-striped">
                  <thead class="text-nowrap">
                  <tr>
                      <th style="width: 100px">Action</th>
                      <th>Full Name</th>
                      <th>Username</th>
                      <th>Password</th>
                      <th>Division</th>
                      <th>Date Added</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php if (is_array($accounts) || is_object($accounts))
                  foreach($accounts as $account){?>
                  <tr>
                  <td><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#edit<?php echo $account['id']?>"><i class="fas fa-pencil-alt"></i></button>
                  <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete<?php echo $account['id']?>"><i class="fas fa-trash-alt"></i></button></td>
                  <td><?php echo $account['fname'];?></td>
                  <td><?php echo $account['username'];?></td>
                  <td><?php echo md5($account['password']);?></td>
                  <td><?php echo $account['division'];?></td>
                  <td><?php
                      if(isset($account['date_added']) && $account['date_added'] !="")
                      {
                          $date = date("F j, Y", strtotime($account['date_added']));
                      }
                      else {
                          $date = "";
                      }
                      echo $date ; ?></td>
                  </tr>


          <div class="modal fade" id="delete<?php echo $account['id']?>">
          <div class="modal-dialog modal-sm">

          <div class="modal-content bg-danger">

            <div class="modal-header">
              <h4 class="modal-title">Are you sure you want to delete this Account?</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method = "post" action="">
            <input type="hidden" class="form-control" value="<?php echo $account['id'];?>" name="id" id="id">
            <div class="card-body">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Full Name:</label>
                        <input type="hidden" class="form-control" value="<?php echo $account['id'];?>" name="id">
                        <input type="text" class="form-control" value="<?php echo $account['fname']?>" name="barangay" id="fullname" disabled="disabled">
                      </div>
                    </div>
                    </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
              <button name="delete" class="btn btn-outline-light">Delete Account</button>
            </div>
          </div>

          </form>

          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->


      <div class="modal fade" id="edit<?php echo $account['id']?>">
          <div class="modal-dialog modal-lg">

          <div class="modal-content">

            <div class="modal-header">
              <h4 class="modal-title">Edit info</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method = "post" action="">
            <div class="card-body">
                    <div class="row">
                    <div class="col-sm-5">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Full name:</label>
                        <input type="hidden" class="form-control" value="<?php echo $account['id'];?>" name="id" id="id">
                        <input type="text" class="form-control" value="<?php echo $account['fname'];?>" name="fname" id="fullname">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>User name:</label>
                        <input type="text" class="form-control" value="<?php echo $account['username'];?>" name="username" id="username" readonly>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label>Password:</label>
                        <input type="password" class="form-control" value="<?php echo $account['password'];?>" name="password" id="password">

                      </div>
                    </div>
                  </div>

            </div>

            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button name="update" class="btn btn-success"><i class="fas fa-check"></i> Update data</button>
            </div>

          </div>

          </form>

          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div><!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <?php include('../Footer/Footer.php'); ?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->

<?php include('../Footer/Script.php'); ?>

</body>
</html>

      <div class="modal fade" id="add_account">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add new account</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method = "post">
            <div class="card-body">
                    <div class="row">
                    <div class="col-sm-4">
                      <div class="form-group">
                      <span style="color:red">* </span><label>Registered Employee:</label>
                        <select class="form-control" name="employee" id="access" required>
                        <option value="">--Select Employee--</option>

                        <?php $query2 = "SELECT t1.id as user_id, t1.username, t1.password, t1.access, t1.date_added, t1.date_updated, t2.id, t2.fname, t2.minitial, t2.lname, t2.suffix FROM setting_users t2 LEFT JOIN setting_accounts t1 ON t1.user_id = t2.id WHERE t1.id IS NULL ORDER BY t2.fname";
                              $rows = mysqli_query($con,$query2);

                            foreach ($rows as $row)
                            {
                              ?>
                              <option value="<?php echo $row['id']; ?>"; ?><?php echo $row['fname']." ".$row['minitial']." ".$row['lname']." ".$row['suffix']; ?></option>
                              <?php
                            }

                              ?>

                        </select>
                      </div>
                      </div>

                    <div class="col-sm-3">
                      <div class="form-group">
                      <span style="color:red">* </span><label>User name:</label>
                        <input type="text" class="form-control check_username" id="" name="username" placeholder="Enter ..." required>
                      </div>
                      </div>

                      <div class="col-sm-3">
                      <div class="form-group">
                      <span style="color:red">* </span><label>Password:</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter ..." required>
                      </div>
                    </div>


                      <div class="col-sm-2">
                      <div class="form-group">
                      <span style="color:red">* </span><label>Access:</label>
                      <select class="form-control" name="access" id="access" required>
                        <option value="">-- Mode--</option>

                              <option value="User">User</option>
                              <option value="Admin">Admin</option>

                        </select>
                      </div>
                    </div>

                  </div>

            </div>

            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" name="add_account" id="" class="btn btn-primary">Save data</button>
            </div>
          </div>
          </form>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
