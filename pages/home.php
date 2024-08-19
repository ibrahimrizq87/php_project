
<?php 
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);


 if (!isset($_SESSION["user_name"])){
    header("Location: login.php");
    exit();
} else {
    include_once('../includes/header.php');
}

?>


<div class="container mt-5">
        <div class="row">            
        <div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
    Choose User
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <li><a class="dropdown-item" href="#">Action</a></li>
    <li><a class="dropdown-item" href="#">Another action</a></li>
    <li><a class="dropdown-item" href="#">Something else here</a></li>
  </ul>
</div>
            <div class="col-md-8 mt-5">

                <h3 style ="text-align:center;  ">Available Drinks</h3>
                <div class="scrollable-table">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody id='products_table'>
                            <tr>
                                <td><img src="drink1.jpg" alt="Drink 1" class="drink-image"></td>
                                <td>Latte</td>
                                <td>$4</td>
                                <td>Coffee</td>
                                <td>
                                    <button class="btn btn-sm btn-secondary">-</button>
                                    1
                                    <button class="btn btn-sm btn-secondary">+</button>
                                </td>
                            </tr>
                            <tr>
                                <td><img src="drink2.jpg" alt="Drink 2" class="drink-image"></td>
                                <td>Green Tea</td>
                                <td>$3</td>
                                <td>Tea</td>
                                <td>
                                    <button class="btn btn-sm btn-secondary">-</button>
                                    1
                                    <button class="btn btn-sm btn-secondary">+</button>
                                </td>
                            </tr>
                            <tr>
                                <td><img src="drink3.jpg" alt="Drink 3" class="drink-image"></td>
                                <td>Americano</td>
                                <td>$5</td>
                                <td>Coffee</td>
                                <td>
                                    <button class="btn btn-sm btn-secondary">-</button>
                                    1
                                    <button class="btn btn-sm btn-secondary">+</button>
                                </td>
                            </tr>
                            <tr>
                                <td><img src="drink4.jpg" alt="Drink 4" class="drink-image"></td>
                                <td>Milkshake</td>
                                <td>$6</td>
                                <td>Milk</td>
                                <td>
                                    <button class="btn btn-sm btn-secondary">-</button>
                                    1
                                    <button class="btn btn-sm btn-secondary">+</button>
                                </td>
                            </tr>
                            <tr>
                                <td><img src="drink5.jpg" alt="Drink 5" class="drink-image"></td>
                                <td>Cappuccino</td>
                                <td>$5</td>
                                <td>Coffee</td>
                                <td>
                                    <button class="btn btn-sm btn-secondary">-</button>
                                    1
                                    <button class="btn btn-sm btn-secondary">+</button>
                                </td>
                            </tr>


                            <tr>
                                <td><img src="drink1.jpg" alt="Drink 1" class="drink-image"></td>
                                <td>Latte</td>
                                <td>$4</td>
                                <td>Coffee</td>
                                <td>
                                    <button class="btn btn-sm btn-secondary">-</button>
                                    1
                                    <button class="btn btn-sm btn-secondary">+</button>
                                </td>
                            </tr>

                            <tr>
                                <td><img src="drink1.jpg" alt="Drink 1" class="drink-image"></td>
                                <td>Latte</td>
                                <td>$4</td>
                                <td>Coffee</td>
                                <td>
                                    <button class="btn btn-sm btn-secondary">-</button>
                                    1
                                    <button class="btn btn-sm btn-secondary">+</button>
                                </td>
                            </tr>


                            <tr>
                                <td><img src="drink1.jpg" alt="Drink 1" class="drink-image"></td>
                                <td>Latte</td>
                                <td>$4</td>
                                <td>Coffee</td>
                                <td>
                                    <button class="btn btn-sm btn-secondary">-</button>
                                    1
                                    <button class="btn btn-sm btn-secondary">+</button>
                                </td>
                            </tr>



                            <tr>
                                <td><img src="drink1.jpg" alt="Drink 1" class="drink-image"></td>
                                <td>Latte</td>
                                <td>$4</td>
                                <td>Coffee</td>
                                <td>
                                    <button class="btn btn-sm btn-secondary">-</button>
                                    1
                                    <button class="btn btn-sm btn-secondary">+</button>
                                </td>
                            </tr>



                            <tr>
                                <td><img src="drink1.jpg" alt="Drink 1" class="drink-image"></td>
                                <td>Latte</td>
                                <td>$4</td>
                                <td>Coffee</td>
                                <td>
                                    <button class="btn btn-sm btn-secondary">-</button>
                                    1
                                    <button class="btn btn-sm btn-secondary">+</button>
                                </td>
                            </tr>



                            <tr>
                                <td><img src="drink1.jpg" alt="Drink 1" class="drink-image"></td>
                                <td>Latte</td>
                                <td>$4</td>
                                <td>Coffee</td>
                                <td>
                                    <button class="btn btn-sm btn-secondary">-</button>
                                    1
                                    <button class="btn btn-sm btn-secondary">+</button>
                                </td>
                            </tr>



                            <tr>
                                <td><img src="drink1.jpg" alt="Drink 1" class="drink-image"></td>
                                <td>Latte</td>
                                <td>$4</td>
                                <td>Coffee</td>
                                <td>
                                    <button class="btn btn-sm btn-secondary">-</button>
                                    1
                                    <button class="btn btn-sm btn-secondary">+</button>
                                </td>
                            </tr>




                            <tr>
                                <td><img src="drink1.jpg" alt="Drink 1" class="drink-image"></td>
                                <td>Latte</td>
                                <td>$4</td>
                                <td>Coffee</td>
                                <td>
                                    <button class="btn btn-sm btn-secondary">-</button>
                                    1
                                    <button class="btn btn-sm btn-secondary">+</button>
                                </td>
                            </tr>



                            <tr>
                                <td><img src="drink1.jpg" alt="Drink 1" class="drink-image"></td>
                                <td>Latte</td>
                                <td>$4</td>
                                <td>Coffee</td>
                                <td>
                                    <button class="btn btn-sm btn-secondary">-</button>
                                    1
                                    <button class="btn btn-sm btn-secondary">+</button>
                                </td>
                            </tr>



                            <tr>
                                <td><img src="drink1.jpg" alt="Drink 1" class="drink-image"></td>
                                <td>Latte</td>
                                <td>$4</td>
                                <td>Coffee</td>
                                <td>
                                    <button class="btn btn-sm btn-secondary">-</button>
                                    1
                                    <button class="btn btn-sm btn-secondary">+</button>
                                </td>
                            </tr>



                            <tr>
                                <td><img src="drink1.jpg" alt="Drink 1" class="drink-image"></td>
                                <td>Latte</td>
                                <td>$4</td>
                                <td>Coffee</td>
                                <td>
                                    <button class="btn btn-sm btn-secondary">-</button>
                                    1
                                    <button class="btn btn-sm btn-secondary">+</button>
                                </td>
                            </tr>




                            <tr>
                                <td><img src="drink1.jpg" alt="Drink 1" class="drink-image"></td>
                                <td>Latte</td>
                                <td>$4</td>
                                <td>Coffee</td>
                                <td>
                                    <button class="btn btn-sm btn-secondary">-</button>
                                    1
                                    <button class="btn btn-sm btn-secondary">+</button>
                                </td>
                            </tr>


                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-4">
                <h3>Order Summary</h3>
                <div class="summary-container p-3 border">
                    <ul class="list-group mb-3">
                        <li class="list-group-item">Latte - $4</li>
                        <li class="list-group-item">Green Tea - $3</li>
                    </ul>
                    <textarea class="form-control mb-3" rows="3" placeholder="Add a note..."></textarea>
                    <h5>Total: $7</h5>
                    <button class="btn btn-primary w-100">Confirm Order</button>
                </div>
            </div>
        </div>
    </div>
<script>

$(document).ready(function() {
    $.ajax({
        url: '../includes/products.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            console.log(data); 

            $('#products_table').empty();
            data.forEach(function(product) {

                $('#products_table').
                append(`   <tr>
                                <td><img src="${product.image}" alt="Drink 1" class="drink-image" width ="50"></td>
                                <td>${product.name}</td>
                                <td>$${product.price}</td>
                                <td>${product.category}</td>
                                <td>
                                    <button class="btn btn-sm btn-secondary">-</button>
                                    1
                                    <button class="btn btn-sm btn-danger">+</button>
                                </td>
                            </tr>`);
            });
        },
        error: function(error) {
            console.log("Error: ", error);
        }
    });
});
</script>
<?php 
include_once('../includes/footer.php');
?>