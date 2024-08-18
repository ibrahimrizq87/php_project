<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../includes/database.php';
require_once '../includes/user.php';
require_once '../includes/header.php';



?>
<h2>All users</h2>
<a href='add_user.php'>Add user</a>

<?php
    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);
    $user->get_users();

    require_once '../includes/footer.php';

?>