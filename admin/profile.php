
<?php
require_once('../db/connect_db.php');
$id = $_GET['id'];
$Profile = $store->getProfile($id);
$store->add_photo($_POST);
$store->delete_photo($_POST);

$date = date('Y-m-d');

include('adminaccess.php');
include('../Header/Header.php');

?>

<title>Profile of <?php echo $Profile['fname']." ".$Profile['lname']; ?></title>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <!-- Navbar -->
  <?php include('../Header/navbaradmin.php'); ?>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container">

      </div><!-- /.container-fluid -->
    </section>

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

                <p class="text-muted"><?php echo $Profile['contact_no'];?></p>

                <strong><i class="fas fa-sign"></i> Division</strong>

                  <p class="text-muted">
                  <?php echo $Profile['division'];?>
                  </p>

                </ul>

                <a href="#" class="btn btn-success btn-block"><b>Edit</b></a>
                <a href="employees" class="btn btn-primary btn-block"><b>Back to Employees List</b></a>
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
