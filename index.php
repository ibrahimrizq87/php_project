

<?php 
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);


 if (!isset($_SESSION["user_name"])){
    header("Location: pages/login.php");
    exit();
} else if ($_SESSION["is_admin"] == 'TRUE'){
    header("Location: pages/admin_home.php ");

}else{
    header("Location: pages/customer_home.php ");
}

?>


<?php 
include_once('includes/footer.php');
?>