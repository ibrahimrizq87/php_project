

<?php 
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);


 if (!isset($_SESSION["user_name"])){
    header("Location: pages/login.php");
    exit();
} else {
    header("Location: pages/home.php");
}
?>


