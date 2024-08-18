
<?php 
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);


 if (!isset($_SESSION["user_name"])){
    header("Location: login.php");
    exit();
} else if ($_SESSION["is_admin"] == 'TRUE'){
    header("Location: admin_home.php ");

}else{
    include_once('../includes/header.php');
}

?>


<?php 
include_once('../includes/footer.php');
?>