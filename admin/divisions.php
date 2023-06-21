<?php
require_once('../db/connect_db.php');
$store->add_division($_POST);
$store->update_division($_POST);
$store->delete_division($_POST);
$divisions=$store->getDivisions();

include('adminaccess.php');
include('../Header/Header.php');

?>
<title>Divisions</title>
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
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>List of Divisions</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active"><a href="home.php">Home</a></li>
              <li class="breadcrumb-item active">Divisions</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    <!-- Main content -->
    <section class="content">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">


              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_division">
                    <i class="fas fa-plus"></i></button>
              </div>

              <!-- ./card-header -->
              <div class="card-body table-responsive">
                <table id="datatable" class="table table-bordered table-striped">
                  <thead class="text-nowrap">
                  <tr>
                      <th style="width: 100px">Action</th>
                      <th>Divisions</th>
                      <th>Date Added </th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php if (is_array($divisions) || is_object($divisions))
                  foreach($divisions as $division){?>
                  <tr>
                  <td><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#edit<?php echo $division['id']?>"><i class="fas fa-pencil-alt"></i></button>
                  <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete<?php echo $division['id']?>"><i class="fas fa-trash-alt"></i></button></td>
                  <td><?php echo $division['division'];?></td>
                  <td><?php

                        if(isset($division['date_added']) && $division['date_added'] !="")
                        {
                            $date = date("F j, Y", strtotime($division['date_added']));
                        }
                        else {
                            $date = "";
                        }
                        echo $date ; ?></td>
                  </tr>


          <div class="modal fade" id="delete<?php echo $division['id']?>">
          <div class="modal-dialog modal-md">

          <div class="modal-content">

            <div class="modal-header bg-danger">
              <h4 class="modal-title">Are you sure you want to delete this division?</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method = "post" action="">
            <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Position:</label>
                        <input type="hidden" class="form-control" value="<?php echo $division['id'];?>" name="id" id="id">
                        <input type="text" class="form-control" value="<?php echo $division['division'];?>" name="fullname" id="position" disabled="disabled">
                      </div>
                    </div>

                    </div>
                    </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button name="delete" class="btn btn-danger">Delete data</button>
            </div>
          </div>

          </form>

          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

          <div class="modal fade" id="edit<?php echo $division['id']?>">
          <div class="modal-dialog modal-lg">

          <div class="modal-content">

            <div class="modal-header">
              <h4 class="modal-title">Update Division</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method = "post" action="">
            <div class="card-body">
            <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                      <span style="color:red">* </span><label>Division:</label>
                        <input type="hidden" class="form-control check_fullname" id="id" name="id" value="<?php echo $division['id'] ?>">
                        <input type="text" class="form-control check_fullname" id="fullname" name="division" value="<?php echo $division['division'] ?>">
                        <small class="error_fullname" style="color: red;"></small>
                      </div>
                    </div>

                  </div>

            </div>

            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button name="update" class="btn btn-success"><i class="fas fa-check"></i> Update data</button>
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
  <!-- /.content-wrapper -->


  <div class="modal fade" id="add_division">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add Division</h4>
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
                      <span style="color:red">* </span><label>Division:</label>
                        <input type="text" class="form-control" name="division" placeholder="Enter Position..." required="required">
                        <!-- <small class="error_fullname" style="color: red;"></small> -->
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

   <!-- Main Footer -->
   <?php include('../Footer/Footer.php'); ?>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->

    <?php include('../Footer/Script.php'); ?>

