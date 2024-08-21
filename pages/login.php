<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../includes/database.php';
require_once '../includes/user.php';


if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    $message ="";
    $error = false;
    if (empty($_POST['email']) || empty($_POST['password'])){
        $message ="Please make sure to Enter Email and password";
    }else{

        $user = new User($db);
        $user->email = $_POST['email'];
        $user->password = $_POST['password'];
    
        if($user->login()) {
            header("Location: ../index.php ");
            exit();
        } else {
            $error = true;
        }
    
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel ='stylesheet' href = '../style/login.css'>
</head>
<body>




<header class="shadow mb-5">
    <div class="px-3 py-2 text-bg-dark border-bottom ">
      <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
          <a href="/" class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none">
            <image src = '../images/logo.png'class="bi me-2" width="50" height="50" >
            <span class="ms-2 fw-bold h5">Cafeterai</span> 
                
          </a>

        


        </div>
      </div>
    </div>
  

    
  </header>


<?php 

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($error)){
        if ($error){
            ?>
            <div class="container mt-5">
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Error!</h4>
                <p>Email or password is incorrect, try again later!</p>
            </div>
        </div>
            <?php
        }else{
            ?>
            <div class="container mt-5">
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Error!</h4>
                <p><?php echo $message ;?></p>
            </div>
        </div>
            <?php
        }
    }
}

?></p>
 
 <div class="container shadow p-5 mt-5 bg-light rounded">
 <h2>Login</h2>
    <form method="POST" action="" class="mt-5">

  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" name="password" class="form-control" id="exampleInputPassword1">
  </div>
  <div class="mb-3 form-check">
   

  </div>
  <button type="submit" class="btn btn-primary">Login</button>
</form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>