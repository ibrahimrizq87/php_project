<?php

class Order {
    private $conn;
    public $orders;
    public $total;
    public $perPage;

    public function __construct($db) {
        $this->conn = $db;
    }


    

public function getorders() {

    try {
        // Count total orders for pagination
        $page=isset($_GET{'page'})?(int)$_GET['page']:1;
        $perPage=3;

        $start=($page>1) ? ($page * $perPage) - $perPage : 0;

        $countQuery = "
            select count(*) as total_orders
            from orders;
        ";

        $stmt = $this->conn->prepare($countQuery);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->total = $result['total_orders'];

        // $query = "
        //     select 
        //         u.name as user_name,
        //         o.id as order_id,
        //         o.date as order_date,
        //         o.status as order_status,
        //         o.total_price as order_total_price,
        //         o.note as order_note,
        //         u.room_no as room_no,
        //         u.ext as ext,
        //         p.name as product_name,
        //         p.price as product_price,
        //         p.image as product_image,
        //         oi.quantity as order_item_quantity
        //     from 
        //         users u
        //     join 
        //         orders o on u.id = o.user_id
        //     join 
        //         order_items oi on o.id = oi.order_id
        //     join 
        //         products p on oi.product_id = p.id
        //     order by
        //         o.date DESC
        //         limit $start,$perPage
        // ";
        $query = "
        select 
            u.name as user_name,
            o.id as order_id,
            o.date as order_date,
            o.status as order_status,
            o.total_price as order_total_price,
            o.note as order_note,
            u.room_no as room_no,
            u.ext as ext,
            p.name as product_name,
            p.price as product_price,
            p.image as product_image,
            oi.quantity as order_item_quantity
        from 
            (select id from orders order by date DESC limit $start, $perPage) as o_ids
        join 
            orders o on o.id = o_ids.id
        join 
            users u on u.id = o.user_id
        join 
            order_items oi on o.id = oi.order_id
        join 
            products p on oi.product_id = p.id
        order by
            o.date DESC
    ";
    
        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        // $total=$this->conn->query("select FOUND_ROWS() as total")->fetch()['total'];
        $pages = ceil($this->total / $perPage); 


        if ($stmt->rowCount() > 0) {
            // Group orders by order_id
            $orders = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $orders[$row['order_id']]['order_info'] = [
                    'order_date' => $row['order_date'],
                    'user_name' => $row['user_name'],
                    'room_no' => $row['room_no'],
                    'ext' => $row['ext'],
                    'status' => $row['order_status'],
                    'id' => $row['order_id'],
                    'total_price' => $row['order_total_price']
                ];
                $orders[$row['order_id']]['items'][] = [
                    'product_name' => $row['product_name'],
                    'product_price' => $row['product_price'],
                    'product_image' => $row['product_image'],
                    'quantity' => $row['order_item_quantity']
                ];
            }
// echo "/////".count($orders) ."/////";
// echo $start ."/////";
// echo $perPage;
echo "<div class='container  border shadow rounded p-2 mt-3'>";
for($i=1; $i<=$pages; $i++) {
    if ($i == $page) {
        echo "<a class='btn btn-warning ms-2' href='?page=" . $i . "&per-page=" . $perPage . "'> " . $i . " </a>";
    } else { 
        echo "<a class='btn btn-primary ms-2' href='?page=" . $i . "&per-page=" . $perPage . "'> " . $i . " </a>";
    } 
}
echo "</div>";
            foreach ($orders as $order) {
                echo "
                <div class='container  border shadow rounded p-2 mt-3'>
                <table class='table'>

                        <tr class='table-success'>
                            <th>Order Date</th>
                            <th>Name</th>
                            <th>Room</th>
                            <th>Ext.</th>
                             <th>Status</th>
                            <th>Action</th>
                        </tr>
                        <tr>
                            <td>{$order['order_info']['order_date']}</td>
                            <td>{$order['order_info']['user_name']}</td>
                            <td>{$order['order_info']['room_no']}</td>
                            <td>{$order['order_info']['ext']}</td>
                            <td>{$order['order_info']['status']}</td>";
                            if ($order['order_info']['status'] == 'delivered' || $order['order_info']['status'] == 'canceled'){


                            echo "<td> <a class='btn btn-danger ' href='../includes/delete_order.php?id={$order['order_info']['id']} ' >Delete</a> </td>";
                            }else{

                                echo "

                            <td> <a class='btn btn-primary ' href='../includes/deliver.php?id={$order['order_info']['id']} ' >Deliver</a> </td>";
                            }
                            
                            echo "
                        </tr>
                    </table>";

                echo "<table class='table '>

                        <tr class='table-success'>
                            <th>Order Item</th>
                            <th>Price</th>
                            <th>Quantity</th>
                        </tr>";
                foreach ($order['items'] as $item) {
                    echo "<tr>
                            <td><img src='{$item['product_image']}' alt='Product Image' width='50'> {$item['product_name']}</td>
                            <td>{$item['product_price']} LE</td>
                            <td>{$item['quantity']}</td>
                        </tr>";
                }
                echo "</table>";

                echo "<div style='text-align: right; font-weight: bold; margin-top: 10px;'>Total:  {$order['order_info']['total_price']}
                <hr class='border-dark border-3 opacity-100'></div> 
                </div>  ";
            }

          
            echo "<br><br><br><br>";


            } else {
            echo "No orders found.";
        }
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
}





public function getMyOrders() {
    $id = $_SESSION["id"];

    try {




        $page=isset($_GET{'page'})?(int)$_GET['page']:1;
        $perPage=isset($_GET{'per-page'})?(int)$_GET['per-page']:5;

        $start=($page>1) ? ($page * $perPage) - $perPage : 0;


        $query=$this->conn->prepare("select SQL_CALC_FOUND_ROWS * from orders where user_id = ? and status != 'canceled'
            order by date DESC limit $start,$perPage
        ");
        $query->execute([$id]);
        $orders = $query->fetchAll(PDO::FETCH_ASSOC);

        $total=$this->conn->query("select FOUND_ROWS() as total")->fetch()['total'];
        $pages=ceil($total/$perPage);

      return ['orders'=> $orders, 'pages'=>$pages ,'perPages'=>$perPage ,'page' => $page];




        // $query = "
        //     select * from orders where user_id = ? and status != 'canceled'
        //     order by date DESC
        // ";

        // $stmt = $this->conn->prepare($query);

        // $stmt->execute([$id]);
        // $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // return $data;
    } catch (PDOException $e) {
        return -1;
    }
}







// public function getChecks() {
//     try {
//         $queryAllUsers = "
//     SELECT
//         u.id AS user_id,
//         u.name AS user_name,
//         u.room_no AS user_room_no,
//         u.ext AS user_ext,
//         o.id AS order_id,
//         o.date AS order_date,
//         o.status AS order_status,
//         o.total_price AS order_total_price,
//         oi.product_id AS product_id,
//         p.name AS product_name,
//         oi.quantity AS order_item_quantity
//     FROM
//         users u
//     LEFT JOIN
//         orders o ON u.id = o.user_id
//     LEFT JOIN
//         order_items oi ON o.id = oi.order_id
//     LEFT JOIN
//         products p ON oi.product_id = p.id
//     ORDER BY
//         u.id, o.date DESC, p.name;
// ";

// $stmtAllUsers = $this->conn->prepare($queryAllUsers);
// $stmtAllUsers->execute();
// $allUsersData = $stmtAllUsers->fetchAll(PDO::FETCH_ASSOC);
//       return $allUsersData;

//     } catch (PDOException $e) {
//         return -1;
//     }
// }


// public function getChecksById() {
//     $id = $_SESSION["id"];

//     try {

//         $querySpecificUser = "
//         SELECT
//             u.id AS user_id,
//             u.name AS user_name,
//             u.room_no AS user_room_no,
//             u.ext AS user_ext,
//             o.id AS order_id,
//             o.date AS order_date,
//             o.status AS order_status,
//             o.total_price AS order_total_price,
//             oi.product_id AS product_id,
//             p.name AS product_name,
//             oi.quantity AS order_item_quantity
//         FROM
//             users u
//         LEFT JOIN
//             orders o ON u.id = o.user_id
//         LEFT JOIN
//             order_items oi ON o.id = oi.order_id
//         LEFT JOIN
//             products p ON oi.product_id = p.id
//         WHERE
//             u.id = :user_id
//         ORDER BY
//             o.date DESC, p.name;
//     ";
    
//     $stmtSpecificUser = $db->prepare($querySpecificUser);
//     $stmtSpecificUser->bindParam(':user_id',  $id, PDO::PARAM_INT);
//     $stmtSpecificUser->execute();
//     $specificUserData = $stmtSpecificUser->fetchAll(PDO::FETCH_ASSOC);
//     return  $specificUserData;
//     } catch (PDOException $e) {
//         return -1;
//     }
// }






    

// public function getCHecks() {

//     try {
//         // Count total orders for pagination
//         $page=isset($_GET{'page'})?(int)$_GET['page']:1;
//         $perPage=3;

//         $start=($page>1) ? ($page * $perPage) - $perPage : 0;

//         $countQuery = "
//             select count(*) as total_orders
//             from orders where status = 'delivered';
//         ";

//         $stmt = $this->conn->prepare($countQuery);
//         $stmt->execute();
//         $result = $stmt->fetch(PDO::FETCH_ASSOC);
//         $this->total = $result['total_orders'];

//         // $query = "
//         //     select 
//         //         u.name as user_name,
//         //         o.id as order_id,
//         //         o.date as order_date,
//         //         o.status as order_status,
//         //         o.total_price as order_total_price,
//         //         o.note as order_note,
//         //         u.room_no as room_no,
//         //         u.ext as ext,
//         //         p.name as product_name,
//         //         p.price as product_price,
//         //         p.image as product_image,
//         //         oi.quantity as order_item_quantity
//         //     from 
//         //         users u
//         //     join 
//         //         orders o on u.id = o.user_id
//         //     join 
//         //         order_items oi on o.id = oi.order_id
//         //     join 
//         //         products p on oi.product_id = p.id
//         //     order by
//         //         o.date DESC
//         //         limit $start,$perPage
//         // ";
//         $query = "
//         select 
//             u.name as user_name,
//             o.id as order_id,
//             o.date as order_date,
//             o.status as order_status,
//             o.total_price as order_total_price,
//             o.note as order_note,
//             u.room_no as room_no,
//             u.ext as ext,
//             p.name as product_name,
//             p.price as product_price,
//             p.image as product_image,
//             oi.quantity as order_item_quantity
//         from 
//             (select id from orders order by date DESC limit $start, $perPage) as o_ids
//         join 
//             orders o on o.id = o_ids.id
//         join 
//             users u on u.id = o.user_id
//         join 
//             order_items oi on o.id = oi.order_id
//         join 
//             products p on oi.product_id = p.id
//             where o.status = 'delivered'
//         order by
//             o.date DESC
//     ";
    
//         $stmt = $this->conn->prepare($query);

//         $stmt->execute();

//         // $total=$this->conn->query("select FOUND_ROWS() as total")->fetch()['total'];
//         $pages = ceil($this->total / $perPage); 


//         if ($stmt->rowCount() > 0) {
//             // Group orders by order_id
//             $orders = [];
//             while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//                 $orders[$row['order_id']]['order_info'] = [
//                     'order_date' => $row['order_date'],
//                     'user_name' => $row['user_name'],
//                     'room_no' => $row['room_no'],
//                     'ext' => $row['ext'],
//                     'status' => $row['order_status'],
//                     'id' => $row['order_id'],
//                     'total_price' => $row['order_total_price']
//                 ];
//                 $orders[$row['order_id']]['items'][] = [
//                     'product_name' => $row['product_name'],
//                     'product_price' => $row['product_price'],
//                     'product_image' => $row['product_image'],
//                     'quantity' => $row['order_item_quantity']
//                 ];
//             }
// // echo "/////".count($orders) ."/////";
// // echo $start ."/////";
// // echo $perPage;
// echo "<div class='container  border shadow rounded p-2 mt-3'>";
// for($i=1; $i<=$pages; $i++) {
//     if ($i == $page) {
//         echo "<a class='btn btn-warning ms-2' href='?page=" . $i . "&per-page=" . $perPage . "'> " . $i . " </a>";
//     } else { 
//         echo "<a class='btn btn-primary ms-2' href='?page=" . $i . "&per-page=" . $perPage . "'> " . $i . " </a>";
//     } 
// }
// echo "</div>";
//             foreach ($orders as $order) {
//                 echo "
//                 <div class='container  border shadow rounded p-2 mt-3'>
//                 <table class='table'>

//                         <tr class='table-success'>
//                             <th>Order Date</th>
//                             <th>Name</th>
//                             <th>Room</th>
//                             <th>Ext.</th>
//                              <th>Status</th>
//                             <th>Action</th>
//                         </tr>
//                         <tr>
//                             <td>{$order['order_info']['order_date']}</td>
//                             <td>{$order['order_info']['user_name']}</td>
//                             <td>{$order['order_info']['room_no']}</td>
//                             <td>{$order['order_info']['ext']}</td>
//                             <td>{$order['order_info']['status']}</td>";
//                             if ($order['order_info']['status'] == 'delivered' || $order['order_info']['status'] == 'canceled'){


//                             echo "<td> <a class='btn btn-danger ' href='../includes/delete_order.php?id={$order['order_info']['id']} ' >Delete</a> </td>";
//                             }else{

//                                 echo "

//                             <td> <a class='btn btn-primary ' href='../includes/deliver.php?id={$order['order_info']['id']} ' >Deliver</a> </td>";
//                             }
                            
//                             echo "
//                         </tr>
//                     </table>";

//                 echo "<table class='table '>

//                         <tr class='table-success'>
//                             <th>Order Item</th>
//                             <th>Price</th>
//                             <th>Quantity</th>
//                         </tr>";
//                 foreach ($order['items'] as $item) {
//                     echo "<tr>
//                             <td><img src='{$item['product_image']}' alt='Product Image' width='50'> {$item['product_name']}</td>
//                             <td>{$item['product_price']} LE</td>
//                             <td>{$item['quantity']}</td>
//                         </tr>";
//                 }
//                 echo "</table>";

//                 echo "<div style='text-align: right; font-weight: bold; margin-top: 10px;'>Total:  {$order['order_info']['total_price']}
//                 <hr class='border-dark border-3 opacity-100'></div> 
//                 </div>  ";
//             }

          
//             echo "<br><br><br><br>";


//             } else {
//             echo "No orders found.";
//         }
//     } catch (PDOException $e) {
//         echo 'Connection failed: ' . $e->getMessage();
//     }
// }

    

public function getChecks() {
    try {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 3;
        $start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

        $countQuery = "
            SELECT COUNT(*) AS total_orders
            FROM orders
            WHERE status = 'delivered';
        ";

        $stmt = $this->conn->prepare($countQuery);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->total = $result['total_orders'];

        $query = "
        SELECT 
            u.name AS user_name,
            o.id AS order_id,
            o.date AS order_date,
            o.total_price AS order_total_price,
            o.note AS order_note,
            u.room_no AS room_no,
            u.ext AS ext,
            p.name AS product_name,
            p.price AS product_price,
            p.image AS product_image,
            oi.quantity AS order_item_quantity
        FROM 
            (SELECT id FROM orders ORDER BY date DESC LIMIT $start, $perPage) AS o_ids
        JOIN 
            orders o ON o.id = o_ids.id
        JOIN 
            users u ON u.id = o.user_id
        JOIN 
            order_items oi ON o.id = oi.order_id
        JOIN 
            products p ON oi.product_id = p.id
        WHERE 
            o.status = 'delivered'
        ORDER BY
            o.date DESC
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $pages = ceil($this->total / $perPage); 

        if ($stmt->rowCount() > 0) {
            $orders = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $orders[$row['order_id']]['order_info'] = [
                    'order_date' => $row['order_date'],
                    'user_name' => $row['user_name'],
                    'room_no' => $row['room_no'],
                    'ext' => $row['ext'],
                    'id' => $row['order_id'],
                    'total_price' => $row['order_total_price']
                ];
                $orders[$row['order_id']]['items'][] = [
                    'product_name' => $row['product_name'],
                    'product_price' => $row['product_price'],
                    'product_image' => $row['product_image'],
                    'quantity' => $row['order_item_quantity']
                ];
            }

            $stmt = $this->conn->prepare("SELECT * FROM users WHERE is_admin = 'FALSE'");
            $stmt->execute();
            
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo "<div class='container border shadow rounded p-2 mt-3'>";
            
            echo '
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    Choose User
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="user-list">
            ';
            
            foreach ($users as $user) {
                $userName = htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8');
                echo "<li><a class='dropdown-item user-bt' href='?id= {$user['id']}'>{$userName}</a></li>";
            }
            
            echo '
                </ul>
            </div>';
            

  
            echo "<div class='container border shadow rounded p-2 mt-3'>";
            for ($i = 1; $i <= $pages; $i++) {
                echo $i == $page ? 
                    "<a class='btn btn-warning ms-2' href='?page=" . $i . "&per-page=" . $perPage . "'> " . $i . " </a>" :
                    "<a class='btn btn-primary ms-2' href='?page=" . $i . "&per-page=" . $perPage . "'> " . $i . " </a>";
            }
            echo "</div>";


            foreach ($orders as $order) {
                echo "
                <div class='container border shadow rounded p-2 mt-3'>
                <table class='table table-striped'>
                        <tr class='table-dark'>
                         <th>Check for </th>
                            <th>Order Date</th>
                           
                            <th>Room</th>
                            <th>Ext.</th>
                            <th>Action</th>
                        </tr>
                        <tr>
                                                    <td>{$order['order_info']['user_name']}</td>

                            <td>{$order['order_info']['order_date']}</td>
                            <td>{$order['order_info']['room_no']}</td>
                            <td>{$order['order_info']['ext']}</td>
                            <td>
<a class='btn btn-info btn-sm' href='../includes/delete_order.php?id={$order['order_info']['id']}&earn=1'>Earn</a>
                            </td>
                        </tr>
                    </table>";

                echo "<table class='table table-bordered'>
                        <tr class='table-secondary'>
                            <th>Order Item</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Image</th>
                        </tr>";
                foreach ($order['items'] as $item) {
                    echo "<tr>
                            <td>{$item['product_name']}</td>
                            <td>{$item['product_price']} LE</td>
                            <td>{$item['quantity']}</td>
                            <td><img src='{$item['product_image']}' alt='Product Image' width='50'> </td>
                        </tr>";
                }
                echo "</table>";

                echo "<div style='text-align: right; font-weight: bold; margin-top: 10px; margin-right: 30px;'>Total: {$order['order_info']['total_price']} LE
                <hr class='border-dark border-3 opacity-100'></div>
                </div>";
            }

            echo "<br><br><br><br>";
        } else {
            echo "No orders found.";
        }
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
}

public function getChecksById() {
    try {
        $userId = isset($_GET['id']) ? (int)$_GET['id'] : null;

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 3;
        $start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

        $countQuery = "
            SELECT COUNT(*) AS total_orders
            FROM orders
            WHERE status = 'delivered'
        ";
        
        if ($userId) {
            $countQuery .= " AND user_id = :userId";
        }

        $stmt = $this->conn->prepare($countQuery);

        if ($userId) {
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        }

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->total = $result['total_orders'];

        $query = "
        SELECT 
            u.name AS user_name,
            o.id AS order_id,
            o.date AS order_date,
            o.total_price AS order_total_price,
            o.note AS order_note,
            u.room_no AS room_no,
            u.ext AS ext,
            p.name AS product_name,
            p.price AS product_price,
            p.image AS product_image,
            oi.quantity AS order_item_quantity
        FROM 
            (SELECT id FROM orders ORDER BY date DESC LIMIT $start, $perPage) AS o_ids
        JOIN 
            orders o ON o.id = o_ids.id
        JOIN 
            users u ON u.id = o.user_id
        JOIN 
            order_items oi ON o.id = oi.order_id
        JOIN 
            products p ON oi.product_id = p.id
        WHERE 
            o.status = 'delivered'
        ";

        if ($userId) {
            $query .= " AND o.user_id = :userId";
        }

        $query .= " ORDER BY o.date DESC";

        $stmt = $this->conn->prepare($query);

        if ($userId) {
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        }

        $stmt->execute();

        $pages = ceil($this->total / $perPage);

        if ($stmt->rowCount() > 0) {
            $orders = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $orders[$row['order_id']]['order_info'] = [
                    'order_date' => $row['order_date'],
                    'user_name' => $row['user_name'],
                    'room_no' => $row['room_no'],
                    'ext' => $row['ext'],
                    'id' => $row['order_id'],
                    'total_price' => $row['order_total_price']
                ];
                $orders[$row['order_id']]['items'][] = [
                    'product_name' => $row['product_name'],
                    'product_price' => $row['product_price'],
                    'product_image' => $row['product_image'],
                    'quantity' => $row['order_item_quantity']
                ];
            }

            $stmt = $this->conn->prepare("SELECT * FROM users WHERE is_admin = 'FALSE'");
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo "<div class='container border shadow rounded p-2 mt-3'>";

            echo '
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    Choose User
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="user-list">
            ';

            foreach ($users as $user) {
                $userName = htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8');
                $selected = ($userId == $user['id']) ? 'selected' : '';
                echo "<li><a class='dropdown-item user-bt' href='?id={$user['id']}'>{$userName}</a></li>";
            }

            echo '
                </ul>
            </div>';

            echo "<div class='container border shadow rounded p-2 mt-3'>";
            for ($i = 1; $i <= $pages; $i++) {
                echo $i == $page ? 
                    "<a class='btn btn-warning ms-2' href='?page=" . $i . "&per-page=" . $perPage . "&id=" . $userId . "'> " . $i . " </a>" :
                    "<a class='btn btn-primary ms-2' href='?page=" . $i . "&per-page=" . $perPage . "&id=" . $userId . "'> " . $i . " </a>";
            }
            echo "</div>";

            foreach ($orders as $order) {
                echo "
                <div class='container border shadow rounded p-2 mt-3'>
                <table class='table table-striped'>
                        <tr class='table-dark'>
                            <th>Check for</th>
                            <th>Order Date</th>
                            <th>Room</th>
                            <th>Ext.</th>
                            <th>Action</th>
                        </tr>
                        <tr>
                            <td>{$order['order_info']['user_name']}</td>
                            <td>{$order['order_info']['order_date']}</td>
                            <td>{$order['order_info']['room_no']}</td>
                            <td>{$order['order_info']['ext']}</td>
                            <td>
                                <a class='btn btn-info btn-sm' href='../includes/delete_order.php?id={$order['order_info']['id']}&earn=1'>Earn</a>
                            </td>
                        </tr>
                    </table>";

                echo "<table class='table table-bordered'>
                        <tr class='table-secondary'>
                            <th>Order Item</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Image</th>
                        </tr>";
                foreach ($order['items'] as $item) {
                    echo "<tr>
                            <td>{$item['product_name']}</td>
                            <td>{$item['product_price']} LE</td>
                            <td>{$item['quantity']}</td>
                            <td><img src='{$item['product_image']}' alt='Product Image' width='50'> </td>
                        </tr>";
                }
                echo "</table>";

                echo "<div style='text-align: right; font-weight: bold; margin-top: 10px; margin-right: 30px;'>Total: {$order['order_info']['total_price']} LE
                <hr class='border-dark border-3 opacity-100'></div>
                </div>";
            }

            echo "<br><br><br><br>";
        } else {
            // echo "No orders found.";
            echo "<div class='alert alert-warning text-center  mt-5' role='alert'>
    <h4><strong>No orders found for the selected user.</strong></h4>
</div>";
        }
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
}


}


