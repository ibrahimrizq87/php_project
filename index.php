

<?php 
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

// var_dump($_SESSION["user_name"]) ;
// echo $_SESSION["image"];
// echo $_SESSION["is_admin"];


 if (!isset($_SESSION["user_name"])){
    header("Location: pages/login.php");
    exit();
} else if ($_SESSION["is_admin"]){
    include_once('includes/admin_header.php');
}else{
    include_once('includes/header.php');
}

?>


<?php 
include_once('includes/footer.php');


?>