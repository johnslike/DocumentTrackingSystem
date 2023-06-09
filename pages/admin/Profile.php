
<?php
require_once('../db/connect_db.php');
$id = $_GET['id'];
$Details = $store->get_Details($id);
$DateRelease = $store->getDateRelease($id);
// $information=$store->get_info();
// $store->add_rono($_POST);
$store->add_requestor($_POST);
$store->update_requestor($_POST);
$store->add_release($_POST);
$store->add_signer_print($_POST);

$date = date('Y-m-d');

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

<title>Profile of <?php echo $Details['fname']." ".$Details['lname']; ?></title>
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
            <h1 class="m-0">Information of <?php echo $Details['fname']." ".$Details['lname']; ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="ListofCOE.php">List</a></li>
              <!-- <li class="breadcrumb-item"><a href="#">Layout</a></li> -->
              <li class="breadcrumb-item active">Profile</li>
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
    <section class="content">
      <div class="container">
        <div class="row">
          <div class="col-md-4">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <small class="text-muted text-center">Full Name (Lname, Fname M.N Suffix):</small>
                <h3 class="text-center"><?php echo $Details['lname'].", ".$Details['fname']." ".$Details['minitial']." ".$Details['suffix'];?></h3>
                
                <small class="text-muted text-center">Type of Exam:</small>
                <b><h5 class="text-center"><?php if($Details['type'] == NULL){
                        echo "--";
                        }else{
                        echo $Details['type'];
                        }
                    ?></h5></b>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <small class="text-muted">Rating:</small>
                    <br><b><h5 class="text-center"><?php if($Details['rating'] == NULL){
                        echo "--";
                        }else{
                        echo $Details['rating']."%";
                        }
                    ?></h5></b>
                    
                  </li>
                  <li class="list-group-item">
                    <small class="text-muted">Place of Examination</small>
                    <br><b><h5 class="text-center"><?php if($Details['place'] == NULL){
                        echo "--";
                        }else{
                        echo $Details['place'];
                        }
                    ?></h5></b>
                  </li>
                  <li class="list-group-item">
                    <small class="text-muted">Date of Examination</small> 
                    <br><b><h5 class="text-center"><?php 

                    if(isset($Details['date_exam']) && $Details['date_exam'] !="")
                    {
                        $birth_date = date("F j, Y", strtotime($Details['date_exam']));
                    }
                    else {
                        $birth_date = "--";
                    }
                    echo $birth_date ; ?></h5></b>
                  </li>
                </ul>

                <button type="button" class="btn btn-primary btn-sm btn-block" data-toggle="modal" data-target="#select_signer" <?php if($Details['ro_no'] == NULL){ ?> hidden <?php }?>><b>Print</b></button>

                <!-- <a href="Print.php?id=<?php echo $Details['id']?>" class="btn btn-primary btn-sm btn-block" <?php if($Details['ro_no'] == NULL){ ?> hidden <?php }?>><b>Print</b></a> -->

                <!-- <button type="button" class="btn btn-primary btn-sm btn-block" data-toggle="modal" data-target="#ro_no" <?php if($Details['ro_no'] == NULL AND $Details['date_requested'] == $date){ ?> hidden <?php }?>><b>Print without RO No</b></button> -->

                <!-- <button type="button" class="btn btn-primary btn-sm btn-block" data-toggle="modal" data-target="#ro_no" <?php if($Details['ro_no'] == NULL AND $Details['date_requested'] != $date){ ?> hidden <?php }?>><b>Print Another Current Copy</b></button> -->
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
          <!-- /.col -->
          <div class="col-md-8">
            <div class="card">
              <div class="card-header">
                <a href="ListofCOE.php" class="btn btn-sm btn-primary">Back</a>
                <button type="button" class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#add_coe">
                Edit
              </button>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">

                    <!-- Post -->
                    <div class="">
                      <!-- /.user-block -->
                      <div class="row">
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <div class="col-sm-12">
                              <small class="text-muted text-center">Gender:</small>
                              <p><?php if($Details['gender'] == NULL){
                              echo "--";
                              }else{
                              echo $Details['gender'];
                              } ?></p>

                              <small class="text-muted text-center">Birth Date:</small>
                              <p><?php 

                                if(isset($Details['birth_date']) && $Details['birth_date'] !="")
                                {
                                    $birth_date = date("F j, Y", strtotime($Details['birth_date']));
                                }
                                else {
                                    $birth_date = "--";
                                }
                                echo $birth_date ; ?></p>

                              <small class="text-muted text-center">Place of Birth:</small>
                              <p><?php if($Details['birth_place'] == NULL){
                              echo "--";
                              }else{
                              echo $Details['birth_place'];
                              } ?></p>

                               
                              <small class="text-muted text-center">Date of Release:</small>
                              <p><?php 

                                if(isset($Details['date_release']) && $Details['date_release'] !="")
                                {
                                    $date_release = date("F j, Y", strtotime($Details['date_release']));
                                }
                                else {?>
                                  <?php
                                  if (is_array($DateRelease) || is_object($DateRelease))
                                   foreach($DateRelease as $release){?>

                                    <?php if(isset($release['date_release']) && $release['date_release'] !="")
                                    {
                                    $date_release = date("F j, Y", strtotime($release['date_release']));
                                    echo $date_release." | <i class='text-sm'>Reason: </i>";

                                    echo $release['reason'];

                                    }?>
                                </p>
                                
                                <?php } ?>
                                <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#add_release" <?php if($Details['date_requested'] == $date){ ?> hidden <?php }?>>Add date release
                                </button>
                                <?php } ?>
                              
                            </div>
                          <!-- /.row -->
                        </div>
                        
                        <div class="col-sm-6">
                            <div class="col-sm-12">
                              <small class="text-muted text-center">Book Number:</small>
                              <p><?php if($Details['book_no'] == NULL){
                              echo "--";
                              }else{
                              echo $Details['book_no'];
                              } ?></p>

                              <small class="text-muted text-center">Page Number:</small>
                              <p><?php if($Details['page_no'] == NULL){
                              echo "--";
                              }else{
                              echo $Details['page_no'];
                              } ?></p>

                              <small class="text-muted text-center">SN/LN:</small>
                              <p><?php if($Details['sn_ln'] == NULL){
                              echo "--";
                              }else{
                              echo $Details['sn_ln'];
                              } ?></p>

                              <small class="text-muted text-center">EN/CN:</small>
                              <p><?php if($Details['en_cn'] == NULL){
                              echo "--";
                              }else{
                              echo $Details['en_cn'];
                              } ?></p>
                            </div>
                          <!-- /.row -->
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->

                    </div>
                    <!-- /.post -->
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


      <div class="modal fade" id="add_coe">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Take Action</h4>
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
                        <input type="hidden" class="form-control" name="id" value="<?php echo $Details['id'] ?>" placeholder="Enter ..." required>
                        <input type="text" class="form-control" name="fname" value="<?php echo $Details['fname'] ?>" placeholder="Enter ..." required>
                      </div>
                    </div>

                      <div class="col-sm-2">
                      <div class="form-group">
                      <span style="color:red">* </span><label>Middle Initial:</label>
                        <input type="text" class="form-control" name="mname" value="<?php echo $Details['minitial'] ?>" placeholder="Enter ..." required>
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="form-group">
                      <span style="color:red">* </span><label>Last Name:</label>
                        <input type="text" class="form-control" name="lname" value="<?php echo $Details['lname'] ?>" placeholder="Enter ..." required>
                      </div>
                    </div>

                      <div class="col-sm-2">
                      <div class="form-group">
                      </span><label>Suffix:</label>
                        <input type="text" class="form-control" name="suffix" value="<?php echo $Details['suffix'] ?>" placeholder="Enter ...">
                      </div>
                    </div>
                    </div>

                    <div class="row">

                    <div class="col-sm-3">
                      <div class="form-group">
                        <label>Gender:</label>
                        <select class="form-control" name="gender">
                          <option value = "" ><i>--Blank--</i></option>
                          <option value = "Male" <?php if($Details['gender'] == "Male"){echo "selected";}?>>Male</option>
                          <option value = "Female" <?php if($Details['gender'] == "Female"){echo "selected";}?>>Female</option>
                        </select>
                      </div>
                    </div>

                    <!-- <div class="col-sm-3">
                      <div class="form-group">
                        <label>Civil Status:</label>
                        <select class="form-control" name="status">
                          <option value="">--Select Status--</option>
                          <option value="Single">Single</option>
                          <option value="Married">Married</option>
                          <option value="Divorced">Divorced</option>
                          <option value="Widowed">Widowed </option>
                        </select>
                      </div>
                    </div> -->

                    <div class="col-sm-2">
                      <div class="form-group">
                      <label>Birth Date:</label>
                        <input type="date" class="form-control" name="bdate" value="<?php echo $Details['birth_date'] ?>" placeholder="Enter ...">
                      </div>
                    </div>

                    <div class="col-sm-7">
                      <div class="form-group">
                      </span><label>Place of Birth:</label>
                        <input type="text" class="form-control" name="place_birth" value="<?php echo $Details['birth_place'] ?>" placeholder="Enter ...">
                      </div>
                    </div>

                  </div>

                  <hr>
                  
                  <div class="row">

                    <div class="col-sm-2">
                      <div class="form-group">
                      <label>Rating:</label>
                        <input type="text" class="form-control" name="rating" value="<?php echo $Details['rating'] ?>" placeholder="Enter ...">
                      </div>
                    </div>

                    <div class="col-sm-3">
                      <div class="form-group">
                      <span style="color:red">* </span><label>Type of Exam:</label>
                        <select class="form-control" name="type">
                        <option value="">--Select Type--</option>
                        <?php $query2 = "SELECT * FROM `type_exam`";
                          $rows = mysqli_query($con,$query2);

                          if(mysqli_num_rows($rows) > 0)
                          {
                            foreach ($rows as $row)
                            {
                            ?>
                            <option value="<?php echo $row['id']; ?>"<?php if($Details['id_type'] == $row['id']) echo 'selected="selected"'; ?>><?php echo $row['type']; ?></option>
                            <?php
                            }
                            }else
                            {
                              ?>
                              <option value=" ">School not found</option>
                              <?php
                            }
                              ?>
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-3">
                      <div class="form-group">
                      <label>Date of Exam:</label>
                        <input type="date" class="form-control" name="date_exam" value="<?php echo $Details['date_exam'] ?>" placeholder="Enter ...">
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="form-group">
                      <span style="color:red">* </span><label>Place of Exam:</label>
                        <select class="form-control" name="place_exam">
                        <option value="">--Select Place--</option>

                        <?php $query = "SELECT * FROM `places_exam`";
                          $rows1 = mysqli_query($con,$query);

                          if(mysqli_num_rows($rows1) > 0)
                          {
                            foreach ($rows1 as $row1)
                            {
                            ?>
                            <option value="<?php echo $row1['id']; ?>"<?php if($Details['id_place'] == $row1['id']) echo 'selected="selected"'; ?>><?php echo $row1['place']; ?></option>
                            <?php
                            }
                            }else
                            {
                              ?>
                              <option value=" ">School not found</option>
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
                          <input type="text" class="form-control" name="book" value="<?php echo $Details['book_no'] ?>" placeholder="Enter ...">
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                        <label>Page No.:</label>
                          <input type="text" class="form-control" name="page" value="<?php echo $Details['page_no'] ?>" placeholder="Enter ...">
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                        <label>SN/LN:</label>
                          <input type="text" class="form-control" name="sn_ln" value="<?php echo $Details['sn_ln'] ?>" placeholder="Enter ...">
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                        <label>EN/CN:</label>
                          <input type="text" class="form-control" name="en_cn" value="<?php echo $Details['en_cn'] ?>" placeholder="Enter ...">
                        </div>
                      </div>

                  </div>
                  
            
            </div>

            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" name="edit_requestor" id="" class="btn btn-primary">Edit data</button>
            </div>
          </div>
          </form>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      
      <div class="modal fade" id="select_signer">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Select Signer</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method = "post">
            <div class="card-body">
            <input type="hidden" class="form-control" name="id" value="<?php echo $Details['id'] ?>" placeholder="Enter ..." required>
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                      <label>Signed by:</label>
                      <select class="form-control" name="signer" required>
                        <option value="">--Select Signer--</option>
                        <?php $query5 = "SELECT * FROM signer";
                              $rows4 = mysqli_query($con,$query5);

                            foreach ($rows4 as $row)
                            {
                              ?>
                              <option value="<?php echo $row['id'];?>"><?php echo $row['heads'];?></option>
                              <?php
                            }
                              ?>
                        </select>
                      </div>
                    </div>
                    
               
            </div>

            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" name="add_signer_print" id="" class="btn btn-primary">Confirm and Print</button>
            </div>
          </div>
          </form>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <?php
      $profile_id = $id;
      
      $datefor_rono = date('ymd');
      
      $sql = $con ->query("SELECT `no` FROM ro_no WHERE date_requested = '$date' AND requestor_id = '$profile_id'");
        $row = $sql->fetch_array();

        $no_assigned = isset($row['no']);
        if($no_assigned == "" || $no_assigned == NULL)
        {
          $no_assigned_now = $no_assigned;
        }else{
          $no_assigned_now = "";
        }

      $sql1 = $con ->query("SELECT COUNT(`no`) as total_no, `no`  FROM ro_no WHERE date_requested = '$date'");
        $row1 = $sql1->fetch_array();
        $number_requested_this_day = $row1['total_no'];

        if($number_requested_this_day == "" || $number_requested_this_day == NULL)
        {
          $newno = $number_requested_this_day;
        }else{
          $newno1 = $number_requested_this_day + 1;
          $newno = str_pad($newno1, 2, '0', STR_PAD_LEFT);

        }

      ?>


      <div class="modal fade" id="add_release">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add Date Release</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method = "post">
            <div class="card-body">
                    <div class="row">

                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                      <label>RO No:</label><br><span class="text-xs" style="color:red"> Note: If you confirm. RO No. will automatically assigned to this profile.</span>
                        <input type="hidden" class="form-control" name="id" value="<?php echo $Details['id']; ?>" placeholder="Enter Place...">

                        <input type="text" class="form-control"  value="RO-<?php echo $Details['type_no']."16".$datefor_rono."-".$newno;?>" readonly>


                        <input type="hidden" class="form-control" name="ro_no" value="<?php echo $Details['type_no']."16".$datefor_rono ?>">


                        <input type="hidden" class="form-control" name="assigned_no" value="<?php echo $newno ?>">


                        <input type="date" class="form-control" name="date_no" value="<?php echo $date ?>" placeholder="Enter Place..." required="required" hidden>

                        <!-- <input type="text" class="form-control" name="no" value="<?php echo $newno ?>" placeholder="Enter Place..." required="required"> -->

                        <!-- <small class="error_fullname" style="color: red;"></small> -->
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                      <label>Reason:</label>
                        <input type="text" class="form-control" name="reason" placeholder="Enter Place...">
                        <!-- <small class="error_fullname" style="color: red;"></small> -->
                      </div>
                    </div>
                    
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                      <span style="color:red">* </span><label>Date Release:</label>
                        <input type="date" class="form-control" name="date_release" placeholder="Enter Place..." required="required">
                        <!-- <small class="error_fullname" style="color: red;"></small> -->
                      </div>
                    </div>
                  </div>
            </div>

            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" name="add_release_rono" id="" class="btn btn-primary">Confirm</button>
            </div>
          </div>
          </form>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->


