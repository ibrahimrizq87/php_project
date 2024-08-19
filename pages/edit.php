<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../includes/database.php';
require_once '../includes/user.php';
if (!isset($_SESSION["user_name"])){
  header("Location: login.php");
  exit();
} else {
  include_once('../includes/header.php');
}


$id=$_GET['id'];

$has_error=false;   
$edit_image=false;


$userData = [
    'name' => '',
    'email' => '',
    'password' => '',
    'confirmPassword' => '',
    'room_no' => '',
    'ext' => '',
    'profile_pic' => '',
    'is_admin' => ''
];

if(!($_SERVER['REQUEST_METHOD'] == 'POST')) {
    
        try{  
    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);
    $userData = $user->get_user();



}catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    }}else{

    }
    


?>



  

        <div class="container shadow p-5 mt-5 bg-light rounded mb-5">
        <h2>Edit User</h2>
    <form method='POST' enctype='multipart/form-data' class="mt-5">

<?php 


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset(($_POST['name']))) {
  if (empty($_POST['name'])){
    echo '
    <div class="container mt-5">
    <div class="alert alert-danger" role="alert">
        <p> name is required to add user </p>
    </div>
          </div>
  
    ';
    $has_error=true;}
}

?>

  <div class="mb-3">
  <label for="name" class="form-label">Name:</label>
  <input type="text" id="name" name="name" value="<?php echo $userData['name'] ; ?>" class="form-control"  > <br>
  </div>



  <?php 


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['email'])) {
  if (empty($_POST['email'])){
  echo '
  <div class="container mt-5">
  <div class="alert alert-danger" role="alert">
      <p> email is required to add user </p>
  </div>
        </div>

  ';
  $has_error=true;
}}

?>
  <div class="mb-3">
  <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" name="email"  value="<?php echo $userData['email'] ; ?>" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">   <br>
  </div>

  <?php 


if ($_SERVER['REQUEST_METHOD'] == "POST"&& isset($_POST['password'])) {
  if ( empty($_POST['password'])){
  echo '
  <div class="container mt-5">
  <div class="alert alert-danger" role="alert">
      <p> password is required to add user </p>
  </div>
        </div>

  ';
  $has_error=true;
}else {

  $passwordRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';
  if (!preg_match($passwordRegex, $_POST["password"])) {
    echo '
    <div class="container mt-5">
    <div class="alert alert-danger" role="alert">
        <p> password must be at least 8 characters and contain at least one lowercase letter, one uppercase letter, one number, and one special character. </p>
    </div>
    </div>
  
    ';   
    $has_error=true;   
  }

}
}


?>
  <div class="mb-3 form-check">
  <label for="exampleInputPassword1" class="form-label">Password</label>
  <input type="password" name="password" class="form-control" id="exampleInputPassword1"> <br>
  </div>


  <?php 


if ($_SERVER['REQUEST_METHOD'] == "POST"&& isset($_POST['password'])) {
  if ( empty($_POST['confirmPassword'])){
  echo '
  <div class="container mt-5">
  <div class="alert alert-danger" role="alert">
      <p> confirmPassword is required to add user </p>
  </div>
        </div>

  ';
  $has_error=true;
}else if (empty($_POST['confirmPassword']) && ($_POST['confirmPassword'] != $_POST['password'])){
  echo '
  <div class="container mt-5">
  <div class="alert alert-danger" role="alert">
      <p> password dose not match
        </div>

  ';
  $has_error=true;
}

}
?>
  <div class="mb-3 form-check">
  <label for="confirmPassword" class="form-label">Confirm Password</label>
  <input type="password" name="confirmPassword" class="form-control" id="confirmPassword"> <br>
  </div>


<!-- 
  <div class="mb-3 form-check">
  <label for="confirmPassword" class="form-label">Confirm Password</label>
  <input type="password" name="confirmPassword" class="form-control" id="confirmPassword"> <br>
  </div> -->

  <?php 


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['room_no'])) {
  if (empty($_POST['room_no'])){
  echo '
  <div class="container mt-5">
  <div class="alert alert-danger" role="alert">
      <p> room_no is required to add user </p>
  </div>
        </div>

  ';
  $has_error=true;
}
}

