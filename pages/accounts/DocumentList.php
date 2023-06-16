<?php
require_once('../db/connect_db.php');
// $DivisionDocuments=$store->getDivisionDocuments();

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
   <div class="content">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
            <div class="card-header">
              <h3>List of documents of your division</h3>
            </div>
              <div class="card-body">
              <table id="datatable" class="table table-bordered table-striped">
                  <thead class="text-nowrap">
                  <tr>
                      <th>Action</th>
                      <th>Tracking No.</th>
                      <th>Subject</th>
                      <th>Type of Document</th>
                      <th>Status</th>
                      <th>Date Created</th>
                  </tr>
                  </thead>
                  <tbody>
                        <?php
                          $division_id = $userdetails['division_id'];
                          $query = $con->query("SELECT t1.*, t3.division FROM documents t1 LEFT JOIN document_log t2 ON t1.id = t2.document_id LEFT JOIN setting_divisions t3 ON t1.route_to_division_id = t3.id WHERE division_id = $division_id GROUP BY t1.id ORDER BY t2.date_acted DESC");
                          while($document = $query->fetch_assoc()){
                        ?>
                    <tr>
                    <td><a type="button" class="btn btn-info btn-sm" href="DocumentDetails?id=<?php echo $document['id']?>"><i class="fas fa-eye"></i></a>
                    </td>

                    <td><?php echo $document['tracking_no'];?></td>
                    <td><?php echo $document['subject'];?></td>
                    <td><?php echo $document['type'];?></td>
                    <td><?php

                    if($document['status'] == 1){ echo "<span class='badge badge-primary'>New document / No history of route</span>";}

                    elseif($document['status'] == 2 && $document['route_to_division_id'] != $division_id){ echo "<span class='badge badge-primary'>Currently at ".$document['division']."</span>";}

                    elseif($document['status'] == 2 && $document['route_to_division_id'] == $division_id){ echo "<span class='badge badge-primary'>Currently at your division</span>";}

                    elseif($document['status'] == 3 && $document['route_to_division_id'] != $division_id){ echo "<span class='badge badge-primary'>Currently at ".$document['division']."</span>";}

                    elseif($document['status'] == 3 && $document['route_to_division_id'] == $division_id){ echo "<span class='badge badge-primary'>Currently at your division</span>";}

                    elseif($document['status'] == 5 && $document['route_to_division_id'] != $division_id){ echo "<span class='badge badge-primary'>Currently at ".$document['division']."</span>";}

                    elseif($document['status'] == 5 && $document['route_to_division_id'] == $division_id){ echo "<span class='badge badge-primary'>Currently at your division</span>";}

                    elseif($document['status'] == 4 && $document['route_to_division_id'] != $division_id){ echo "<span class='badge badge-success'>End Cycle at ".$document['division']."</span>";}

                    elseif($document['status'] == 4 && $document['route_to_division_id'] == $division_id){ echo "<span class='badge badge-success'>End Cycle at your division</span>";}

                   ?>
                    </td>
                    <td><?php

                          if(isset($document['date_added']) && $document['date_added'] !="")
                          {
                              $date_exam = date("F j, Y", strtotime($document['date_added']));
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

</div>
<!-- ./wrapper -->

  <?php include('../Footer/Footer.php'); ?>

  <?php include('../Footer/Script.php'); ?>
