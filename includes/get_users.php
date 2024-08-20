<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '../includes/database.php';
try {
$database = new Database();
$db = $database->getConnection();



 
          
            $stmt = $db->prepare("SELECT * FROM users where is_admin = 'FALSE'");
            $stmt->execute();
        
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
            echo json_encode($users);
        
        } catch(PDOException $e) {
            echo json_encode(["error" => $e->getMessage()]);
        }



?>