?>

  <div class="mb-3 form-check">
  <label for="room_no" class="form-label">Room No.:</label>
  <input type="number" id="room_no" value="<?php echo $userData['room_no'] ; ?>" name="room_no" class="form-control"> <br>
  </div>



  <?php 


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['ext'])) {
if ( empty($_POST['ext'])){
  echo '
  <div class="container mt-5">
  <div class="alert alert-danger" role="alert">
      <p> ext is required to add user </p>
  </div>
        </div>

  ';
  $has_error=true;
}
}
?>
  
  <div class="mb-3 form-check">
  <label for="ext" class="form-label">Ext.:</label>
  <input type="number" id="ext" value="<?php echo $userData['ext'] ; ?>" name="ext" class="form-control"> <br>
  </div>


  <?php 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_NO_FILE) {

      
    $edit_image=false;


  } elseif ($_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {

    $edit_image=true;

  } else {
    echo '
    <div class="container mt-5">
    <div class="alert alert-danger" role="alert">
        <p> Error uploading file.</p>
    </div>
          </div>
  
    ';
      $has_error=true;
  }
}


?>

  <div class="mb-3 form-check">
  <label for="profile_pic" class="form-label">Profile Picture:</label>
  <input type="file" id="profilePicture" value="<?php echo $userData['profile_pic'] ; ?>" name="profile_pic" accept="image/*" class="form-control"> <br>
  </div>





  <div class="mb-3 form-check">



  <?php 


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['is_admin'])) {

  if( empty($_POST['is_admin'])){
    echo '
    <div class="container mt-5">
    <div class="alert alert-danger" role="alert">
        <p> have to choose user type</p>
    </div>
          </div>
  
    ';
    $has_error=true;
  
  }
  }


?>

  <label class="form-label">User:</label>
  
  <div class="input-group-text">

  <div class="form-check me-5">
    <label for="admin" class="form-label" >Admin</label>
    </div>
    <div class=" form-check">

    <?php 
    if ($userData['is_admin'] == 'TRUE'){
        echo '<input class="form-check-input  " type="radio" id  = "admin" name="is_admin" value="TRUE" aria-label="Radio button for following text input" checked>';
    }else{
        echo '<input class="form-check-input  " type="radio" id  = "admin" name="is_admin" value="TRUE" aria-label="Radio button for following text input" >';

    }
    ?>

    </div>

  </div>

  <div class="input-group-text mt-3">

  <div class="form-check me-5">
<label for="user" class="form-label" >Customer</label>
</div>
<div class=" form-check">
<?php
if ($userData['is_admin'] == 'FALSE'){
        echo '<input class="form-check-input mt-0" type="radio" id  = "user" name="is_admin" value="FALSE" aria-label="Radio button for following text input" checked> ';
    }else{
        echo '<input class="form-check-input mt-0" type="radio" id  = "user" name="is_admin" value="FALSE" aria-label="Radio button for following text input">';

    }
    ?>

</div>
</div>

  </div> <br> <br>

<?php 


if($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (!$has_error){



    if ($edit_image){


        if (file_exists($image)) {
            if (unlink($image)) {
                // echo "File deleted successfully.";
            } else {
                echo "Error: Unable to delete the file.";
            }
        } else {
            // echo "Error: File does not exist.";
        }


    try{  
        $database = new Database();
        $db = $database->getConnection();
    
        $user = new User($db);
        $err = $user->update_user_with_image();
    if ($err != 'done'){
        ?>
        <div class="container mt-5">
        <div class="alert alert-danger" role="alert">
            <h4 class="alert-heading">Error!</h4>
            <p><?php echo $err ;?></p>
        </div>
    </div>
        <?php
    }else{
        echo '<script type="text/javascript">
        window.location.href = "view_users.php";
    </script>';    }

    
    
    }catch (PDOException $e) {
        ?>
        <div class="container mt-5">
        <div class="alert alert-danger" role="alert">
            <h4 class="alert-heading">Error!</h4>
            <p><?php echo 'Connection failed: ' . $e->getMessage(); ?>></p>
        </div>
    </div>
        <?php
         
        }

    }else{
        try{  
            $database = new Database();
            $db = $database->getConnection();
        
            $user = new User($db);
            $err = $user->update_user();
        
            if($err != 'done') {
                ?>
                <div class="container mt-5">
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Error!</h4>
                    <p><?php echo $err ;?></p>
                </div>
            </div>
                <?php
            }else{
                echo '<script type="text/javascript">
                window.location.href = "view_users.php";
            </script>';

}
        
        }catch (PDOException $e) {
            ?>
            <div class="container mt-5">
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Error!</h4>
                <p><?php 'Connection failed: ' . $e->getMessage();?></p>
            </div>
        </div>
            <?php
             
            }
    }


}
}
?>
  <button type="submit" class="btn btn-primary">Update </button>
</form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>


<hr class = 'mt-5'>
<?php 
include_once('../includes/footer.php');
?>