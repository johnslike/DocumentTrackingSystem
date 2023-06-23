
<?php
require_once('../db/connect_db.php');
$id = $_GET['id'];
$Profile = $store->getProfile($id);
$store->add_photo($_POST);
$store->delete_photo($_POST);
$store->update_user($_POST);
$store->employee_file($_POST);

$date = date('Y-m-d');

include('useraccess.php');
include('../Header/Header.php');

?>

<title>Profile of <?php echo $Profile['fname']." ".$Profile['lname']; ?></title>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <!-- Navbar -->
  <?php include('../Header/navbar.php'); ?>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container">

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
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <button class="btn" data-toggle="modal" data-target="#add_photo<?php echo $Profile['id']?>" <?php if($Profile['picture'] != NULL){ echo "hidden"; } ?>>
                  <img class="profile-user-img img-fluid img-circle"
                       src="../files/profile_pic/pic.png"
                       alt="User profile picture">
                       </button>


                  <button class="btn" data-toggle="modal" data-target="#delete_photo<?php echo $Profile['id']?>" <?php if($Profile['picture'] == NULL){ echo "hidden"; } ?>>
                  <img class="profile-user-img img-fluid img-circle"
                       src="../files/profile_pic/<?php echo $Profile['picture']?>"
                       alt="User profile picture">
                       </button>
                </div>

                <h3 class="profile-username text-center"><?php echo $Profile['fname']." ".$Profile['minitial']." ".$Profile['lname']." ".$Profile['suffix'];?></h3>

                <p class="text-muted text-center"><?php echo $Profile['position'];?></p>

                <hr>

                <ul class="list-group list-group-unbordered mb-3">

                <strong><i class="far fa-id-card"></i> Employee ID</strong>

                <p class="text-muted"><?php echo $Profile['employee_id'];?></p>

                <strong><i class="fas fa-sign"></i> Division</strong>

                  <p class="text-muted">
                  <?php echo $Profile['division'];?>
                  </p>

                </ul>

                <a href="#" class="btn btn-success btn-block" data-toggle="modal" data-target="#edit_employee"><b>Edit</b></a>
                <a href="#" class="btn btn-primary btn-block" data-toggle="modal" data-target="#upload_file"><b>Upload File/s</b></a>
                <a href="employees" class="btn btn-info btn-block"><b>Back to Employees List</b></a>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                   <!-- /.user-block -->
                   <div class="row">
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <div class="col-sm-12">
                              <small class="text-muted text-center">Gender:</small>
                              <p><?php if($Profile['gender'] == NULL){
                              echo "--";
                              }else{
                              echo $Profile['gender'];
                              } ?></p>

                              <small class="text-muted text-center">Birth Date:</small>
                              <p><?php

                                if(isset($Profile['birth_date']) && $Profile['birth_date'] !="")
                                {
                                    $birth_date = date("F j, Y", strtotime($Profile['birth_date']));
                                }
                                else {
                                    $birth_date = "--";
                                }
                                echo $birth_date ; ?></p>

                              <small class="text-muted text-center">Address:</small>
                              <p><?php if($Profile['address'] == NULL){
                              echo "--";
                              }else{
                              echo $Profile['address'];
                              } ?></p>

                            </div>
                          <!-- /.row -->
                        </div>

                        <div class="col-sm-6">
                            <div class="col-sm-12">
                              <small class="text-muted text-center">Civil Status:</small>
                              <p><?php if($Profile['civil_status'] == NULL){
                              echo "--";
                              }else{
                              echo $Profile['civil_status'];
                              } ?></p>

                              <small class="text-muted text-center">Contact Number:</small>
                              <p><?php if($Profile['contact_no'] == NULL){
                              echo "--";
                              }else{
                              echo $Profile['contact_no'];
                              } ?></p>

                              <small class="text-muted text-center">Email Address:</small>
                              <p><?php if($Profile['email_add'] == NULL){
                              echo "--";
                              }else{
                              echo $Profile['email_add'];
                              } ?></p>

                            </div>
                          <!-- /.row -->

                        </div>
                        <!-- /.col -->

                      </div>
                      <!-- /.row -->
                      <div class="col-sm-6">
                              <p class="text-muted text">Uploaded Files:</p>
                              <table class="table table-striped">
                                      <thead>
                                      <tr>
                                        <th class="text-sm">Action</th>
                                        <th class="text-sm">Division</th>
                                        <th class="text-sm">Acted by</th>
                                        <th class="text-sm">Remarks</th>
                                        <th class="text-sm">Date Acted</th>
                                      </tr>
                                      </thead>
                                      <tbody>
                                      <tr>
                                      <?php if (is_array($Track) || is_object($Track))
                                        foreach($Track as $Tracks){?>

                                        <td style="width: 120px"><i><span class="text-sm"><?php if($Tracks['status'] == 2){ echo "<h7 class='text text-primary'>Forwarded to</h7>";}elseif($Tracks['status'] == 3){echo "<h7 class='text text-success'>Received by</h7>";}elseif($Tracks['status'] == 4){echo "<h9 class='text text-bold text-warning'>End Cycle by</h9>";}elseif($Tracks['status'] == 5){echo "<h7 class='text text-danger'>Returned to</h7>";}?></span></i></td>
                                        <td class="text-sm"><?php echo $Tracks['division'] ?></td>
                                        <td class="text-sm"><?php echo $Tracks['fname']." ".$Tracks['minitial']." ".$Tracks['lname']." ".$Tracks['suffix'] ?></td>
                                        <td class="text-sm"><?php echo $Tracks['remarks'] ?></td>
                                        <td class="text-xs"><?php

                                            if(isset($Tracks['date_acted']) && $Tracks['date_acted'] !="")
                                            {
                                                $date = date("F j, Y | h:sa", strtotime($Tracks['date_acted']));
                                            }
                                            else {
                                                $date = "";
                                            }
                                            echo $date ;
                                            ?></td>

                                      </tr>
                                      <?php } ?>
                                      </tbody>
                                    </table>

          <!-- /.col -->
        </div>
                  </div>
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
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

  <!-- Main Footer -->
  <?php include('../Footer/Footer.php'); ?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->

