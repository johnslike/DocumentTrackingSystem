<?php
require_once('../db/connect_db.php');
$id = $_GET['id'];
$Details = $store->getDocumentsDetails($id);
$Track = $store->getTrackingno($id);
$Files = $store->get_files($id);
$store->add_files($_POST);
$store->delete_file($_POST);

include('adminaccess.php');
include('../Header/Header.php');

?>


<title>List of Documents</title>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <!-- Navbar -->
  <?php include('../Header/navbaradmin.php'); ?>
  <!-- /.navbar -->

                <?php
                  $con = mysqli_connect('localhost','root','123456','dts_database');


                  $randomno=rand(0,100000);
                  $tracking_no=date('m-d-Y-').$randomno;
                ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container">
        <div class="row mb-2">

        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <!-- Profile Image -->
            <div class="card card card-outline">
              <div class="card-body box-profile">
                <small class="text-muted text-center">Tracking Number:</small>
                <h5 class="text-center"><?php echo $Details['tracking_no'];?></h5>

                <hr>

                <small class="text-muted text-center">Type of Document:</small>
                <h5 class="text-center"><?php if($Details['type'] == NULL){
                        echo "--";
                        }else{
                        echo $Details['type'];
                        }
                    ?></h5>

                <hr>

                  <small class="text-muted">Subject:</small>
                    <br><b><h5 class="text-center"><?php if($Details['subject'] == NULL){
                        echo "--";
                        }else{
                        echo $Details['subject'];
                        }
                    ?></h5></b>

                <hr>
                    <small class="text-muted">Date Added:</small>
                    <br><b><h5 class="text-center"><?php

                    if(isset($Details['date_added']) && $Details['date_added'] !="")
                    {
                        $birth_date = date("F j, Y", strtotime($Details['date_added']));
                    }
                    else {
                        $birth_date = "--";
                    }
                    echo $birth_date ; ?></h5></b>



                <!-- <button type="button" class="btn btn-primary btn-sm btn-block" data-toggle="modal" data-target="#add_files" <?php if($Details['id'] == NULL){ ?> hidden <?php }?>><b>Upload Files</b></button> -->

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card">
              <div class="card-header">
                <h3 class="card-title">Files Uploaded</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <?php if (is_array($Files) || is_object($Files))
                                    foreach($Files as $File){?>
                <a class="btn btn-xs btn-info" href="../files/document_files/<?php echo $File['renamed']?>" <?php if ($File['renamed'] == null){ ?> hidden <?php } ?>  target="_blank"><i class="fas fa-eye"></i> View</a>

                <!-- <a href="#" class="btn-xs btn-danger float-right" data-toggle="modal" data-target="#delete_file<?php echo $File['file_id']?>" <?php if ($File['renamed'] == null){ ?> hidden <?php } ?>><i class="fas fa-trash"></i> Delete</a> -->
                <br>

                <p class="text-muted">
                <?php echo $File['original_name'];?>
                </p>

                <hr>


                <div class="modal fade" id="delete_file<?php echo $File['file_id']?>">
                        <div class="modal-dialog modal-md">
                          <div class="modal-content">
                            <div class="modal-header bg-danger">
                              <h4 class="modal-title">Delete this file?</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <form method = "post">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-sm-12">
                                  <div class="form-group">
                                  <input type="hidden" class="form-control" name="id" value="<?php echo $Details['id'] ?>" required="required">
                                  <input type="hidden" class="form-control" name="file_id" value="<?php echo $File['file_id'] ?>" required="required">
                                  <input type="hidden" class="form-control" name="filename" value="<?php echo $File['renamed'] ?>" required="required">

                                    <label>File Name:</label>
                                    <input type="text" class="form-control" name="tracking_no" value="<?php echo $File['original_name'] ?>" required="required" readonly>
                                  </div>
                                </div>

                              </div>


                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="submit" name="delete_file" id="" class="btn btn-danger">Delete</button>
                            </div>
                          </div>
                          </form>
                          <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                      </div>
                      <!-- /.modal -->

                <?php } ?>


              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-sm-9">
                              <h4 class="text-muted text">Document route:</h4>
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

                            </div>
                          <!-- /.row -->
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
<!-- ./wrapper -->


<div class="modal fade" id="add_files">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add Files</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method = "post" enctype="multipart/form-data">
            <div class="card-body">
            <input type="hidden" class="form-control" name="id" value="<?php echo $Details['id']?>" placeholder="Enter ...">
            <input type="hidden" class="form-control" name="tracking_no" value="<?php echo $Details['tracking_no']?>" placeholder="Enter ...">
            <input type="hidden" class="form-control" name="subject[]" value="<?php echo $Details['subject'];?>">
              <!-- <h1> Select the files you want to upload </h1>
              <input type="file" name="files[]" multiple >

              <button type="submit" name="upload">Upload files</button> -->
                    <div class="col-sm-12">
                      <div class="form-group">
                      <label>Files:</label>
                      <div class="custom-file">
                      <input type="file" class="custom-file-input" name="files[]" multiple="multiple" id="exampleInputFile">
                      <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                    </div>

                      </div>
                      </div>
            </div>


            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" name="upload" id="" class="btn btn-primary">Save files</button>
            </div>
          </div>
          </form>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

  <?php include('../Footer/Footer.php'); ?>

  <?php include('../Footer/Script.php'); ?>
