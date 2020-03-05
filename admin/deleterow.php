<?php 
    session_start();
    if($_SESSION["role"] != "1"){
      header("location: login.php");
    }

    include("../include/connection.php");

    if(isset($_GET["table"])){
        //Delete this row
        
        $table = $_GET["table"];
        $id = $_GET["id"];

        $sql = "DELETE FROM ".$table." WHERE id=".$id;
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        include("includes/gettable.php");

        echo json_encode($tableInfo);
    }

?>
