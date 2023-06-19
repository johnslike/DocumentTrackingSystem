
<?php
require_once('../db/connect_db.php');

$information=$store->get_info();
$store->add_types($_POST);
$store->update_types($_POST);
$store->delete_types($_POST);
$types=$store->getTypes();


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

<title>List of Types of Examination</title>
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
            <h1 class="m-0"> List of Types of Examination</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Layout</a></li> -->
              <li class="breadcrumb-item active">Types</li>
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
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_type">
              <i class="fas fa-envelope-open-text"></i> Add Types
              </button>
            </div>
              <div class="card-body">
              <table id="datatable" class="table table-bordered table-striped">
                  <thead class="text-nowrap">
                  <tr>
                      <th style="width: 100px">Action</th>
                      <th>Types</th>
                      <th>Date Added</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php if (is_array($types) || is_object($types))
                  foreach($types as $type){?>
                  <tr>
                  <td><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#edit<?php echo $type['id']?>"><i class="fas fa-pencil-alt"></i></button>
                  <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete<?php echo $type['id']?>"><i class="fas fa-trash-alt"></i></button></td>
                  <td><?php echo $type['type'];?></td>
                  <td><?php 
                      if(isset($type['date_added']) && $type['date_added'] !="")
                      {
                          $date = date("F j, Y", strtotime($type['date_added']));
                      }
                      else {
                          $date = "";
                      }
                      echo $date ; ?></td>
                  </tr>


          <div class="modal fade" id="delete<?php echo $type['id']?>">
          <div class="modal-dialog modal-sm">

          <div class="modal-content bg-danger">

            <div class="modal-header">
              <h4 class="modal-title">Are you sure you want to delete this type?</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method = "post" action="">
            <input type="hidden" class="form-control" value="<?php echo $type['id'];?>" name="id" id="id">
            <div class="card-body">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Type:</label>
                        <input type="hidden" class="form-control" value="<?php echo $type['id'];?>" name="id">
                        <input type="text" class="form-control" value="<?php echo $type['type']?>" name="barangay" id="fullname" disabled="disabled">
                      </div>
                    </div>
                    </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
              <button name="delete" class="btn btn-outline-light">Delete Type</button>
            </div>
          </div>
          
          </form>
          
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <div class="modal fade" id="edit<?php echo $type['id']?>">
          <div class="modal-dialog modal-md">

          <div class="modal-content">

            <div class="modal-header">
              <h4 class="modal-title"><i class="fas fa-envelope-open-text"></i> Update Types</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method = "post" action="">
            <div class="card-body">
                    <div class="col-sm-12">
                      <!-- text input -->
                  <div class="form-group">
                      <span style="color:red">* </span><label>Types:</label>
                      <input type="hidden" class="form-control" value="<?php echo $type['id']?>" name="id">
                      <input type="text" class="form-control" value="<?php echo $type['type']?>" name="place">
                      </div>
                    </div>
            
                  </div>
            
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button name="update" class="btn btn-success"><i class="fas fa-check"></i> Update Type</button>
            </div>
            
          </div>
          
          </form>
          
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->


    
                      
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

      <div class="modal fade" id="add_type">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><i class="fas fa-envelope-open-text"></i> Add Type</h4>
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
                      <span style="color:red">* </span><label>Type:</label>
                        <input type="text" class="form-control" name="type" placeholder="Enter Place..." required="required">
                        <!-- <small class="error_fullname" style="color: red;"></small> -->
                      </div>
                    </div>
                  </div>
            </div>

            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" name="add_type" id="" class="btn btn-primary">Save Type</button>
            </div>
          </div>
          </form>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->