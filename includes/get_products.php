<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '../includes/database.php';
try {
$database = new Database();
$db = $database->getConnection();
            $stmt = $db->prepare("SELECT * FROM products");
            $stmt->execute();
        
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
            echo json_encode($products);
        
        } catch(PDOException $e) {
            echo json_encode(["error" => $e->getMessage()]);
        }



?>