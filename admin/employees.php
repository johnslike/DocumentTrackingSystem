<?php
require_once('../db/connect_db.php');

$Employees=$store->getUsers();
$store->add_user($_POST);
$store->add_employee($_POST);

include('adminaccess.php');
include('../Header/Header.php');
?>
<title>Employees</title>
<body class="hold-transition layout-top-nav">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <?php include('../Header/navbaradmin.php'); ?>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>List of Employees</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active"><a href="home.php">Home</a></li>
              <li class="breadcrumb-item active">Employees</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    <?php

                $con = mysqli_connect('localhost','root','123456','dts_database');

                mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    ?>


    <!-- Main content -->
    <section class="content">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">


                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_employee">
                    <i class="fas fa-user-plus"></i> Add Employee</button>

              </div>

              <!-- ./card-header -->
              <div class="card-body table-responsive" style="height: 800px;">
                <table id="datatable" class="table table-bordered table-striped projects">
                  <thead class="text-nowrap">
                    <tr>
                      <th>Action</th>
                      <th>Employee ID</th>
                      <th>Fullname</th>
                      <th>Division</th>
                      <th>Position</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>

                    <?php if (is_array($Employees) || is_object($Employees))
                      foreach($Employees as $Employee){?>
                      <td><a type="button" class="btn btn-info btn-sm" href="profile?id=<?php echo $Employee['id']?>"><i class="fas fa-eye"></i></a>
                    </td>
                      <td><?php echo $Employee['employee_id'];?></td>
                      <td><?php echo $Employee['fname']." ".$Employee['minitial']." ".$Employee['lname']." ".$Employee['suffix'];?></td>
                      <td><?php echo $Employee['division'];?></td>
                      <td><?php echo $Employee['position'];?></td>
                      </tr>

                  <?php } ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
<!-- ./wrapper -->


    <div class="modal fade" id="add_employee">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add Employee</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method = "post">
            <div class="card-body">

                      <div class="row">
                      <div class="col-sm-4">
                      <div class="form-group">
                      <span style="color:red">* </span><label>First Name:</label>
                        <input type="text" class="form-control" id="password" name="fname" placeholder="Enter ..." required>
                      </div>
                    </div>

                      <div class="col-sm-2">
                      <div class="form-group">
                      <span style="color:red">* </span><label>Middle Initial:</label>
                        <input type="text" class="form-control" id="password" name="mnitial" placeholder="Enter ..." required>
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="form-group">
                      <span style="color:red">* </span><label>Last Name:</label>
                        <input type="text" class="form-control" id="password" name="lname" placeholder="Enter ..." required>
                      </div>
                    </div>

                      <div class="col-sm-2">
                      <div class="form-group">
                      </span><label>Suffix:</label>
                        <input type="text" class="form-control" id="password" name="suffix" placeholder="Enter ...">
                      </div>
                    </div>
                    </div>


                  <div class="row">
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                      <span style="color:red">* </span><label>Employee ID:</label>
                        <input type="text" class="form-control ictno_id" name="emp_id" placeholder="Enter ..." required>
                        <small class="error_ictno" style="color: red;"></small>
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="form-group">
                       <span style="color:red">* </span><label>Position:</label>
                        <select class="form-control" name="position" id="" required>

                        <option value="">--Select Position--</option>
                        <?php $query2 = "SELECT * FROM setting_positions ORDER BY position ASC";
                          $rows = mysqli_query($con,$query2);

                          if(mysqli_num_rows($rows) > 0)
                          {
                            foreach ($rows as $row)
                            {
                              ?>
                              <option value="<?php echo $row['id'];?>"><?php echo $row['position'];?></option>
                              <?php
                            }
                            }else
                            {
                              ?>
                              <option value=" ">No Records Found</option>
                              <?php
                            }
                              ?>

                        </select>
                      </div>
                    </div>


                    <div class="col-sm-4">
                      <div class="form-group">
                       <span style="color:red">* </span><label>Division:</label>
                        <select class="form-control" name="division" id="" required>
                        <option value="">--Select Division--</option>
                        <?php $query2 = "SELECT * FROM setting_divisions ORDER BY division ASC";
                          $rows = mysqli_query($con,$query2);

                          if(mysqli_num_rows($rows) > 0)
                          {
                            foreach ($rows as $row)
                            {
                              ?>
                              <option value="<?php echo $row['id'];?>"><?php echo $row['division'];?></option>
                              <?php
                            }
                            }else
                            {
                              ?>
                              <option value=" ">No Records Found</option>
                              <?php
                            }
                              ?>

                        </select>
                      </div>
                    </div>

                      </div>

                    <div class="row">

                    <div class="col-sm-3">
                      <div class="form-group">
                      <label>Contact No.:</label>
                        <input type="number" class="form-control" id="" name="contact_no" placeholder="Enter ...">
                      </div>
                    </div>

                    <div class="col-sm-3">
                      <div class="form-group">
                      <label>Email Address:</label>
                        <input type="text" class="form-control" id="" name="email_add" placeholder="Enter ...">
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <div class="form-group">
                      <label>Permanent Address:</label>
                        <input type="text" class="form-control" id="" name="address" placeholder="Enter ...">
                      </div>
                    </div>

                  </div>


                  <div class="row">

                  <div class="col-sm-4">
                      <div class="form-group">
                        <label>Gender:</label>
                        <select class="form-control" name="gender" id="access">
                          <option value="">--Select Gender--</option>
                          <option value="Male">Male</option>
                          <option value="Female">Female</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Civil Status:</label>
                        <select class="form-control" name="civil_status" id="access">
                          <option value="">--Select Gender--</option>
                          <option value="Single">Single</option>
                          <option value="Married">Married</option>
                          <option value="Divorced">Divorced</option>
                          <option value="Separated">Separated</option>
                          <option value="Widowed">Widowed</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="form-group">
                      <label>Birth date:</label>
                        <input type="date" class="form-control" id="password" name="bday" placeholder="Enter ...">
                      </div>
                    </div>
                  </div>

            </div>

            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" name="add_employee" id="" class="btn btn-primary">Add Employee</button>
            </div>
          </div>
          </form>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->


      <!-- Main Footer -->
      <?php include('../Footer/Footer.php'); ?>
      </div>
      <!-- ./wrapper -->

      <!-- REQUIRED SCRIPTS -->

      <!-- jQuery -->

      <?php include('../Footer/Script.php'); ?>
