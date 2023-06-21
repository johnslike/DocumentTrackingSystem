
<?php
require_once('../db/connect_db.php');

$Documents=$store->getAllDocument();
// $store->add_requestor($_POST);

include('adminaccess.php');
include('../Header/Header.php');

?>

<title>List of all documents</title>
<body class="hold-transition layout-top-nav">
<div class="wrapper">


<?php include('../Header/navbaradmin.php'); ?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"> List of all documents</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             <li class="breadcrumb-item"><a href="home">Home</a></li>
              <li class="breadcrumb-item active">Documents List</li>
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
            <!-- <div class="card-header">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_coe">
              <i class="fas fa-user-plus"></i>
              </button>
            </div> -->
              <div class="card-body">
              <table id="datatable" class="table table-bordered table-striped">
                  <thead class="text-nowrap">
                  <tr>
                      <th>Action</th>
                      <th>Tracking No.</th>
                      <th>Subject</th>
                      <th>Type of Document</th>
                      <th>Division</th>
                      <th>Status</th>
                      <th>Date Created</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php if (is_array($Documents) || is_object($Documents))
                    foreach($Documents as $document){?>
                    <tr>
                    <td><a type="button" class="btn btn-info btn-sm" href="DocumentDetails?id=<?php echo $document['id']?>"><i class="fas fa-eye"></i></a>
                    </td>

                    <td><?php echo $document['tracking_no'];?></td>
                    <td><?php echo $document['subject'];?></td>
                    <td><?php echo $document['type'];?></td>
                    <td><?php echo $document['division_owner'];?></td>
                    <td><?php

                    if($document['status'] == 1){ echo "<span class='badge badge-primary'>New document / No history of route</span>";}

                    elseif($document['status'] == 2){ echo "<span class='badge badge-primary'>Currently at ".$document['division']."</span>";}

                    elseif($document['status'] == 3){ echo "<span class='badge badge-primary'>Currently at ".$document['division']."</span>";}

                    elseif($document['status'] == 5){ echo "<span class='badge badge-primary'>Currently at ".$document['division']."</span>";}

                    elseif($document['status'] == 4){ echo "<span class='badge badge-success'>End Cycle at ".$document['division']."</span>";}

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

