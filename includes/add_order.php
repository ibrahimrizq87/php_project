<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');
require_once '../includes/database.php';

try {
    $database = new Database();
    $pdo = $database->getConnection();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
    exit();
}

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['order']) || !isset($input['items']) || !is_array($input['items'])) {
    echo json_encode(['error' => 'Invalid input data']);
    exit();
}

$order = $input['order'];
$items = $input['items'];


try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("INSERT INTO orders (date, status, total_price, user_id, note) VALUES (NOW(), :status, :total_price, :user_id, :note)");
    $stmt->execute([
        ':status' => $order['status'], 
        ':total_price' => $order['total_price'],
        ':user_id' => $order['user_id'],
        ':note' => $order['note'] ?? null 
    ]);

    $orderId = $pdo->lastInsertId();

    $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)");

    foreach ($items as $item) {
        $stmt->execute([
            ':order_id' => $orderId,
            ':product_id' => $item['product_id'],
            ':quantity' => $item['quantity'],
            ':price' => $item['price']
        ]);
    }

    $pdo->commit();

    echo json_encode(['success' => true, 'order_id' => $orderId]);

} catch (PDOException $e) {
    $pdo->rollBack();
    echo json_encode(['error' => 'Failed to add order: ' . $e->getMessage()]);
}
?>
