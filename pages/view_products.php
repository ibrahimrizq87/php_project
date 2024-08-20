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


$database = new Database();
$db = $database->getConnection();

$product = new Product($db);
$data = $product->get_products();
$products = [];
if ($data == -1){

    echo '<div class="alert alert-danger col-3 m-3" role="alert">
    <h5 style="display:inline;"> there is an error happend while getting products data</h5>
    </div>';
}else{
    $products = $data;

?>



  <div class="container d-flex flex-column">
    <div class="align-self-end m-3"><a href="add_product.php" class="btn btn-success">Add New Product</a></div>
    <table class="table table-striped mt-5 text-center">
      <tr>
        <th>Product</th>
        <th>Price</th>
        <th>Image</th>
        <th>Actions</th>
      </tr>
      <?php
      if ($products) {

        foreach ($products as $product) {
      ?>
          <tr>
            <td> <?php echo ucfirst($product['name']); ?></td>
            <td> <?php echo $product['price']; ?> EGP</td>
            <td>
              <div style="width: 70px; height:70px; overflow:hidden;">
                <img width="100%" src=" <?php echo $product['image']; ?> ">
              </div>
            </td>
            <td>
              <button class="available btn btn-success"><?php echo ucfirst($product['availability']); ?></button>
              <a href="" class="btn btn-info">EDIT</a>
              <a href="" class="btn btn-danger">DELETE</a>
            </td>
          </tr>
      <?php
        }
      } else {
        echo '
        <tr>
          <td colspan="4">
            <div class="alert alert-primary" role="alert">
              You have no products to display ! <a href="addProduct.php" class="btn btn-success">Add Product</a>
            </div>
          </td>
        </tr>';
      }
      ?>
    </table>
  </div>
  <br>
  <br>
  <br>
  <br>

  

  <script>
    $('.available').click(function() {
      if ($(this).text() == 'Available') {
        $(this).addClass('btn-warning').removeClass("btn-success").text('Unavailable')
      } else {
        $(this).addClass('btn-success').removeClass("btn-warning").text('Available')
      }
    })
  </script>
<?php
}
include_once('../includes/footer.php');
?>