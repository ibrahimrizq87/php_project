<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../includes/database.php';
require_once '../includes/product.php';
if (!isset($_SESSION["user_name"])){
  header("Location: login.php");
  exit();
} else {
  include_once('../includes/header.php');
}
?>

  <div class="container">
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (
        empty($_POST['name'])
        || empty($_POST['price'])
        || empty($_POST['category'])
        || empty($_FILES['image']['name'])
      ) {
        echo '<div class="alert alert-danger col-3 m-3" role="alert">
            <h5 style="display:inline;">Please Fill All Fields!</h5>
          </div>';
      } else {


        



            $database = new Database();
            $db = $database->getConnection();

            $product = new Product($db);
            $err = $product->add_product();
    if ($err == 'done'){
        echo '<div class="alert alert-success" role="alert">
                      <h5 style="display:inline;">Product added successfuly :)</h5>
                    </div>';
        
    }else{
        echo '<div class="alert alert-danger col-3 m-3" role="alert">
        <h5 style="display:inline;">'.$err.'</h5>
      </div>';
    }
        }


      }
    

    ?>
    <form action="" enctype='multipart/form-data' method="POST">
      <fieldset>
        <br>
        <label for="name">Product name: </label>
        <input type="text" name="name" id="name">
        <br><br>
        <label for="price">Price: </label>
        <input type="number" name="price" id="price">
        <br><br>
        <label for="category">Category: </label>
        <select name="category" id="category">
          <option value="Hot Drinks">Hot Drinks</option>
          <option value="other">other</option>
        </select>
        <br><br>
        <label for="image">Product picture: </label>
        <input type="file" name="image" id="image">
        <br><br>
        <input type="submit" value="Submit">
      </fieldset>
    </form>



  </div>
  <?php 
include_once('../includes/footer.php');
?>