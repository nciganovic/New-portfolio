<?php
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=portfolio;", "admincrud", "123456789nc");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } 
    catch(Exception $e) {
        echo $e->getMessage();
    } 
?>