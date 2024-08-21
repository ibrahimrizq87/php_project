
<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../includes/database.php';
require_once '../includes/dbcontroller.php';

if (!isset($_SESSION["user_name"])){
    header("Location: login.php");
    exit();
} else if ($_SESSION["is_admin"] == 'TRUE'){
    require_once '../includes/header.php';
}else{

    // here we want to implement a page that says this page is for admins only
    header("Location: home.php");
}
?>




<div class="container p-5 border rounded"> <div class="container  mb-3"> 
<a href="add_user.php" class="btn btn-info">Add New User</a>
</div>
<?php


$database = new Database();
$db = $database->getConnection();

$controller = new DbController($db);
$data = $controller->get_users();

$users = $data['users'];
$total = $data['total'];
$perPage = $data['perPage'];
$pages=ceil($total/$perPage);
        echo'<table  class="table">
                <tr>
                
                <th>
                    id
                    </th>
                    <th>
                                name
                    </th>

                    <th>
                    Email
                    </th>

                    <th>
                    room_no
                    </th>
                    
                    
                    <th>
                    ext
                    </th>
                    
                    
                    <th>
                    profile picture
                    </th>
                    
                    
                    <th>
                    actions
                    </th>

                </tr>';
                        foreach($users as$q)
                        {  $id=$q['id'];
                            echo '<tr>
                            <td>'.$id.'</td>
                            <td>'.$q['name'].'</td>
                            <td>'.$q['email'].'</td>
                            <td>'.$q['room_no'].'</td>
                            <td>'.$q['ext'].'</td>';
                            echo '<td><img width=70px src="';
                            echo $q['profile_pic'];
                            echo '">'.'</td>';
                            echo ' <td>
                            <a class="btn btn-primary" href="edit.php?id='; echo $id; echo '" >Edit</a>
                            <a class="btn btn-danger" href="delete.php?id='; echo $id; echo'">Delete</a>
                    
                        </tr>';
                    
                        }
                        echo'</table>
                        <div class="pagination">';?>
                        <?php for($i=1;$i<=$pages;$i++):?> 
                        <a class='btn btn-primary me-3'href='?page=<?php echo $i ?>&per-page=<?php echo $perPage?>'> <?php echo $i?> </a>
                        <?php endfor?>
                    </div>

                   

<?php
 echo'</table>
 </div>';
include_once('../includes/footer.php');
?>