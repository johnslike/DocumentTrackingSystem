
<?php
require_once('../db/connect_db.php');

$information=$store->get_info();
$store->add_requestor($_POST);


include('../Header/Header.php');

// $userdetails = $store->get_userdata();

// if(isset($userdetails)){
//   if($userdetails['access'] !="COE"){
//         header("Location: ../login.php");
//     }
// }else{
//     header("Location: ../login.php");
// }
?>

<title>List of Eligibility</title>
<body class="hold-transition layout-top-nav">
<div class="wrapper">


      <?php include('../Header/navbar.php'); ?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"> List of Certificate of Eligibility</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Layout</a></li> -->
              <li class="breadcrumb-item active">List</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

              <?php
                $con = mysqli_connect('localhost','root','123456','coe_database');

                mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
              ?>

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
            <div class="card-header">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_coe">
              <i class="fas fa-user-plus"></i>
              </button>
            </div>
              <div class="card-body">
              <table id="datatable" class="table table-bordered table-striped">
                  <thead class="text-nowrap">
                  <tr>
                      <th>Action</th>
                      <th>Fullname</th>
                      <th>Type of Examination</th>
                      <th>Place of Examination</th>
                      <th>Date of Examination</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php if (is_array($information) || is_object($information))
                    foreach($information as $info){?>
                    <tr>
                    <td><a type="button" class="btn btn-info btn-sm" href="Profile.php?id=<?php echo $info['id']?>"><i class="fas fa-eye"></i></a>
                    </td>

                    <td><?php echo $info['lname'].", ".$info['fname']." ".$info['minitial']." ".$info['suffix'];?></td>
                    <td><?php echo $info['type'];?></td>
                    <td><?php echo $info['place'];?></td>
                    <td><?php

                          if(isset($info['date_exam']) && $info['date_exam'] !="")
                          {
                              $date_exam = date("F j, Y", strtotime($info['date_exam']));
                          }
                          else {
                              $date_exam = "";
                          }
                          echo $date_exam ; ?></td>
                    </tr>

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


      <div class="modal fade" id="add_coe">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add New Eligibility</h4>
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
                        <input type="text" class="form-control" name="user_id" value="<?php echo $userdetails['id'] ?>" placeholder="Enter ..." required>
                        <input type="text" class="form-control" name="fname" placeholder="Enter ..." required>
                      </div>
                    </div>

                      <div class="col-sm-2">
                      <div class="form-group">
                      <span style="color:red">* </span><label>Middle Initial:</label>
                        <input type="text" class="form-control" name="mname" placeholder="Enter ..." required>
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="form-group">
                      <span style="color:red">* </span><label>Last Name:</label>
                        <input type="text" class="form-control" name="lname" placeholder="Enter ..." required>
                      </div>
                    </div>

                      <div class="col-sm-2">
                      <div class="form-group">
                      </span><label>Suffix:</label>
                        <input type="text" class="form-control" name="suffix" placeholder="Enter ...">
                      </div>
                    </div>
                    </div>

                    <div class="row">

                    <div class="col-sm-3">
                      <div class="form-group">
                      <span style="color:red">* </span><label>Gender:</label>
                        <select class="form-control" name="gender" required>
                          <option value="">--Select Gender--</option>
                          <option value="Male">Male</option>
                          <option value="Female">Female</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-2">
                      <div class="form-group">
                      <span style="color:red">* </span><label>Birth Date:</label>
                        <input type="date" class="form-control" name="bdate" placeholder="Enter ..." required>
                      </div>
                    </div>

                    <div class="col-sm-7">
                      <div class="form-group">
                      <span style="color:red">* </span></span><label>Place of Birth:</label>
                        <input type="text" class="form-control" name="place_birth" placeholder="Enter ..." required>
                      </div>
                    </div>

                  </div>

                  <hr>

                  <div class="row">

                    <div class="col-sm-3">
                      <div class="form-group">
                      <label>Rating:</label><span class="text-xs" style="color:red"> *Do not include %</span>
                        <input type="text" class="form-control" name="rating" placeholder="Enter ...">
                      </div>
                    </div>

                    <div class="col-sm-3">
                      <div class="form-group">
                      <span style="color:red">* </span><label>Type of Exam:</label>
                        <select class="form-control" name="type" required>
                        <option value="">--Select Type--</option>
                        <?php $query2 = "SELECT * FROM type_exam";
                              $rows = mysqli_query($con,$query2);

                            foreach ($rows as $row)
                            {
                              ?>
                              <option value="<?php echo $row['id'];?>"><?php echo $row['type'];?></option>
                              <?php
                            }
                              ?>
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-2">
                      <div class="form-group">
                      <span style="color:red">* </span><label>Date of Exam:</label>
                        <input type="date" class="form-control" name="date_exam" placeholder="Enter ..." required>
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="form-group">
                      <span style="color:red">* </span><label>Place of Exam:</label>
                        <select class="form-control" name="place_exam" required>
                        <option value="">--Select Place--</option>

                        <?php $query2 = "SELECT * FROM places_exam";
                              $rows = mysqli_query($con,$query2);

                            foreach ($rows as $row)
                            {
                              ?>
                              <option value="<?php echo $row['id'];?>"><?php echo $row['place'];?></option>
                              <?php
                            }

                              ?>

                        </select>
                      </div>
                    </div>

                    <!-- <div class="col-sm-12">
                      <div class="form-group">
                          <label>Purpose/s of Request:</label>
                            <select class="select2" name="purpose[]" multiple="multiple" data-placeholder="Select Purpose ..." style="width: 100%;" required>
                              <option value="Employment">Employment</option>
                              <option value="Promotion">Promotion</option>
                              <option value="Replace of Lost Certificate">Replace of Lost Certificate</option>
                              <option value="Replacement of Old/Torn/Worn-out Certificate">Replacement of Old/Torn/Worn-out Certificate</option>
                              <option value="Did Not Receive Original Certificate">Did Not Receive Original Certificate</option>

                            </select>
                      </div>
                    </div>   -->

                  </div>

                  <div class="row">
                      <div class="col-sm-3">
                        <div class="form-group">
                        <label>Book No.:</label>
                          <input type="text" class="form-control" name="book" placeholder="Enter ...">
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                        <label>Page No.:</label>
                          <input type="text" class="form-control" name="page" placeholder="Enter ...">
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                        <label>SN/LN:</label>
                          <input type="text" class="form-control" name="sn_ln" placeholder="Enter ...">
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                        <label>EN/CN:</label>
                          <input type="text" class="form-control" name="en_cn" placeholder="Enter ...">
                        </div>
                      </div>

                  </div>


            </div>

            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" name="add_requestor" id="" class="btn btn-primary">Save data</button>
            </div>
          </div>
          </form>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

