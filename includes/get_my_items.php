
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '../includes/database.php';


    try {
        $database = new Database();
$db = $database->getConnection();
$id = $_GET['id']; 
$query = "
SELECT item.quantity AS quantity, item.price AS price, pro.image AS image, pro.name as name 
FROM order_items AS item
JOIN products AS pro ON pro.id = item.product_id
WHERE order_id = ?
";


        $stmt = $db->prepare($query);

        $stmt->execute([$id]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['data'=>$data]) ;
    } catch (PDOException $e) {
        echo json_encode(['error'=>$e]) ;
    }