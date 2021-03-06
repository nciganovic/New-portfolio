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

  if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    if(isset($_POST["email"]) && isset($_POST["password"]) && !empty($_POST["email"]) && !empty($_POST["password"])){

      $email = test_input($_POST["email"]);
      $password = test_input($_POST["password"]);
      $isEmailValid = preg_match('/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $email);
      
      if($isEmailValid){

        if(strlen($password) > 0 && strlen($password) < 25){

          $sql = "SELECT id, username, password, role FROM users WHERE email = :email AND isverified=1";
          
          if($stmt = $pdo->prepare($sql)){
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            if($stmt->rowCount() == 1){
              $users = $stmt->fetchAll();
              if(password_verify($password, $users[0]["password"])){
                
                session_start();

                // Store data in session variables
                $_SESSION["userid"] = $users[0]["id"];
                $_SESSION["role"] = $users[0]["role"];
                $_SESSION["username"] = $users[0]["username"];                            
                      
                // Redirect depends on role
                if($users[0]["role"] == 1){
                  header("location: admin/dashboard.php");
                }
                else{
                  header("location: index.php");
                }
                
              }
              else{
                $_SESSION["message"] = "Password is invalid.";
              }
            }
            else{
              $_SESSION["message"] = "Email doesn't exist.";
            }
          }
        }
        else{
          $_SESSION["message"] = "Password is maximum 25 characters.";
        }

      }
      else{
        $_SESSION["message"] = "Email is in wrong format.";
      }
    }
    else{
      $_SESSION["message"] = "Email or password are not inserted.";
    }
  }

  if(isset($_SESSION["message"]) && !empty($_SESSION["message"])){
    $currentMessage = $_SESSION["message"];
  }
  else{
    $currentMessage = null;
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
  <meta name="description" content="Hello, my name is Nikola Ciganovic, i am software developer and i write every week about programming, new technology and books.">
  <meta name="keywords" content="blog, programming, web development, books, tutorial">
  <meta name="author" content="Nikola Ciganovic">

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
                    <h1 class="h4 text-gray-900 mb-4">Login</h1>
                  </div>
                  <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST"  class="user">
                    <div class="form-group">
                      <input type="email" name="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                    </div>
                    <div class="form-group">
                      <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="customCheck">
                        <label class="custom-control-label" for="customCheck">Remember Me</label>
                      </div>
                    </div>
                    <button type="submit" href="index.html" class="btn btn-primary btn-user btn-block">
                      Login
                    </button>
                  </form>
                  <div class="errors mt-3"></div>
                  <div class="col-12">
                    <p class="server-erros text-center text-danger text-center"> <?= $currentMessage ?></p>
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
  <script src="js/checklogin.js"></script>

</body>

</html>
