
<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../includes/database.php';
require_once '../includes/orders.php';
require_once '../includes/user.php';

if (!isset($_SESSION["user_name"])){
    header("Location: login.php");
    exit();
} else if ($_SESSION["is_admin"] == 'FALSE'){
    require_once '../includes/header.php';
}else{

    header("Location: home.php");
}



$database = new Database();
$db = $database->getConnection();

$orderData = new Order($db);
$orders =[];
$pages =0;
$page =0;
$perPage = 0;
$data = $orderData->getMyOrders();
if ($data == -1){
    echo 'erro happend';
}else{
    $orders = $data['orders'];
    $pages = $data['pages'];
    $page = $data['page'];

    $perPage = $data['perPages'];
}
?>


<div class="container d-flex flex-column">
<table class="  table table-striped mt-5 text-center border rounded shadow item-list">

      </table>

    <table class="table table-striped mt-5 text-center border rounded shadow">
      <tr>
        <th>Date</th>
        <th>Total Price</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>

      
<?php
// var_dump($orders);
foreach ($orders as $order) {
    echo '
       <tr>
        <td>'.$order['date'].'</td>
        <td>'.$order['total_price'].'</td>
        <td>'.$order['status'].'</td>
        <td>
        <button class="btn btn-danger" id = "cancel" data-id = '. $order['id'] .'>Cancel</button>
        <button class="btn btn-primary" id = "expand"  data-id ='. $order['id'] .'>+</button>
        </td>

    ';
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
<br><br><br><br>

      <script>

$(document).ready(function() {

$('#cancel').click(function() {

  let id =$(this).data('id');
  console.log(id);

  $.ajax({
  url: '../includes/cancel_order.php',
  type: 'GET',
  dataType: 'json',
  data: { id: id },
  success: function(data) {
    console.log(data);
    location.reload();
  },
  error: function(error) {
      console.log("Error: ", error);
  }
});
});
$(document).on('click', '#expand', function() {

    let id =$(this).data('id');

    $.ajax({
  url: '../includes/get_my_items.php',
  type: 'GET',
  dataType: 'json',
  data: { id: id },
  success: function(data) {
    $(`.item-list`).empty();
    console.log(id);
    $(`.item-list`).append(`
        <tr >
        <th>name</th>
        <th>quantity Price</th>
        <th>price</th>
        <th>Image</th>
      </tr>`);

data.data.forEach(function (item){

$(`.item-list`).append(`<tr>
<td>${item.name}</td>
<td>${item.quantity}</td>
<td>${item.price}</td>
<td><img src=${item.image} width = '90px'></td>
</tr>


`);
});
$(`.item-list`).append(`
      <tr >
<td colspan="4" class="text-center">
        <button id="clear" class="btn btn-info">Clear</button>
    </td></tr>`);
    console.log(data);
  },
  error: function(error) {
      console.log("Error: ", error);
  }
});


});





$(document).on('click', '#clear', function() {
    $(`.item-list`).empty();
});
});


      </script>


<?php



include_once('../includes/footer.php');

?>

