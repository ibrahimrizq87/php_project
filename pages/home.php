
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


<!-- <div class="container mb-2"> user name is here </div> -->

        <div class="row">  
            
        
        <div class="dropdown col-md-8">
  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
    Choose User
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" id = 'user-list'>
 
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
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-4">
                

                <div class="summary-container p-3 border m-3">

                <div class="container d-flex flex-wrap justify-content-center">
      <div class="col-12 col-lg-auto mb-2 mb-lg-0 me-lg-auto d-flex align-items-center">
      <img id = 'cus-image' src="images/user.png" alt="User Image" class="rounded-circle" width="40" height="40">
      <span class="ms-2 fw-bold" id='cus_name'>Customer:  </span>   
    </div>
                </div>
                </div>


                <h3>Order Summary</h3>
                <div class="summary-container p-3 border">
                    <ul class="list-group mb-3 " id ='order'>
                 
                    </ul>
                    <textarea id ="note" class="form-control mb-3" rows="3" placeholder="Add a note..."></textarea>
                    <h5 id = 'total'>Total: $0</h5>
                    <button id ="confirm" class="btn btn-primary w-100">Confirm Order</button>



              
            </div>
            <div id='error' class="mt-3"></div>



        </div>
    </div>
<script src = '../script/home.js'>
</script>
<?php 
include_once('../includes/footer.php');
?>