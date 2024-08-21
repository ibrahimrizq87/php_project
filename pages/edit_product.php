<?php
require_once '../includes/database.php';
require_once '../includes/product.php';
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
$database = new Database();
$db = $database->getConnection();
$product = new Product($db);
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
      $err = $product->edit_product();
      if ($err == 'done') {
        echo '<div class="alert alert-success" role="alert">
                      <h5 style="display:inline;">Product updated successfuly :)</h5>
                    </div>';
      } else {
        echo '<div class="alert alert-danger col-3 m-3" role="alert">
        <h5 style="display:inline;">' . $err . '</h5>
      </div>';
      }
    }
  }
  else if ($_SERVER['REQUEST_METHOD'] == 'GET' && !isset($_GET['id']))
  {
    header("Location: view_products.php");
    exit();
  }
  
  $id = $_GET['id'];
  $data = $product->get_product($id);

  ?>
  <div class="align-self-end m-3"><a href="view_products.php" class="btn btn-info">See all products</a></div>
  <div class="container shadow p-5 mt-5 bg-light rounded mb-5">

        <h2>Edit Product</h2>

        
    <form method='POST' enctype='multipart/form-data' class="mt-5">
    <fieldset>
      <br>
      <label for="name" class="form-label">Product name: </label>
      <input type="text"  class="form-control" name="name" id="name" value="<?php echo $data['name']; ?>">
      <br><br>
      <label for="price" class="form-label">Price: </label>
      <input type="number"  class="form-control" name="price" id="price" value="<?php echo $data['price']; ?>">
      <br><br>
      <label for="category" class="form-label">Category: </label>
      <br><br>
      <select name="category" id="category">
        <option value="<?php echo $data['category']; ?>"><?php echo $data['category']; ?></option>
        <option value="Hot Drinks">Hot Drinks</option>
        <option value="other">other</option>
      </select>
      <br><br>
      <label for="image" class="form-label">Product picture: </label>

      <div style="width: 70px; height:70px; overflow:hidden;">
        <img width="100%" src=" <?php echo $data['image']; ?> ">
      </div>
      <br>
      <input type="file"  class="form-control" name="image" id="image">
      
      <br>
      <label for="availability" class="form-label">Availability: </label>
      <br>
      <select name="availability" id="availability">
        <option value="available">Available</option>
        <option value="unavailable">Unavailable</option>
      </select>
      <br><br>

      <input type="submit" value="Submit" class="btn btn-primary mb-2">
    </fieldset>
  </form>



</div>
<br><br><br><br>
<?php
include_once('../includes/footer.php');
?>