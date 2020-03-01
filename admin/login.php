<?php
  session_start();
  if(isset($_SESSION["role"])){
    if($_SESSION["role"] == "1"){
      header("location: dashboard.php");
    }
  }
?>
<?php
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    var_dump($_POST["email"]);
    var_dump($_POST["password"]);
    
    if(isset($_POST["email"]) && isset($_POST["password"]) && !empty($_POST["email"]) && !empty($_POST["password"])){
      
      $email = test_input($_POST["email"]);
      $password = test_input($_POST["password"]);
      $isEmailValid = preg_match('/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $email);
      
      if($isEmailValid && strlen($password) > 0 && strlen($password) < 25){
        echo("email and password are in valid format, ");

        include("../include/connection.php");

        $sql = "SELECT id, username, password, role FROM users WHERE email = :email";
        
        if($stmt = $pdo->prepare($sql)){
          $stmt->bindParam(":email", $email);
          $stmt->execute();
          if($stmt->rowCount() == 1){
            $users = $stmt->fetchAll();
            if(password_verify($password, $users[0]["password"])){
              echo("Correct username and password");
              
              session_start();

              // Store data in session variables
              $_SESSION["role"] = $users[0]["role"];
              $_SESSION["username"] = $users[0]["username"];                            
                     
              
              // Redirect user to welcome page
              header("location: dashboard.php");
            }
            else{
              echo("Invalid password");
              die();
            }
          }
          else{
            echo("that email doesnt exist");
            die();
          }
        }

      }
      else{
        echo("email or password are not valid");
        die();
      }
    } 
    else{
      echo("Email or password are not set!");
      die();
    }
  }

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
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
  <link href="../css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

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
                    <h1 class="h4 text-gray-900 mb-4">Administration</h1>
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
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="../js/admin/checklogin.js"></script>

</body>

</html>