<?php include('../Footer/Script.php'); ?>

</body>
</html>

          <div class="modal fade" id="upload_file">
            <div class="modal-dialog modal-md">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Upload File</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form method = "post" enctype="multipart/form-data">
                <div class="card-body">
                <input type="hidden" class="form-control" name="id" value="<?php echo $Profile['id']?>" placeholder="Enter ...">
                <input type="hidden" class="form-control" name="fullname" value="<?php echo $Profile['fname']." ".$Profile['minitial']." ".$Profile['lname']." ".$Profile['suffix'];?>">

                    <div class="col-sm-12">
                      <div class="form-group">
                      <label>File name:</label>
                        <input type="text" class="form-control" id="" name="file_name" placeholder="Enter ..." required>
                      </div>
                    </div>

                        <div class="col-sm-12">
                          <div class="form-group">
                          <label>Employee Picture:</label>
                          <div class="custom-file">
                          <input type="file" class="custom-file-input" id="customFile" name="file" required>
                          <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>

                          </div>
                          </div>
                </div>


                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" name="employee_file" id="" class="btn btn-primary">Add Photo</button>
                </div>
              </div>
              </form>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
      <!-- /.modal -->



          <div class="modal fade" id="add_photo<?php echo $Profile['id']?>">
            <div class="modal-dialog modal-md">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Add Photo</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form method = "post" enctype="multipart/form-data">
                <div class="card-body">
                <input type="hidden" class="form-control" name="id" value="<?php echo $Profile['id']?>" placeholder="Enter ...">
                <input type="hidden" class="form-control" name="fullname" value="<?php echo $Profile['fname']." ".$Profile['minitial']." ".$Profile['lname']." ".$Profile['suffix'];?>">
                        <div class="col-sm-12">
                          <div class="form-group">
                          <label>Employee Picture:</label>
                          <div class="custom-file">
                          <input type="file" class="custom-file-input" id="customFile" name="file">
                          <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>

                          </div>
                          </div>
                </div>


                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" name="add_photo" id="" class="btn btn-primary">Add Photo</button>
                </div>
              </div>
              </form>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
      <!-- /.modal -->



                <div class="modal fade" id="delete_photo<?php echo $Profile['id']?>">
                      <div class="modal-dialog modal-sm">

                      <div class="modal-content bg-danger">

                      <div class="modal-header">
                        <h5 class="modal-title">Are you sure you want to delete this photo?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form method = "post" action="">
                      <input type="hidden" class="form-control" value="<?php echo $Profile['id'];?>" name="id" id="id">
                      <input type="hidden" class="form-control" value="<?php echo $Profile['picture'];?>" name="file_name" id="id">

                      <div class="col-sm-12">
                      <div class="form-group">
                      <!-- <label>File name:</label> -->

                            <img class="img-fluid" src="../files/profile_pic/<?php echo $Profile['picture']?>" alt="">

                      </div>
                      </div>

                      <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                        <button type="submit" name="delete_photo" class="btn btn-outline-light">Delete Photo</button>
                      </div>


                    </form>

                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>
              </div>
      <!-- /.modal -->


      <div class="modal fade" id="edit_employee">
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
                        <input type="hidden" class="form-control" name="id" placeholder="Enter ..." value="<?php echo $Profile['id'];?>">
                        <input type="text" class="form-control" name="fname" placeholder="Enter ..." value="<?php echo $Profile['fname'];?>">
                      </div>
                    </div>

                      <div class="col-sm-2">
                      <div class="form-group">
                      <span style="color:red">* </span><label>Middle Initial:</label>
                        <input type="text" class="form-control" name="mnitial" placeholder="Enter ..." value="<?php echo $Profile['minitial'];?>">
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="form-group">
                      <span style="color:red">* </span><label>Last Name:</label>
                        <input type="text" class="form-control" name="lname" placeholder="Enter ..." value="<?php echo $Profile['lname'];?>">
                      </div>
                    </div>

                      <div class="col-sm-2">
                      <div class="form-group">
                      </span><label>Suffix:</label>
                        <input type="text" class="form-control" name="suffix" value="<?php echo $Profile['suffix'];?>" placeholder="Enter ...">
                      </div>
                    </div>
                    </div>


                  <div class="row">
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                      <span style="color:red">* </span><label>Employee ID:</label>
                        <input type="text" class="form-control ictno_id" name="emp_id" placeholder="Enter ..." required value="<?php echo $Profile['employee_id'];?>">
                        <small class="error_ictno" style="color: red;"></small>
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="form-group">
                      <span style="color:red">* </span><label>Position:</label>
                       <select class="form-control" name="position" id="access">
                        <option value="">--Select Position--</option>

                        <?php $query2 = "SELECT * FROM setting_positions";
                              $rows = mysqli_query($con,$query2);

                            foreach ($rows as $row)
                            {
                              ?>
                              <option value="<?php echo $row['id']; ?>"<?php if($Profile['position_id'] == $row['id']) echo 'selected="selected"'; ?>><?php echo $row['position']; ?></option>
                              <?php
                            }

                              ?>

                        </select>
                      </div>
                    </div>


                    <div class="col-sm-4">
                      <div class="form-group">
                       <span style="color:red">* </span><label>Division:</label>
                       <select class="form-control" name="division" id="access">
                        <option value="">--Select Division--</option>

                        <?php $query2 = "SELECT * FROM setting_divisions";
                              $rows = mysqli_query($con,$query2);

                            foreach ($rows as $row)
                            {
                              ?>
                              <option value="<?php echo $row['id']; ?>"<?php if($Profile['division_id'] == $row['id']) echo 'selected="selected"'; ?>><?php echo $row['division']; ?></option>
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
                        <input type="number" class="form-control" id="" name="contact_no" placeholder="Enter ..." value="<?php echo $Profile['contact_no'];?>">
                      </div>
                    </div>

                    <div class="col-sm-3">
                      <div class="form-group">
                      <label>Email Address:</label>
                        <input type="text" class="form-control" id="" name="email_add" placeholder="Enter ..." value="<?php echo $Profile['email_add'];?>">
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <div class="form-group">
                      <label>Permanent Address:</label>
                        <input type="text" class="form-control" id="" name="address" placeholder="Enter ..." value="<?php echo $Profile['address'];?>">
                      </div>
                    </div>

                  </div>


                  <div class="row">

                  <div class="col-sm-4">
                      <div class="form-group">
                        <label>Gender:</label>
                        <select name="gender" class="form-control" id="">
                        <option value = "" ><i>--Select Gender--</i></option>
                        <option value = "Male" <?php if($Profile['gender'] == "Male"){echo "selected";}?>>Male</option>
                        <option value = "Female" <?php if($Profile['gender'] == "Female"){echo "selected";}?>>Female</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Civil Status:</label>
                        <select name="civil_status" class="form-control" id="">
                          <option value = "" ><i>--Select Gender--</i></option>
                          <option value = "Single" <?php if($Profile['civil_status'] == "Single"){echo "selected";}?>>Single</option>
                          <option value = "Married" <?php if($Profile['civil_status'] == "Married"){echo "selected";}?>>Married</option>
                          <option value = "Divorced" <?php if($Profile['civil_status'] == "Divorced"){echo "selected";}?>>Divorced</option>
                          <option value = "Separated" <?php if($Profile['civil_status'] == "Separated"){echo "selected";}?>>Separated</option>
                          <option value = "Widowed" <?php if($Profile['civil_status'] == "Widowed"){echo "selected";}?>>Widowed</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="form-group">
                      <label>Birth date:</label>
                        <input type="date" class="form-control" id="password" name="bday" placeholder="Enter ..." value="<?php echo $Profile['birth_date'];?>">
                      </div>
                    </div>
                  </div>

            </div>

            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" name="edit_employee" id="" class="btn btn-primary">Add Employee</button>
            </div>
          </div>
          </form>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
