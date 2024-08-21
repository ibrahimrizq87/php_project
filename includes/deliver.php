<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../includes/database.php';

try {
    $database = new Database();
    $pdo = $database->getConnection();

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = 'UPDATE orders set status =? where id =?';
    $stmt = $pdo->prepare($query);
    $id = $_GET['id']; 

    $stmt->execute(['delivered',$_GET['id']]);

    header("Location: ../pages/view_orders.php");

} catch (PDOException $e) {
    echo (['error' => 'Database connection failed: ' . $e->getMessage()]);
    exit();
}

?>