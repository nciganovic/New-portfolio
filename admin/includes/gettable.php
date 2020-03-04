<?php
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
    $stmt->execute();
    $tableInfo = $stmt->fetchAll();
?>