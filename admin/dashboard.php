<?php
  include("../include/connection.php");
  include("includes/checkuserrole.php");

  $sql = "SELECT * FROM admintables";

  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $alltables = $stmt->fetchAll();

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
            <?php foreach($alltables as $at): ?>
            <!--Single card -->
            <div class="col-12 mb-4">
              <a href="table.php?table=<?=$at["href"]?>">
                <div class="card border-left-primary shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $at["name"]?></div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <?php endforeach ?>
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
