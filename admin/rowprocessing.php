<?php

include("../include/connection.php");

if(isset($_POST["edittable"]) && isset($_POST["editid"])){
    $table = $_POST["edittable"];
    $id = $_POST["editid"];

    $sql = "SELECT * FROM ".$table. " WHERE id=".$id;
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $allColumns = $stmt->fetchAll();

    //inserting only elements that are string in array
    $wordKeys = [];
    $keyonly = array_keys($allColumns[0]);
    
    $strId = false;

    foreach($keyonly as $ko){
      if(is_string($ko)){
        if($ko != "id" && $ko != "Id"){
            array_push($wordKeys, $ko);
        }
        else{
            $strId = $ko;
        }
      }
    }
    
    // Creating right string for update
    $sql = "UPDATE ".$table." SET ";
    
    for($i = 0; $i < count($wordKeys); $i++){
        if($i < count($wordKeys) - 1){
            $sql .= $wordKeys[$i]." = '".$_POST[$wordKeys[$i]]."' , ";
        }
        else{
            $sql .= $wordKeys[$i]." = '".$_POST[$wordKeys[$i]]."'";
        }
    }

    $sql .= " WHERE ".$table.".id =".$id;

    var_dump($sql);
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    header("location: table.php?table=".$table);
}

if(isset($_POST["createtable"])){
    $table = $_POST["createtable"];

    $sql = "SELECT * FROM ".$table;
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $allColumns = $stmt->fetchAll();
    
    //inserting only elements that are string in array
    $wordKeys = [];
    $keyonly = array_keys($allColumns[0]);
    
    $strId = false;

    foreach($keyonly as $ko){
      if(is_string($ko)){
        if($ko != "id" && $ko != "Id"){
            array_push($wordKeys, $ko);
        }
        else{
            $strId = $ko;
        }
      }
    }

    // Creating right string for insertion
    $sql = "INSERT INTO ".$table." (";
    if($strId){
        $sql.=$strId.", ";
    }

    for($i = 0; $i < count($wordKeys); $i++){
        if($i < count($wordKeys) - 1){
            $sql .= $wordKeys[$i].", ";
        }
        else{
            $sql .= $wordKeys[$i];
        }
    }

    $sql .= ") VALUES (";
    if($strId){
        $sql.="'NULL', ";
    }

    for($i = 0; $i < count($wordKeys); $i++){
        if($i < count($wordKeys) - 1){
            $sql.="'".$_POST[$wordKeys[$i]]."', ";
        }
        else{
            $sql.="'".$_POST[$wordKeys[$i]]."' ";
        }
    }
    $sql .= " );";
    
    var_dump($sql);
    var_dump($pdo);
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    header("location: table.php?table=".$table);
}
?>