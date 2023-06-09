<?php
require_once('../db/connect_db.php');

// $id = $_GET['id'];

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
          <a class="btn btn-primary" data-toggle="modal" data-target="#add_document">
                    <i class="fas fa-plus"></i></a>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row">
          <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                  <h3 class="m-0 text-center text-success">Incoming/New Documents</h1>
                </div>
              <div class="card-body">

                <div class="card card-success card-outline">
                  <div class="card-header">
                    <h5 class="card-title m-0">Remarks/Subject</h5>
                  </div>
                  <div class="card-body">
                    <h6 class="card-title">Special title treatment</h6>

                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>

                    <button class="btn btn-xs btn-success">Receive</button>
                    <button class="btn btn-xs btn-primary">Forward</button>
                  </div>
                </div>

              </div>
            </div>
        </div>
          <!-- /.col-md-6 -->
      <div class="col-lg-4">
        <div class="card">
          <div class="card-header">
            <h3 class="m-0 text-center text-primary">Received/Forwarded Documents</h1>
          </div>
          <div class="card-body">

            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="card-title m-0">Remarks/Subject</h5>
              </div>
              <div class="card-body">
                <h6 class="card-title">Special title treatment</h6>

                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
              </div>
            </div>

          </div>
        </div>
      </div>
          <!-- /.col-md-6 -->
          <!-- /.col-md-6 -->
      <div class="col-lg-4">
        <div class="card">
          <div class="card-header">
            <h3 class="m-0 text-center text-dark">Division or All Documents</h1>
          </div>
          <div class="card-body">

            <div class="card card-dark card-outline">
              <div class="card-header">
                <h5 class="card-title m-0">Remarks/Subject</h5>
              </div>
              <div class="card-body">
                <h6 class="card-title">Special title treatment</h6>

                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
              </div>
            </div>

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
              <h4 class="modal-title">Add Document</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method = "post">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-4">
                  <div class="form-group">
                  <input type="hidden" class="form-control" name="" value="<?php echo $userdetails['id'] ?>" required="required">
                    <label>Automated Tracking Number:</label>
                    <input type="text" class="form-control" name="tracking_no" value="<?php echo $tracking_no ?>" required="required" readonly>
                  </div>
                </div>

              </div>
              <div class="row">

                <div class="col-sm-12">
                  <div class="form-group">
                    <span style="color:red">* </span><label>Subject:</label>
                    <textarea name="subject" class="form-control" rows="3" placeholder="Enter subject ..." required></textarea>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-4">
                  <div class="form-group">
                    <label>Type:</label>
                    <select class="form-control" name="type" id="access">
                        <option value="">-- Select Type --</option>
                        <option value="">Confidential</option>
                        <option value="">Type 2</option>
                        </select>
                  </div>
                </div>

                <div class="col-sm-8">
                  <div class="form-group">
                    <span style="color:red">* </span><label>Forward to:</label>
                    <select class="form-control" name="forward_to" id="access" required>
                        <option value="">-- Select Divisions --</option>
                        <?php $query2 = "SELECT * FROM setting_divisions";
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

                    <div class="col-sm-12">
                      <label>Remarks:</label>
                        <div class="form-group">
                          <textarea name="remarks" class="form-control" rows="3" placeholder="Enter remarks ..." required></textarea>
                        </div>
                    </div>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" name="add_division" id="" class="btn btn-primary">Save data</button>
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
