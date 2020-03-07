<?php
  session_start();
  if(isset($_SESSION["role"])){
    if($_SESSION["role"] == "0"){
      header("location: index.php");
    }
    elseif($_SESSION["role"] == "1"){
      header("location: admin/dashboard.php");
    }
  }

  include("include/connection.php");
  
  unset($_SESSION["message"]);
  unset($_SESSION["txtcolor"]);

  if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["username"]) && !empty($_POST["username"])){
      if(isset($_POST["email"]) && isset($_POST["password"]) && !empty($_POST["email"]) && !empty($_POST["password"]) && !empty($_POST["passwordR"]) && isset($_POST["passwordR"])){

        $username = test_input($_POST["username"]);
        $email = test_input($_POST["email"]);
        $password = test_input($_POST["password"]);
        $passwordR = test_input($_POST["passwordR"]);

        $isUsernameValid = preg_match('/^(?=.{5,15}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/', $username);
        $isEmailValid = preg_match('/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $email);

        if($isUsernameValid){
          if($isEmailValid){

            if(strlen($password) > 4 && strlen($password) <= 25){
              if($password == $passwordR){

                $sql = "SELECT username, email FROM users WHERE username=:username OR email=:e";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(":username", $username);
                $stmt->bindParam(":e", $email);
                $stmt->execute();

                if($stmt->rowCount() == 0){
                  $rand = bin2hex(random_bytes(32));
                  $pswHash = password_hash($password, PASSWORD_DEFAULT);

                  $link = "http://".$_SERVER["HTTP_HOST"]."/newportfolio/auth.php";
                  
                  $sql = "INSERT INTO users (username, password, isverified, role, email, randnum) VALUES(:username, :password, 0, 0, :email, :randnum)";
                  $stmt = $pdo->prepare($sql);
                  $stmt->bindParam(":username", $username);
                  $stmt->bindParam(":password", $pswHash);
                  $stmt->bindParam(":email", $email);
                  $stmt->bindParam(":randnum", $rand);
                  $stmt->execute();

                  $sql = "SELECT id FROM users WHERE username = :username";
                  $stmt = $pdo->prepare($sql);
                  $stmt->bindParam(":username", $username);
                  $stmt->execute();
                  $getId = $stmt->fetchAll();

                  $id = $getId[0]["id"];

                  $fullUrl = $link."?id=".$id."&key=".$rand;

                  $message = "Here is the link for confirmation: ".$fullUrl;

                  mail($email, "Confirm your password.", $message);

                  $_SESSION["message"] = "Account succesfully created! We sent you a confirmation link to your email. Click on it and you verification is complete.";
                  $_SESSION["txtcolor"] = "text-success";
                }
                else{
                  $_SESSION["message"] = "Username or email are already in use.";
                  $_SESSION["txtcolor"] = "text-danger";
                }
                
                
              }
              else{
                $_SESSION["message"] = "Passwords are not identical.";
                $_SESSION["txtcolor"] = "text-danger";
              } 
            }
            else{
              $_SESSION["message"] = "Password is invalid. Must be between 5 and 25 characters.";
              $_SESSION["txtcolor"] = "text-danger";
            }

          }
          else{
            $_SESSION["message"] = "Email is in wrong format.";
            $_SESSION["txtcolor"] = "text-danger";
          }
        }
        else{
          $_SESSION["message"] = "Username is in wrong format. Valid formats are: user_15 , user.15 , user15 .";
          $_SESSION["txtcolor"] = "text-danger";
        }
      }
      else{
        $_SESSION["message"] = "Email or passwords are not inserted.";
        $_SESSION["txtcolor"] = "text-danger";
      }
    }
    else{
      $_SESSION["message"] = "Username is not inserted.";
      $_SESSION["txtcolor"] = "text-danger";
    }
  }

  if(isset($_SESSION["message"]) && !empty($_SESSION["message"])){
    $currentMessage = $_SESSION["message"];
  }
  else{
    $currentMessage = null;
  }

  if(isset($_SESSION["txtcolor"]) && !empty($_SESSION["txtcolor"])){
    $txtcolor = $_SESSION["txtcolor"];
  }
  else{
    $txtcolor = null;
  }

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    return $data;
  }

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SB Admin 2 - Login</title>

  <!-- Custom fonts for this template-->
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <?php include("include/navbar.php"); ?>

  <div class="container mt-5">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row d-flex">
              <div class="col-lg-6 m-auto">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Register</h1>
                  </div>
                  <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST"  class="user">
                    <div class="form-group">
                      <input type="username" name="username" class="form-control form-control-user" id="exampleInputName" aria-describedby="emailHelp" placeholder="Enter Username...">
                    </div>
                    <div class="form-group">
                      <input type="email" name="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                    </div>
                    <div class="form-group">
                      <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
                    </div>
                    <div class="form-group">
                      <input type="password" name="passwordR" class="form-control form-control-user" id="exampleInputPasswordR" placeholder="Repeat password">
                    </div>
                    <button type="submit" href="index.html" class="btn btn-primary btn-user btn-block">
                      Register
                    </button>
                  </form>
                  <div class="errors mt-3"></div>
                  <div class="col-12">
                    <p class="server-erros text-center <?=$txtcolor?> text-center"> <?=$currentMessage?> </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="js/checkregister.js"></script>

</body>

</html>