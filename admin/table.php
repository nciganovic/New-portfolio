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

<?php include("includes/head.php"); ?>

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
              <h6 class="m-0 font-weight-bold text-primary"><?= strtoupper($table) ?></h6>
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
                      <td><a href='editrow.php?id=<?=$tableInfo[$i][0]?>&table=<?=$table?>' class="btn btn-warning">Edit</a></td>
                      <td><a href='deleterow.php?row=<?=$i?>&table=<?=$table?>' class="btn btn-danger">Delete</a></td>
                    </tr>
                    <?php endfor ?>
                  </tbody>
                </table>
              </div>
              <div class="col-12">
                  <a href='createrow.php?table=<?=$table?>' class="btn btn-success">Create</a>
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