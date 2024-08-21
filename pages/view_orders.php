
<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../includes/database.php';
require_once '../includes/orders.php';
require_once '../includes/user.php';


if (!isset($_SESSION["user_name"])){
    header("Location: login.php");
    exit();
} else if ($_SESSION["is_admin"] == 'TRUE'){
    require_once '../includes/header.php';
}else{

    // here we want to implement a page that says this page is for admins only
    header("Location: home.php");
}



$database = new Database();
$db = $database->getConnection();

$orderData = new Order($db);
$orderData->getorders();

include_once('../includes/footer.php');

?>

