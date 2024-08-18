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
    echo '<p>No Data To Edit</p>';
}




if($_SERVER['REQUEST_METHOD'] == 'POST') {
    try{
         $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);
    $user->edit_user();

    }catch(Exception $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }

}
?>



<html>
<head>
    <title>Add User</title>
</head>
<body><?php echo $user?>;
    <h2>Update User</h2>
    <form method='POST' enctype='multipart/form-data'>
    <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $user['name'] ; ?>" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $user['email'] ; ?>" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="confirmPassword">Confirm Password:</label>
        <input type="password" id="confirmPassword" name="confirmPassword" required><br><br>

        <label for="room_no">Room No.:</label>
        <input type="text" id="room_no" name="room_no" value="<?php echo $user['room_no'] ; ?>"><br><br>

        <label for="ext">Ext.:</label>
        <input type="text" id="ext" name="ext" value="<?php echo$user['ext'] ; ?>"><br><br>

        <label for="profile_pic">Profile Picture:</label>
        <input type="file" id="profilePicture" name="profile_pic" accept="image/*"><br><br>

        <label for="is_admin">User:</label>
        <input type="radio" name="is_admin" value="TRUE" <?php echo isset($user['is_admin']) && $user['is_admin'] == 'TRUE' ? 'checked' : ''; ?>>
        <label for="TRUE">Admin</label>
        <input type="radio" name="is_admin" value="FALSE" <?php echo isset($user['is_admin']) && $user['is_admin'] == 'FALSE' ? 'checked' : ''; ?>>
        <label for="FALSE">Customer</label><br><br>


        <input type="submit" value="Save"> 

        <input type="reset" value="Reset">
    </form>
</body>