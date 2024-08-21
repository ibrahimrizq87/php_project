<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../includes/database.php';
require_once '../includes/product.php';
if (!isset($_SESSION["user_name"])) {
  header("Location: login.php");
  exit();
}else if ($_SESSION["is_admin"] == 'TRUE'){
  require_once '../includes/header.php';
}else{

  // here we want to implement a page that says this page is for admins only
  header("Location: home.php");
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
      if ($err == 'done') {
        echo '<div class="alert alert-success" role="alert">
                      <h5 style="display:inline;">Product added successfuly :)</h5>
                    </div>';
      } else {
        echo '<div class="alert alert-danger col-3 m-3" role="alert">
        <h5 style="display:inline;">' . $err . '</h5>
      </div>';
      }
    }
  }


  ?>
    <div class="align-self-end m-3"><a href="view_products.php" class="btn btn-info">See all products</a></div>

  <div class="container shadow p-5 mt-5 bg-light rounded mb-5">

        <h2>Add Product</h2>

        
    <form method='POST' enctype='multipart/form-data' class="mt-5">
    <fieldset>
      <br>
      <label for="name" class="form-label" >Product name: </label>
      <input type="text" name="name" id="name" class="form-control">
      <br><br>
      <label for="price">Price: </label>
      <input type="number" name="price" id="price" class="form-control">
      <br><br>
    

      <div class="col-auto my-1">
      <label class="mr-sm-2 form-label"   for="category">Preference</label>
      
      <input class="form-control" list="countries" name="category" id="category"><br><br>

            <datalist id="countries">
            <option value="Hot Drinks">Hot Drinks</option>
            <option value="Hot Drinks">Hot Drinks</option>
            <option value="Hot Drinks">Hot Drinks</option>
            <option value="Hot Drinks">Hot Drinks</option>

            <option value="other">other</option>
            </datalist>
    </div>

      <label for="image" class="form-label">Product picture: </label>
      <input type="file" name="image" id="image" class="form-control">
      <br><br>
      <input type="submit" value="Submit" class="btn btn-primary mb-2">
    </fieldset>
  </form>



  </div>

</div>
<br><br><br><br>
<?php
include_once('../includes/footer.php');
?>