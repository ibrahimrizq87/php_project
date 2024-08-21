<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');
require_once '../includes/database.php';

try {
    $database = new Database();
    $pdo = $database->getConnection();

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = 'UPDATE products set availability=? where id =?';
    $stmt = $pdo->prepare($query);
    $id = $_GET['id']; 

    $stmt->execute([ $_GET['availability'],$_GET['id']]);

    echo json_encode(['success' => 'donnnnnne' , 'data'=>[ $_GET['availability'], 'id' =>$_GET['id']]]);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
    exit();
}

?>
