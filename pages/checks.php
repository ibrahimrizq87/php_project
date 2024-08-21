
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

    header("Location: home.php");
}



$database = new Database();
$db = $database->getConnection();

?><div class ="container">
<a class ="btn btn-info" href = 'checks.php'> view All</a>
</div>
<?php

$orderData = new Order($db);
$orderData->getChecksById();

include_once('../includes/footer.php');

?>

