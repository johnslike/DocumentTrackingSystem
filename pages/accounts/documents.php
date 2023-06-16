<?php
require_once('../db/connect_db.php');
$store->add_document($_POST);
$store->forward_new_document($_POST);
$store->receive_new_document($_POST);
$store->end_cycle_document($_POST);
// $store->return_document($_POST);
$store->return_to_sender($_POST);
$store->delete_document($_POST);

include('useraccess.php');
include('../Header/Header.php');

?>


<title>Documents</title>
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
          <div class="col-sm-6">
            <a class="btn btn-success btn-sm" data-toggle="modal" data-target="#add_document">
            <i class="fas fa-plus"></i> Add Document</a>
          </div>
          <!-- /.col -->

        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row">
          <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                  <h4 class="m-0 text-center text-dark">Incoming Documents</h4>
                </div>
              <div class="card-body">
                <?php
                $division_id = $userdetails['division_id'];
                  $query1 = $con->query("SELECT t1.*, t2.id as document_log_id, t2.acted_by_division_id, t3.division, t4.division as sender_division FROM documents t1 LEFT JOIN document_log t2 ON t1.id = t2.document_id LEFT JOIN setting_divisions t3 ON t1.division_id = t3.id LEFT JOIN setting_divisions t4 ON t4.id = t1.from_division_id WHERE t1.route_to_division_id = $division_id AND t1.status IN (2,5) GROUP BY t1.id ORDER BY t2.date_acted ASC");
                  while($documents = $query1->fetch_assoc()){
                ?>

                <div class="card card-<?php if($documents['division_id'] == $division_id){ echo "success";}else{echo "primary";}?> card-outline">
                  <div class="card-header">
                    <h5 class="card-title m-0"><?php echo $documents['type'];?></h5>
                  </div>
                  <div class="card-body">
                    <h5 class="card-title"><?php echo $documents['subject'];?></h6>

                    <p class="card-text text-xs text-muted"><?php echo "Latest Remarks: ".$documents['latest_remarks'];?></p>



                    <span class="card-text text-xs text-success float-right"><i><?php echo "From ".$documents['division'];?></i></span>

                    <span class="card-text text-xs text-danger float-right"><i><?php if($documents['status'] == 5){ echo "This document has been returned";}?></i></span>
                    <br>


                    <button class="btn btn-xs btn-success" data-toggle="modal" data-target="#received_document<?php echo $documents['id']?>"><i class="fas fa-thumbs-up"></i> Receive</button>

                    <!-- <button class="btn btn-xs btn-warning float-right" data-toggle="modal" data-target="#return_document<?php echo $documents['id']?>"<?php if($documents['status'] == 5){ echo "hidden";}?>>Return</button> -->

                    <button class="btn btn-xs btn-danger float-right" data-toggle="modal" data-target="#return_from_sender<?php echo $documents['id']?>"<?php if($documents['status'] == 5){ echo "hidden";}?>><i class="fas fa-exclamation-circle"></i></button>

                  </div>
                </div>


                      <div class="modal fade" id="received_document<?php echo $documents['id']?>">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Receive Document</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <form method = "post">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-sm-4">
                                  <div class="form-group">
                                  <input type="hidden" class="form-control" name="document_id" value="<?php echo $documents['id'] ?>" required="required">
                                  <!-- <input type="hidden" class="form-control" name="document_id" value="<?php echo $documents['document_log_id'] ?>" required="required"> -->
                                  <input type="hidden" class="form-control" name="user_id" value="<?php echo $userdetails['id'] ?>" required="required">
                                  <input type="hidden" class="form-control" name="acted_division" value="<?php echo $userdetails['division_id'] ?>" required="required">
                                  <input type="hidden" class="form-control" name="status" value="3" required="required">
                                    <label>Tracking Number:</label>
                                    <input type="text" class="form-control" name="tracking_no" value="<?php echo $documents['tracking_no'] ?>" required="required" readonly>
                                  </div>
                                </div>

                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <label>Forwarded by:</label>
                                    <input type="hidden" class="form-control" name="forwarded_by" value="<?php echo $documents['division_id'] ?>" required="required" readonly>
                                    <input type="text" class="form-control" name="" value="<?php echo $documents['division'] ?>" required="required" readonly>
                                  </div>
                                </div>

                              </div>
                              <div class="row">

                                <div class="col-sm-12">
                                  <div class="form-group">
                                    <label>Subject:</label>
                                    <textarea name="subject" class="form-control" rows="1" readonly><?php echo $documents['subject'] ?></textarea>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <label>Type:</label>
                                    <input type="text" class="form-control" name="type" value="<?php echo $documents['type'] ?>" required="required" readonly>
                                  </div>
                                </div>

                                    <div class="col-sm-8">
                                      <label>Remarks:</label>
                                        <div class="form-group">
                                          <textarea name="remarks" class="form-control" rows="1" placeholder="Sample: Noted, ok, copy and etc."></textarea>
                                        </div>
                                    </div>
                              </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="submit" name="receive_document" id="" class="btn btn-success">Receive document</button>
                            </div>
                          </div>
                          </form>
                          <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                      </div>
                      <!-- /.modal -->


                      <div class="modal fade" id="return_from_sender<?php echo $documents['id']?>">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header bg-danger">
                              <h4 class="modal-title">This document is not ours!</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <form method = "post">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-sm-4">
                                  <div class="form-group">
                                  <input type="hidden" class="form-control" name="document_id" value="<?php echo $documents['id'] ?>" required="required">
                                  <input type="hidden" class="form-control" name="user_id" value="<?php echo $userdetails['id'] ?>" required="required">
                                  <!-- <input type="hidden" class="form-control" name="routed_to_division_id" value="<?php echo $documents['division_id'] ?>" required="required"> -->
                                  <input type="hidden" class="form-control" name="status" value="5" required="required">
                                    <label>Tracking Number:</label>
                                    <input type="text" class="form-control" name="tracking_no" value="<?php echo $documents['tracking_no'] ?>" required="required" readonly>
                                  </div>
                                </div>

                                <div class="col-sm-8">
                                  <div class="form-group">
                                    <label>Return to sender:</label>
                                    <input type="hidden" class="form-control" name="from_division_id" value="<?php echo $documents['from_division_id'] ?>" readonly>
                                    <input type="text" class="form-control" name="" value="<?php echo $documents['sender_division'] ?>" readonly>
                                  </div>
                                </div>

                              </div>
                              <div class="row">

                                <div class="col-sm-12">
                                  <div class="form-group">
                                    <label>Subject:</label>
                                    <textarea name="subject" class="form-control" rows="1" readonly><?php echo $documents['subject'] ?></textarea>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <label>Type:</label>
                                    <input type="text" class="form-control" name="type" value="<?php echo $documents['type'] ?>" readonly>
                                  </div>
                                </div>

                                    <div class="col-sm-8">
                                      <label>Remarks:</label>
                                        <div class="form-group">
                                          <textarea name="remarks" class="form-control" rows="1"></textarea>
                                        </div>
                                    </div>
                              </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="submit" name="return_to_sender" id="" class="btn btn-danger">Return to sender</button>
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
            </div>
        </div>
          <!-- /.col-md-6 -->
      <div class="col-lg-4">
        <div class="card">
          <div class="card-header">
            <h4 class="m-0 text-center text-dark"> New/Received Documents</h4>
          </div>
          <div class="card-body">

          <?php
                $division_id = $userdetails['division_id'];
                  $query1 = $con->query("SELECT t1.*, t3.division FROM documents t1 LEFT JOIN document_log t2 ON t1.id = t2.document_id LEFT JOIN setting_divisions t3 ON t1.division_id = t3.id WHERE t1.division_id = $division_id AND t1.status = 1 OR t1.route_to_division_id = $division_id AND t1.status = 3 GROUP BY t1.id ORDER BY t2.date_acted DESC");
                  while($documents = $query1->fetch_assoc()){
                ?>
                <div class="card card-<?php if($documents['division_id'] == $division_id){ echo "success";}else{echo "primary";}?> card-outline">
                  <div class="card-header">
                    <!-- <h5 class="card-title m-0"><?php echo $division_id;?></h5> -->
                    <h5 class="card-title m-0"><?php echo $documents['type'];?></h5>
                  </div>
                  <div class="card-body">
                    <h5 class="card-title"><?php echo $documents['subject'];?></h5>

                    <p class="card-text text-xs text-muted"><?php echo "Latest Remarks: ".$documents['latest_remarks'];?></p>

                    <span class="card-text text-xs text-success float-right"><i><?php if($documents['status'] == 1){ echo "Your document";}elseif($documents['status'] == 2){ echo "Forwarded from"." ".$documents['division'];}?></i></span>
                    <br>

                    <button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#forward_document<?php echo $documents['id']?>" <?php if($documents['status'] == 2){ echo "hidden";}?>><i class="fas fa-share"></i> Forward</button>

                    <button class="btn btn-xs btn-danger float-right" data-toggle="modal" data-target="#delete_document<?php echo $documents['id']?>" <?php if($documents['creator_id'] != $userdetails['id'] || $documents['status'] != 1){ echo "hidden";}?>><i class="fas fa-trash"></i> Delete</button>

                    <button class="btn btn-xs btn-warning float-right" data-toggle="modal" data-target="#end_document<?php echo $documents['id']?>" <?php if($documents['status'] == 1){ echo "hidden";}?>><i class="fas fa-check"></i> End Cycle</button>
                  </div>
                </div>



                <div class="modal fade" id="delete_document<?php echo $documents['id']?>">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header bg-danger">
                              <h4 class="modal-title">Delete this document</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <form method = "post">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-sm-4">
                                  <div class="form-group">
                                  <input type="hidden" class="form-control" name="document_id" value="<?php echo $documents['id'] ?>" required="required">

                                    <label>Tracking Number:</label>
                                    <input type="text" class="form-control" name="tracking_no" value="<?php echo $documents['tracking_no'] ?>" required="required" readonly>
                                  </div>
                                </div>

                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <label>Type:</label>
                                    <input type="text" class="form-control" name="type" value="<?php echo $documents['type'] ?>" readonly>
                                  </div>
                                </div>

                              </div>
                              <div class="row">

                                <div class="col-sm-12">
                                  <div class="form-group">
                                    <label>Subject:</label>
                                    <textarea name="subject" class="form-control" rows="1" readonly><?php echo $documents['subject'] ?></textarea>
                                  </div>
                                </div>
                              </div>


                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="submit" name="delete_document" id="" class="btn btn-danger">Delete</button>
                            </div>
                          </div>
                          </form>
                          <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                      </div>
                      <!-- /.modal -->


                <div class="modal fade" id="forward_document<?php echo $documents['id']?>">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Forward this document</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <form method = "post">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-sm-4">
                                  <div class="form-group">
                                  <input type="hidden" class="form-control" name="document_id" value="<?php echo $documents['id'] ?>" required="required">
                                  <input type="hidden" class="form-control" name="user_id" value="<?php echo $userdetails['id'] ?>" required="required">
                                  <input type="hidden" class="form-control" name="from_division_id" value="<?php echo $userdetails['division_id'] ?>" required="required">
                                  <input type="hidden" class="form-control" name="status" value="2" required="required">
                                    <label>Tracking Number:</label>
                                    <input type="text" class="form-control" name="tracking_no" value="<?php echo $documents['tracking_no'] ?>" required="required" readonly>
                                  </div>
                                </div>

                                <div class="col-sm-8">
                                  <div class="form-group">
                                    <span style="color:red">* </span><label>Forward to:</label>
                                    <select class="form-control" name="routed_to_division_id" id="access" required>
                                        <option value="">-- Select Divisions --</option>
                                        <?php $query2 = "SELECT * FROM setting_divisions WHERE id != $division_id";
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

                                <div class="col-sm-12">
                                  <div class="form-group">
                                    <label>Subject:</label>
                                    <textarea name="subject" class="form-control" rows="1" readonly><?php echo $documents['subject'] ?></textarea>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <label>Type:</label>
                                    <input type="text" class="form-control" name="type" value="<?php echo $documents['type'] ?>" readonly>
                                  </div>
                                </div>

                                    <div class="col-sm-8">
                                    <span style="color:red">* </span><label>Remarks:</label>
                                        <div class="form-group">
                                          <textarea name="remarks" class="form-control" rows="1" placeholder="Sample: for approval, for signature etc." required></textarea>
                                        </div>
                                    </div>
                              </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="submit" name="forward_new_document" id="" class="btn btn-primary">Forward</button>
                            </div>
                          </div>
                          </form>
                          <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                      </div>
                      <!-- /.modal -->


                <div class="modal fade" id="end_document<?php echo $documents['id']?>">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header bg-warning">
                              <h4 class="modal-title">End the cycle of this document</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <form method = "post">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-sm-4">
                                  <div class="form-group">
                                  <input type="hidden" class="form-control" name="document_id" value="<?php echo $documents['id'] ?>" required="required">
                                  <input type="hidden" class="form-control" name="user_id" value="<?php echo $userdetails['id'] ?>" required="required">
                                  <input type="hidden" class="form-control" name="end_to_division_id" value="<?php echo $userdetails['division_id'] ?>" required="required">
                                  <input type="hidden" class="form-control" name="status" value="4" required="required">
                                    <label>Tracking Number:</label>
                                    <input type="text" class="form-control" name="tracking_no" value="<?php echo $documents['tracking_no'] ?>" required="required" readonly>
                                  </div>
                                </div>

                              </div>
                              <div class="row">

                                <div class="col-sm-12">
                                  <div class="form-group">
                                    <label>Subject:</label>
                                    <textarea name="subject" class="form-control" rows="1" readonly><?php echo $documents['subject'] ?></textarea>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <label>Type:</label>
                                    <input type="text" class="form-control" name="type" value="<?php echo $documents['type'] ?>" readonly>
                                  </div>
                                </div>

                                    <div class="col-sm-8">
                                    <span style="color:red">* </span><label>Remarks:</label>
                                        <div class="form-group">
                                          <textarea name="remarks" class="form-control" rows="1" placeholder="Sample: Done and etc." required></textarea>
                                        </div>
                                    </div>
                              </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="submit" name="end_cycle_document" id="" class="btn btn-warning">End Cycle</button>
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
        </div>
      </div>
          <!-- /.col-md-6 -->
          <!-- /.col-md-6 -->
      <div class="col-lg-4">
        <div class="card">
          <div class="card-header">
            <h4 class="m-0 text-center text-dark">Active Documents</h4>
          </div>
          <div class="card-body">

             <?php
                $division_id = $userdetails['division_id'];
                  $query1 = $con->query("SELECT t1.*, t3.division FROM documents t1 LEFT JOIN document_log t2 ON t1.id = t2.document_id LEFT JOIN setting_divisions t3 ON t1.route_to_division_id = t3.id WHERE t1.division_id = $division_id AND t1.route_to_division_id IS NOT NULL AND t1.status != 4 GROUP BY t1.id ORDER BY t2.date_acted DESC");
                  while($documents = $query1->fetch_assoc()){
                ?>
                <div class="card card-success card-outline">
                  <div class="card-header">
                    <!-- <h5 class="card-title m-0"><?php echo $division_id;?></h5> -->
                    <h5 class="card-title m-0"><?php echo $documents['type'];?></h5>
                  </div>
                  <div class="card-body">
                    <h5 class="card-title"><?php echo $documents['subject'];?></h5>

                    <p class="card-text text-xs text-muted"><?php echo "Latest Remarks: ".$documents['latest_remarks'];?></p>

                    <span class="card-text text-xs text-success float-right"><i><?php if($documents['route_to_division_id'] == $division_id){ echo "Currently at your division";}elseif($documents['route_to_division_id'] != $division_id){ echo "Currently at ".$documents['division'];}?></i></span>
                    <br>

                    <button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#track_document<?php echo $documents['id']?>"><i class="fas fa-clock"></i> Track</button>
                  </div>
                </div>



                <div class="modal fade" id="track_document<?php echo $documents['id']?>">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">

                            <div class="card-body">
                                <div class="row">
                                  <div class="col-12">
                                    <h4>
                                      Document Tracking Form
                                      <small class="float-right text-xs">Date added:
                                        <?php

                                        if(isset($documents['date_added']) && $documents['date_added'] !="")
                                        {
                                            $date = date("F j, Y | h:sa", strtotime($documents['date_added']));
                                        }
                                        else {
                                            $date = "";
                                        }
                                        echo $date ;
                                        ?></small>
                                    </h4>
                                  </div>
                                  <!-- /.col -->
                                </div>



                                      <dl class="row">
                                        <dt class="col-sm-2">Tracking no</dt>
                                        <dd class="col-sm-10"><?php echo $documents['tracking_no'] ?></dd>
                                        <dt class="col-sm-2">Subject</dt>
                                        <dd class="col-sm-10"><?php echo $documents['subject'] ?></dd>
                                        <dt class="col-sm-2">Type</dt>
                                        <dd class="col-sm-10"><?php echo $documents['type'] ?></dd>
                                      </dl>

                                      <table class="table table-striped">
                                      <thead>
                                      <tr>
                                        <th>Action</th>
                                        <th>Division</th>
                                        <th>Acted by</th>
                                        <th>Remarks</th>
                                        <th>Date Acted</th>
                                      </tr>
                                      </thead>
                                      <tbody>
                                      <tr>
                                      <?php
                                        $document_id = $documents['id'];
                                          $query2 = $con->query("SELECT t1.*, t2.division, t3.fname, t3.minitial, t3.lname, t3.suffix FROM document_log t1 LEFT JOIN setting_divisions t2 ON t1.acted_by_division_id = t2.id LEFT JOIN setting_users t3 ON t1.acted_by_user_id = t3.id WHERE document_id = $document_id GROUP BY t1.id ORDER BY t1.date_acted ASC");
                                          while($track_documents = $query2->fetch_assoc()){
                                      ?>

                                        <td style="width: 120px"><i><span class="text-sm"><?php if($track_documents['status'] == 2){ echo "Forwarded to";}elseif($track_documents['status'] == 3){echo "Received by";}elseif($track_documents['status'] == 4){echo "End Cycle by";}elseif($track_documents['status'] == 5){echo "Returned by";}?></span></i></td>
                                        <td><?php echo $track_documents['division'] ?></td>
                                        <td><?php echo $track_documents['fname']." ".$track_documents['minitial']." ".$track_documents['lname']." ".$track_documents['suffix'] ?></td>
                                        <td><?php echo $track_documents['remarks'] ?></td>
                                        <td class="text-xs"><?php

                                            if(isset($track_documents['date_acted']) && $track_documents['date_acted'] !="")
                                            {
                                                $date = date("F j, Y | h:sa", strtotime($track_documents['date_acted']));
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
                            <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                            </div>
                          </div>

                          <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                      </div>
                      <!-- /.modal -->

                <?php } ?>

          </div>
        </div>
      </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->


      <div class="modal fade" id="add_document">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add New Document</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method = "post">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-4">
                  <div class="form-group">
                  <input type="hidden" class="form-control" name="user_id" value="<?php echo $userdetails['id'] ?>" required="required">
                  <input type="hidden" class="form-control" name="division_id" value="<?php echo $userdetails['division_id'] ?>" required="required">
                  <input type="hidden" class="form-control" name="status" value="1" required="required">
                    <label>Automated Tracking Number:</label>
                    <input type="text" class="form-control" name="tracking_no" value="<?php echo $tracking_no ?>" required="required" readonly>
                  </div>
                </div>

                <div class="col-sm-4">
                  <div class="form-group">
                  <span style="color:red">* </span><label>Type:</label>
                    <select class="form-control" name="type" id="access" required>
                        <option value="">-- Select Type --</option>
                        <option value="DB">DB</option>
                        <option value="DTR">DTR</option>
                        <option value="Other documents">Other documents</option>
                        </select>
                  </div>
                </div>

              </div>
              <div class="row">

                <div class="col-sm-12">
                  <div class="form-group">
                    <span style="color:red">* </span><label>Subject:</label>
                    <textarea name="subject" class="form-control" rows="2" placeholder="Enter subject ..." required></textarea>
                  </div>
                </div>
              </div>

                    <!-- <div class="col-sm-8">
                      <label>Remarks:</label>
                        <div class="form-group">
                          <textarea name="remarks" class="form-control" rows="2" placeholder="Enter remarks ..." required></textarea>
                        </div>
                    </div> -->


            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" name="add_document" id="" class="btn btn-success">Add Document</button>

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


  <?php if (isset($_GET["msg"]) && $_GET["msg"] == 'add_document') { ?>

          echo "<script>

          $(function(){
                Swal.fire({
                position: 'top-end',
                toast: true,
                icon: 'success',
                title: 'Saved!',
                text: 'Na saved na ang documents!',
                showConfirmButton: false,
                timer: 3000
            })
        });

        </script>"; <?php
         unset($_GET['msg']);}
           ?>


  <!-- <?php

  if (isset($_SESSION['msg']) && $_SESSION['msg'] != '') {
?>
         <script>

          $(function(){
                Swal.fire({
                position: "top-end",
                toast: true,
                icon: "success",
                title: "Saved!",
                text: "Na saved na ang documents!",
                showConfirmButton: false,
                timer: 3000
            })
        });

        </script>
          <?php unset($_SESSION['msg']);} ?> -->

