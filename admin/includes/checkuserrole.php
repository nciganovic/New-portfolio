<?php
    session_start();
    if($_SESSION["role"] != "1"){
        $url = "http://".$_SERVER["HTTP_HOST"]."/newportfolio/login.php";
        header("location: ".$url);
    }
?>