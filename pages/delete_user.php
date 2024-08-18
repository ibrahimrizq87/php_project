<?php

require_once '../includes/database.php';
require_once '../includes/user.php';

if($_SERVER['REQUEST_METHOD'] == 'GET') {
    try{
         $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);
    $user->delete_user();

    }catch(Exception $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }

}