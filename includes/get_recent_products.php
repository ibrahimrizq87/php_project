


<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '../includes/database.php';
try {

$id = $_GET['id']; 

$database = new Database();
$db = $database->getConnection();

$stmt = $db->prepare("
    SELECT oi.product_id 
    FROM orders o 
    JOIN order_items oi ON o.id = oi.order_id 
    WHERE o.user_id = ? 
    ORDER BY o.date DESC 
    LIMIT 5
");
$stmt->execute([$id]);

$product_ids = $stmt->fetchAll(PDO::FETCH_COLUMN);

if (empty($product_ids)) {
    echo json_encode([]);
    exit;
}

$in_query = implode(',', array_fill(0, count($product_ids), '?'));

$product_stmt = $db->prepare("
    SELECT * 
    FROM products 
    WHERE id IN ($in_query)
");

$product_stmt->execute($product_ids);

$products = $product_stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($products);

} catch(PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}

?>
