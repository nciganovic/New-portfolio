<?php
    session_start();
    unset($_SESSION["role"]);  
    unset($_SESSION["username"]);
    unset($_SESSION["userid"]);
    header("Location: "."https://".$_SERVER["HTTP_HOST"]."/newportfolio/index.php");
?>