<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);



class Product {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }
    public function add_product() {
        $ext = explode('/', $_FILES['image']['type'])[1];
        $file_path = "../uploads/products/" . $_FILES['image']['name'];
        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $file_path)) {
          return "Sorry, there was an error uploading your image.";
        }else{
        
                 try{


        $query = 'INSERT INTO products (name,price,category,image) values (?,?,?,?)';

        $stmt = $this->conn->prepare($query);
        
      $stmt->execute([$_POST['name'], $_POST['price'],$_POST['category'],$file_path] ) ;

      return 'done';

    }    catch(Exception $e) {
        return  'Connection failed: ' . $e->getMessage();

    }
}

    }  

    
    public function get_products(){
        try{
    
            $stmt = $this->conn->prepare("SELECT * FROM products");
            $stmt->execute();
        
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
            return $products;
        
        } catch(PDOException $e) {
            return -1 ;
        }
    }


}