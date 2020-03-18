<?php
    $path = $_SERVER['DOCUMENT_ROOT'];
    $path .= "/dbdata/db.php";
    include($path);

    var_dump($path);

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $psw);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } 
    catch(Exception $e) {
        echo $e->getMessage();
    } 
?>