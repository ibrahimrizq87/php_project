<?php

require_once '../includes/database.php';
require_once '../includes/product.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
  $id = $_GET['id'];
  $database = new Database();
  $db = $database->getConnection();
  $product = new Product($db);
  $data = $product->delete_product($id);
} else {
  header("Location: view_products.php");
  exit();
}