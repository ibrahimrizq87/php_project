<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../includes/database.php';
require_once '../includes/product.php';
if (!isset($_SESSION["user_name"])) {
  header("Location: login.php");
  exit();
} else if ($_SESSION["is_admin"] == 'TRUE'){
  require_once '../includes/header.php';
}else{

  // here we want to implement a page that says this page is for admins only
  header("Location: home.php");
}
$database = new Database();
$db = $database->getConnection();

$product = new Product($db);
$data = $product->get_products();
$products = [];
$pages=0;
$page =0;
$perPage=0;
if ($data == -1) {
  echo '<div class="alert alert-danger col-3 m-3" role="alert">
    <h5 style="display:inline;"> there is an error happend while getting products data</h5>
    </div>';
} else {
  $products = $data['products'];
  $pages = $data['pages'];
  $page = $data['page'];

  $perPage = $data['perPages'];
  
?>
  <div class="container d-flex flex-column">
    <div class="align-self-end m-3"><a href="add_product.php" class="btn btn-success">Add New Product</a></div>

    <table class="table table-striped mt-1 text-center border rounded shadow">
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
            <?php
            if($product['availability'] == 'available'){
             
            ?>
              <button data-id =<?php echo $product['id']; ?> class="availability btn btn-success">Available</button>
              <?php
            
            }else{
            ?>
              <button data-id =<?php echo $product['id']; ?> class="availability btn btn-warning">Unavailable</button>

<?php

          }
          ?>
              <a href="edit_product.php?id=<?php echo $product['id']; ?>" class="btn btn-info">EDIT</a>
              <a href="delete_product.php?id=<?php echo $product['id']; ?>" class="btn btn-danger">DELETE</a>
            </td>
          </tr>
      <?php
        }
      } else {
        echo '
        <tr>
          <td colspan="4">
            <div class="alert alert-primary" role="alert">
              You have no products to display ! <a href="add_product.php" class="btn btn-success">Add Product</a>
            </div>
          </td>
        </tr>';
      }
      ?>
         <tr><td colspan="4"> <?php for($i=1;$i<=$pages;$i++):?> 
    <?php if ($i == $page){?>
                        <a class='btn btn-warning 'href='?page=<?php echo $i ?>&per-page=<?php echo $perPage?>'> <?php echo $i?> </a>
                        <?php } else{ ?>
                            <a class='btn btn-primary 'href='?page=<?php echo $i ?>&per-page=<?php echo $perPage?>'> <?php echo $i?> </a>

                            <?php } ?>
                        <?php endfor?></td></tr>
      
    </table>
  </div>
  <br>
  <br>
  <br>
  <br>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
  integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>

    $(document).ready(function() {

      $('.availability').click(function() {

        let id =$(this).data('id');
      if ($(this).text() == 'Available') {
        $(this).addClass('btn-warning').removeClass("btn-success").text('Unavailable');

        console.log('here');
        console.log(id);

        $.ajax({
        url: '../includes/product_available.php',
        type: 'GET',
        dataType: 'json',
        data: { id: id ,availability: 'unavailable'},
        success: function(data) {
          console.log(data);
        },
        error: function(error) {
            console.log("Error: ", error);
        }
    });
      } else {
        $(this).addClass('btn-success').removeClass("btn-warning").text('Available');

        $.ajax({
        url: '../includes/product_available.php',
        type: 'GET',
        dataType: 'json',
        data: { id: id ,availability: 'available'},
        success: function(data) {
          console.log(data);
        },
        error: function(error) {
            console.log("Error: ", error);
        }
    });

      }
    });
    });
  </script>

<?php
}
include_once('../includes/footer.php');
?>