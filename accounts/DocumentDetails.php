<?php
require_once('../db/connect_db.php');
$id = $_GET['id'];
$Details = $store->getDocumentsDetails($id);
$Track = $store->getTrackingno($id);
$Files = $store->get_files($id);
$store->add_files($_POST);

include('useraccess.php');
include('../Header/Header.php');

?>


<title>List of Documents</title>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <!-- Navbar -->
  <?php include('../Header/navbar.php'); ?>
  <!-- /.navbar -->

                <?php
                  $con = mysqli_connect('localhost','root','123456','dts_database');


                  $randomno=rand(0,100000);
                  $tracking_no=date('m-d-Y-').$randomno;
                ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <!-- <div class="col-sm-6">
          <a class="btn btn-primary" data-toggle="modal" data-target="#add_document">
                    <i class="fas fa-plus"></i></a>
          </div> -->
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
     <!-- Main content -->
     <section class="content">
      <div class="container">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <small class="text-muted text-center">Tracking Number:</small>
                <h5 class="text-center"><?php echo $Details['tracking_no'];?></h5>

                <small class="text-muted text-center">Type of Document:</small>
                <b><h5 class="text-center"><?php if($Details['type'] == NULL){
                        echo "--";
                        }else{
                        echo $Details['type'];
                        }
                    ?></h5></b>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <small class="text-muted">Subject:</small>
                    <br><b><h5 class="text-center"><?php if($Details['subject'] == NULL){
                        echo "--";
                        }else{
                        echo $Details['subject'];
                        }
                    ?></h5></b>

                  </li>

                  <li class="list-group-item">
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
                  </li>
                </ul>

                <button type="button" class="btn btn-primary btn-sm btn-block" data-toggle="modal" data-target="#add_files" <?php if($Details['id'] == NULL){ ?> hidden <?php }?>><b>Upload Files</b></button>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
          <!-- /.col -->
          <div class="col-md-6">
            <div class="card">
              <!-- <div class="card-header">
                <a href="ListofCOE.php" class="btn btn-sm btn-primary">Back</a>
                <button type="button" class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#add_coe">
                Edit
              </button>
              </div> -->
              <!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">

                    <!-- Post -->
                    <div class="">
                      <!-- /.user-block -->
                      <div class="row">
                        <!-- /.col -->
                        <div class="col-sm-12">
                            <div class="col-sm-12">
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

                                        <td style="width: 120px"><i><span class="text-sm"><?php if($Tracks['status'] == 2){ echo "<h7 class='text text-primary'>Forwarded to</h7>";}elseif($Tracks['status'] == 3){echo "<h7 class='text text-success'>Received by</h7>";}elseif($Tracks['status'] == 4){echo "<h9 class='text text-bold text-warning'>End Cycle by</h9>";}elseif($Tracks['status'] == 5){echo "<h7 class='text text-danger'>Returned by</h7>";}?></span></i></td>
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

          <div class="col-md-3">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Files</h3>


              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table">
                  <thead>
                    <tr>
                      <th class="text-xs">Action</th>
                      <th class="text-xs">Files</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                    <?php if (is_array($Files) || is_object($Files))
                          foreach($Files as $File){?>
                      <td><?php echo $File['renamed'] ?></td>

                    <td <?php if ($file['renamed'] != null){ ?> hidden <?php } ?> class=""><i>No file attached...</i></td>
                    <td>&nbsp; &nbsp; <?php echo $file['renamed'] ?></td>

                    <td class="text-center text-xs"><a class="btn-sm btn-info" href="../scannedfile/<?php echo $file['renamed']?>" target="_blank" <?php if ($file['renamed'] == null){ ?> hidden <?php } ?>><i class="fas fa-eye"></i></a>
                    <a href="#" class="btn-sm btn-danger" data-toggle="modal" data-target="#delete_file<?php echo $file['id']?>" <?php if ($file['renamed'] == null){ ?> hidden <?php } ?>><i class="fas fa-trash"></i></a></td>
                    <?php } ?>
                    </tr>
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
                      <input type="file" class="custom-file-input" name="files[]" multiple="multiple">
                      <label class="custom-file-label" >Choose file</label>
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
