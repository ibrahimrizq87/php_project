<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);



class Product
{
  private $conn;

  public function __construct($db)
  {
    $this->conn = $db;
  }
  public function add_product()
  {
    $ext = explode('/', $_FILES['image']['type'])[1];
    $image = $_POST['name'] . '.' . $ext;
    $file_path = "../uploads/products/" . $image;
    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $file_path)) {
      return "Sorry, there was an error uploading your image.";
    } else {

      try {


        $query = 'INSERT INTO products (name,price,category,image) values (?,?,?,?)';

        $stmt = $this->conn->prepare($query);

        $stmt->execute([$_POST['name'], $_POST['price'], $_POST['category'], $file_path]);

        return 'done';
      } catch (Exception $e) {
        return  'Connection failed: ' . $e->getMessage();
      }
    }
  }


  public function get_products()
  {
    try {
      
      $page=isset($_GET{'page'})?(int)$_GET['page']:1;
        $perPage=isset($_GET{'per-page'})?(int)$_GET['per-page']:5;

        $start=($page>1) ? ($page * $perPage) - $perPage : 0;


        $query=$this->conn->prepare("select SQL_CALC_FOUND_ROWS * from products limit $start,$perPage
        ");
        $query->execute();
        $products = $query->fetchAll(PDO::FETCH_ASSOC);

        $total=$this->conn->query("select FOUND_ROWS() as total")->fetch()['total'];
        $pages=ceil($total/$perPage);

      return ['products'=> $products, 'pages'=>$pages ,'perPages'=>$perPage ,'page'=> $page];
    } catch (PDOException $e) {
      return -1;
    }
  }

  public function get_product($id)
  {
    try {

      $stmt = $this->conn->prepare("SELECT * FROM products where id=?");
      $stmt->execute([$id]);

      $product = $stmt->fetch(PDO::FETCH_ASSOC);

      return $product;
    } catch (PDOException $e) {
      return -1;
    }
  }

  public function edit_product()
  {
    $ext = explode('/', $_FILES['image']['type'])[1];
    $image = $_POST['name'] . '.' . $ext;
    $file_path = "../uploads/products/" . $image;
    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $file_path)) {
      return "Sorry, there was an error uploading your image.";
    } else 

      try {

      $query = 'UPDATE products set name=?, price=? ,category=? ,image=?,availability=? where id =?';
      $stmt = $this->conn->prepare($query);

      $stmt->execute([$_POST['name'], $_POST['price'], $_POST['category'], $file_path, $_POST['availability'] ,$_POST['id']]);

      return 'done';
    } catch (Exception $e) {
      return  'Connection failed: ' . $e->getMessage();
    }
  }
  public function delete_product($id)
  {
    try {

      $stmt = $this->conn->prepare("DELETE FROM products where id=?");
      $stmt->execute([$id]);
      return header("Location: view_products.php");
    } catch (PDOException $e) {
      return -1;
    }
  }
}