<?php
  include("includes/checkuserrole.php");

  include("../include/connection.php");

  if(isset($_GET["table"]) && isset($_GET["id"])){
    $db = "test";
    $table = $_GET["table"];
    $id = $_GET["id"];

    try{
      $sql = "SELECT * FROM ".$table. " WHERE id=".$id;
      $stmt = $pdo->prepare($sql);
      $stmt->execute();
      $allColumns = $stmt->fetchAll();
    }catch(Exception $e){
      header("location: dashboard.php");
    }

    if(count($allColumns) == 0){
      header("location: dashboard.php");
    }

    $sql = "SHOW INDEXES FROM ".$table;
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $allData = $stmt->fetchAll();

    //get only foeign keys in given table
    $onlyFk = [];
    for($i = 0; $i < count($allData); $i++){
      if($allData[$i]["Key_name"] != "PRIMARY" && $allData[$i]["Non_unique"] == "1"){
        array_push($onlyFk, $allData[$i]["Key_name"]); 
      }
    }

    $hasFk = false;
    $allFkData = [];
    
    if(count($onlyFk) > 0){
      $hasFk = true;
      foreach($onlyFk as $o){
        $sql = "SELECT REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE REFERENCED_TABLE_SCHEMA = :db AND TABLE_NAME = :table AND COLUMN_NAME = :col ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":db", $db);
        $stmt->bindParam(":table", $table);
        $stmt->bindParam(":col", $o);
        $stmt->execute();
        $refTable = $stmt->fetchAll();

        $refTableTable = $refTable[0]["REFERENCED_TABLE_NAME"];
        $refTableColumn = $refTable[0]["REFERENCED_COLUMN_NAME"];

        $storeObj = [
          "table" => $refTableTable,
          "column" => $refTableColumn
        ];

        array_push($allFkData, $storeObj);
        
      }
    }

    $allNamesAndIdsFromFks = [];
    
    //select and store all data for foreign keys
    for($i = 0; $i < count($allFkData); $i++){
      $tableName = $allFkData[$i]["table"];
      $columnName = $allFkData[$i]["column"];

      $sql = "SELECT * FROM ".$tableName;
      $stmt = $pdo->prepare($sql);
      $stmt->execute();
      $dataFromForeignKey = $stmt->fetchAll();

      $oneNameAndFk = [];
      for($y = 0; $y < count($dataFromForeignKey); $y++){
        $storeIdAndName = [
          "id" => $dataFromForeignKey[$y][0],
          "name" => $dataFromForeignKey[$y][1]
        ];

        array_push($oneNameAndFk, $storeIdAndName);
      }

      array_push($allNamesAndIdsFromFks, $oneNameAndFk); 

    }

    //inserting only elements that are string in array
    $wordKeys = [];
    $keyonly = array_keys($allColumns[0]);
    foreach($keyonly as $ko){
      if(is_string($ko)){
        array_push($wordKeys, $ko); 
      }
    }

  }
  else{
    header("location: dashboard.php");
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

          <div class="col-12 m-3">
            <h1><?= strtoupper($table) ?></h1>
          </div>

          <form method="post" action="rowprocessing.php" class="w-100">
            
            <?php for($i = 0; $i < count($allColumns[0]) / 2; $i++): ?>
              <?php $skipText = false; ?>
              <?php if($hasFk): ?>
                <?php for($y = 0; $y < count($onlyFk); $y++): ?>
                  <?php if($wordKeys[$i] == $onlyFk[$y]): ?>
                    <?php $skipText = true; ?>
                    <label><?= $wordKeys[$i] ?></label>
                    <select name="<?= $wordKeys[$i] ?>" class="form-control">

                      <?php for($z = 0; $z < count($allNamesAndIdsFromFks[$y]); $z++): ?>
                        <?php if($allNamesAndIdsFromFks[$y][$z]["id"] == $allColumns[0][$wordKeys[$i]]): ?>
                            <?php $selected = "selected" ?>
                        <?php else: ?>
                            <?php $selected = "" ?>
                        <?php endif ?>

                        <option <?=$selected?> value="<?= $allNamesAndIdsFromFks[$y][$z]["id"] ?>"> <?= $allNamesAndIdsFromFks[$y][$z]["name"] ?> </option>
                      <?php endfor ?>
                    

                    </select>
                  <?php endif ?>
                <?php endfor ?>
              <?php endif ?>
              
              <?php if(!$skipText): ?>
                <?php if($wordKeys[$i] != "Id" && $wordKeys[$i] != "id"): ?>
                  <label><?= $wordKeys[$i] ?></label>
                  <?php if($wordKeys[$i] == "text"): ?>
                    <textarea id="mytextarea" class="form-control" name="<?= $wordKeys[$i] ?>"><?= $allColumns[0][$wordKeys[$i]]?></textarea>
                  <?php else: ?>
                    <input type="text" class="form-control" name="<?= $wordKeys[$i] ?>" value="<?= $allColumns[0][$wordKeys[$i]] ?>">
                  <?php endif ?>
                  
                  
                <?php endif ?>
              <?php endif ?>

            <?php endfor ?>
            </div>

            <input type="hidden" name="edittable" value="<?= $table ?>"/>
            <input type="hidden" name="editid" value="<?= $id ?>"/>

            <div class="col-12 m-3">
              <button class="btn btn-success" type="submit">Change</button>
            </div>

          </form>
            
        </div>

        <?php include("includes/footeradm.php"); ?>

      </div>
      <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Bootstrap core JavaScript-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script>
    tinymce.init({
      selector: 'textarea',  // change this value according to your HTML
      content_css: ['//fonts.googleapis.com/css?family=Montserrat|Open+Sans|Raleway:400,900&display=swap'],
      font_formats: 'Arial Black=arial black,avant garde;Raleway=raleway,Montserrat=montserrat, cursive;Times New Roman=times new roman,times;',
      plugins: [
        'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
        'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
        'table emoticons template paste help codesample'
      ],
      toolbar: "codesample"
    });

  </script>
</body>

</html>