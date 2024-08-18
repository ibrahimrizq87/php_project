
<?php 
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);


 if (!isset($_SESSION["user_name"])){
    header("Location: login.php");
    exit();
} else if ($_SESSION["is_admin"] == 'TRUE'){
    include_once('../includes/admin_header.php');
}else{
    header("Location: customer_home.php ");
}

?>


<?php 
include_once('../includes/footer.php');
?>