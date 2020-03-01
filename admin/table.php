<?php
  session_start();
  if($_SESSION["role"] != "1"){
    header("location: login.php");
  }

  include("../include/connection.php");

  if(isset($_GET["table"])){

    $table = $_GET["table"];
    $db = "portfolio";
  
    $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = :db AND TABLE_NAME = :table";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":db", $db);
    $stmt->bindParam(":table", $table);
    $stmt->execute();
    $allColumns = $stmt->fetchAll();
    
    if(count($allColumns) == 0){
        header("location: dashboard.php");
    }

    $sql2 = "SELECT * FROM ".$table;
    $stmt = $pdo->prepare($sql2);
    #$stmt->bindParam(":t", $table);
    $stmt->execute();
    $tableInfo = $stmt->fetchAll();

    
/*
    for($i = 0; $i < count($tableInfo); $i++){
        for($y = 0; $y < count($tableInfo[$i]) / 2; $y++){
            var_dump($tableInfo[$i][$y]);
        }
        echo("--------------------------");
    }
*/
  }

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Admin Dashboard</title>

  <!-- Custom fonts for this template-->
  <script src="https://kit.fontawesome.com/d27711fee5.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <?php include("includes/sidebar.php") ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid mt-3">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
          </div>

          <div class="row">

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <?php foreach($allColumns as $a): ?>
                        <th><?=$a[0]?></th>
                      <?php endforeach ?>
                      <td>Edit</td>
                      <td>Delete</td>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <?php foreach($allColumns as $a): ?>
                        <th><?=$a[0]?></th>
                      <?php endforeach ?>
                      <td>Edit</td>
                      <td>Delete</td>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php for($i = 0; $i < count($tableInfo); $i++): ?>
                    <tr>
                      <?php for($y = 0; $y < count($tableInfo[$i]) / 2; $y++): ?>
                      <td><?= $tableInfo[$i][$y] ?></td>
                      <?php endfor ?>
                      <td><button class="btn btn-warning">Edit</button></td>
                      <td><button class="btn btn-danger">Delete</button></td>
                    </tr>
                    <?php endfor ?>
                  </tbody>
              </table>
            </div>
            <div class="col-12">
                <button class="btn btn-success">Create</button>
            </div>
        </div>
    </div>
            
</div>

      <?php include("includes/footeradm.php"); ?>

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Bootstrap core JavaScript-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

</body>

</html>