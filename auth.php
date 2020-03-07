<?php
    include("include/connection.php");

    if(isset($_GET["id"]) && isset($_GET["key"])){
        if(!empty($_GET["id"]) && !empty($_GET["key"])){
            
            $id = $_GET["id"]; 
            $key = $_GET["key"];

            $sql = "SELECT id FROM users WHERE id=:id AND randnum=:key"; 
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":key", $key);
            $stmt->execute();

            if($stmt->rowCount() == 1){
                $sql = "UPDATE users SET isverified=1 , randnum=0 WHERE id=:id"; 
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(":id", $id);
                $stmt->execute();
            }
            else{
                echo("No user with this parameters.");
                die();
            }

        }
        else{
            header("Location: index.php");
        }
    }
    else{
        header("Location: index.php");
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-157514571-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'UA-157514571-1');
    </script>

    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="description" content="I'm Nikola Ciganović, a Web Developer from Belgrade, Serbia. I'm currently a college student in ICT College of Vocational studies, studying Web Development. My favorite thing to do is to create stuff using my programming knowledge.">
    <meta name="keywords" content="Nikola Ciganović, Web developer, Programmer, portfolio">
    <meta name="author" content="Nikola Ciganovic">

    <link rel="icon" href="img/icon1.ico">

    <title>Nikola Ciganović | Web developer</title>

    <script src="https://kit.fontawesome.com/d27711fee5.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Montserrat|Open+Sans|Raleway:400,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/animate.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center">Account successfully verified!</h1>
            </div>
            <div class="col-12 d-flex">
                <a href="login.php" class="btn btn-success">Login</a>
            </div>
        </div>
    </div>
</body>
</html>
