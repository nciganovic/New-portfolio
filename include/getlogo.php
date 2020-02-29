<?php 
    $sql = "SELECT * FROM socialmedia";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $socMedia = $stmt->fetchAll();
?>