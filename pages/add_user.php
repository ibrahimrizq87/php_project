<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../includes/database.php';
require_once '../includes/user.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
    empty($_POST['name']) &&
    empty($_POST['email']) &&
    empty($_POST['password']) &&
    empty($_POST['confirmPassword']) &&
    empty($_POST['room_no']) &&
    empty($_POST['ext']) &&
    empty($_FILES['profile_pic']['name'])) {
    echo '<p>No Data Submitted</p>';
}




if($_SERVER['REQUEST_METHOD'] == 'POST') {
    try{
         $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);
    $add = $user->add_user();

    if($add) {
echo'user added successfully';  }
    }catch(Exception $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }

}
?>



<html>
<head>
    <title>Add User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel ='stylesheet' href = '../style/add_user.css'>
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

 

        <!-- <label for="name">Name:</label>
        <input type="text" id="name" name="name" required ><br><br> -->

        <!-- <label for="email">Email:</label>
        <input type="email"  id="email" name="email" required><br><br> -->

        <!-- <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>  -->


        <!-- <label for="confirmPassword">Confirm Password:</label>
        <input type="password" id="confirmPassword" name="confirmPassword" required><br><br> -->

        <!-- <label for="room_no">Room No.:</label>
        <input type="text" id="room_no" name="room_no"><br><br> -->

        <!-- <label for="ext">Ext.:</label>
        <input type="text" id="ext" name="ext"><br><br> -->

        <!-- <label for="profile_pic">Profile Picture:</label>
        <input type="file" id="profilePicture" name="profile_pic" accept="image/*" ><br><br> -->

        <!-- <label for="is_admin">User:</label>
        <input type="radio"  name="is_admin" value="TRUE">
        <label for="TRUE">Admin</label>
        <input type="radio"  name="is_admin" value="FALSE">
        <label for="FALSE">Customer</label><br> -->


        <!-- <input type="submit" value="Save"> 

        <input type="reset" value="Reset"> --> 


        <div class="container shadow p-5 mt-5 bg-light rounded mb-5">
        <h2>Add User</h2>
    <form method='POST' enctype='multipart/form-data' class="mt-5">



  <div class="mb-3">
  <label for="name" class="form-label">Name:</label>
  <input type="text" id="name" name="name" class="form-control" required > <br>
  </div>




  <div class="mb-3">
  <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">   <br>
  </div>



  <div class="mb-3 form-check">
  <label for="exampleInputPassword1" class="form-label">Password</label>
  <input type="password" name="password" class="form-control" id="exampleInputPassword1"> <br>
  </div>



  <div class="mb-3 form-check">
  <label for="confirmPassword" class="form-label">Confirm Password</label>
  <input type="password" name="confirmPassword" class="form-control" id="confirmPassword"> <br>
  </div>



  <div class="mb-3 form-check">
  <label for="room_no" class="form-label">Room No.:</label>
  <input type="number" id="room_no" name="room_no" class="form-control"> <br>
  </div>



  <div class="mb-3 form-check">
  <label for="ext" class="form-label">Ext.:</label>
  <input type="text" id="ext" name="ext" class="form-control"> <br>
  </div>




  <div class="mb-3 form-check">
  <label for="profile_pic" class="form-label">Profile Picture:</label>
  <input type="file" id="profilePicture" name="profile_pic" accept="image/*" class="form-control"> <br>
  </div>


  


  <div class="mb-3 form-check">

  <label class="form-label">User:</label>
  
  <div class="input-group-text">

  <div class="form-check me-5">
    <label for="admin" class="form-label" >Admin</label>
    </div>
    <div class=" form-check">

    <input class="form-check-input  " type="radio" id  = 'admin' name="is_admin" value="TRUE" aria-label="Radio button for following text input">
    </div>

  </div>

  <div class="input-group-text mt-3">

  <div class="form-check me-5">
<label for="user" class="form-label" >Customer</label>
</div>
<div class=" form-check">
<input class="form-check-input mt-0" type="radio" id  = 'user' name="is_admin" value="FALSE" aria-label="Radio button for following text input">
</div>
</div>

  </div> <br> <br>


  <button type="submit" class="btn btn-primary">Add</button>
</form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>