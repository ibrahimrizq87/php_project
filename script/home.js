

$(document).ready(function() {

let itemList=[];
let userID = -1;
let recentOrders =[];

if ($('#cus_name').data('id') == '-1'){
     userID = -1;

}else{
    userID = $('#cus_name').data('id');

    console.log('here in home: ', userID)


    $.ajax({
        url: '../includes/get_recent_products.php',
        type: 'GET',
        dataType: 'json',
        data: { id: userID },
        success: function(data) {
            console.log(data);
            recentOrders =data;
            updateRecent();

        },
        error: function(error) {
            console.log("Error: ", error);
        }
    });
}
function updateRecent(){
    $('#recent').empty();
    recentOrders.forEach(function(product){

        $('#recent').append(
            `<td>
            
            <div class="    " ">
  <img class="" src="${product.image}" width = "50" alt="Card image cap">
  <div class="card-body">
    <h5 class="card-title">${product.name}</h5>
    <p class="card-text">${product.price} EGP</p>
  </div>
</div>
            </td>`
        );
    });
    
}

order = {
    status: null,              
    total_price: null,               
    user_id: userID,
    note : ""                    
};
var products=[];
    $.ajax({
        url: '../includes/get_products.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            products =data;
            products.forEach(function(product) {
                product.no = 0;
            });
            updateProducts();

        },
        error: function(error) {
            console.log("Error: ", error);
        }
    });



    var users=[];
    $.ajax({
        url: '../includes/get_users.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            // console.log(data); 
            users =data;
            updateUsers();

        },
        error: function(error) {
            console.log("Error: ", error);
        }
    });
function updateUsers(){
    $('#user-list').empty();
users.forEach(function(user){
    $('#user-list').append(`<li><button  class="dropdown-item user-bt" data-id = "${user.id}">#${user.id}: ${user.name}</button></li>`);

});
   
}



function updateOrder(){
    $('#order').empty();
    let total = 0;
    itemList=[];
    products.forEach(function(product) {
        if (product.no>0){

            let item = {
                product_id: product.id,      
                quantity: product.no,          
                price: product.price             
            };
            itemList.push(item);
            total += (product.price * product.no);
    console.log(product);

        $('#order').
        append(`<li class="list-group-item d-flex justify-content-between align-items-center">
            ${product.name} - $${product.price * product.no}  
          <span class="badge quantity-badge bg-secondary"> ${product.no}</span>
            </li>`);
        }

    });

    order = {
        status: 'Pending',              
        total_price: total,               
        user_id: userID,
        note : ""                    
    };

    $('#total').text(`Total: $${total}`);
}


function updateProducts(){

    $('#products_table').empty();
    products.forEach(function(product) {

        $('#products_table').
        append(`   <tr>
                        <td><img src="${product.image}" alt="Drink 1" class="drink-image" width ="50"></td>
                        <td>${product.name}</td>
                        <td>$${product.price}</td>
                        <td>${product.category}</td>
                        <td>
                            <button data-id="${product.id}" class="btn btn-sm btn-secondary"    id='rem_bt' ">-</button>
                            ${product.no}
                            <button class="btn btn-sm btn-danger"  data-id="${product.id}" id='add_bt' >+</button>
                        </td>
                    </tr>`);
    });
}

$(document).on('click', '#add_bt', function() {
    let id = $(this).data('id');

    
    products.forEach(function(product) {

        if (product.id == id) {


          

            product.no += 1; 
            updateProducts();  
            updateOrder();  
            return;
        }
    });
   
});



$(document).on('click', '.user-bt', function() {
    // console.log('here butttttton')
    let id = $(this).data('id');  
    console.log(users)
    users.forEach(function(user) {

        if (user.id == id) {
        $('#cus_name').text(user.name);
        $('#cus-image').attr('src', user.profile_pic);
        userID = user.id;
        order.user_id=userID;
        // console.log(user.image);

        // $('#cus-image').src(user.image);
            return;
        }
    });
   
});

$(document).on('click', '#rem_bt', function() {
    let id = $(this).data('id');

    
    products.forEach(function(product) {

        if (product.id == id) {


          

            if (product.no>0){
                product.no -= 1;
                updateProducts();  
                updateOrder();  
                
            } 
            return;
        }
    });
   
});



$(document).on('click', '#confirm', function() {
    $("#error").empty();
    let orderNote = $('#note').val();
    // console.log();
    console.log(order);
    if (order.user_id  <0){
        $("#error").append(

            ` <div class="container mt-5">
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Error!</h4>
                    <p> you have to choose a customer first</p>
                </div>
            </div>`
        );
    }else if (itemList.length === 0){
        $("#error").append(

            ` <div class="container mt-5">
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Error!</h4>
                    <p> can not make order without items add .. </p>
                </div>
            </div>`
        );
    }else{
        order.note = orderNote;
        // console.log(order);
        // console.log(itemList);

        const dataToSend = {
            order: order,
            items: itemList
        };
        console.log(dataToSend);


        $.ajax({
            url: '../includes/add_order.php',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(dataToSend),
            success: function(response) {
                console.log('Success:', response);

                $("#error").append(`
                    <div id="success-message" class="container mt-5">
                        <div class="alert alert-success" role="alert">
                            <h4 class="alert-heading">Success!</h4>
                            <p>Order created successfully!</p>
                        </div>
                    </div>
                `);
                
                setTimeout(function() {
                    $("#success-message").fadeOut("slow", function() {
                        $(this).remove(); 
                    });
                }, 2000);


                products.forEach(function(product){
                    product.no = 0;
                });

                updateOrder();
                updateProducts();

                itemList=[];
                if ($('#cus_name').data('id') == '-1'){
                    userID = -1;
               
               }
                order = {
                status: null,              
                total_price: null,               
                user_id: userID,
                note : ""                    
                };


                $('#cus_name').text("customer:");
        $('#cus-image').attr('src', "images/user.png");

            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                console.error('Response:', xhr.responseText);
            }
        });
    }
    

});

});