<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);

class User {
    private $conn;

    public $name;
    public $email;
    public $password;
    public $room_no;
    public $ext;
    public $profile_pic;
    public $is_admin;

    public function __construct($db) {
        $this->conn = $db;
    }


    public function login() {
        $query = "select * from users where email = :email";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row && password_verify($this->password, $row['password'])) {
            
            $_SESSION["is_admin"] = $row["is_admin"];
            $_SESSION["user_name"] = $row["name"];
            $_SESSION["image"] = $row["profile_pic"];
            $_SESSION["id"] = $row["id"];


            return true;
            
        }
        return false;
    }


 public function add_user() {


        if (isset($_FILES['profile_pic'])) {
            $upload_dir = '../uploads/users/';
            $profilePic = $upload_dir . basename($_FILES['profile_pic']['name']);
            move_uploaded_file($_FILES['profile_pic']['tmp_name'], $profilePic);
        } else {
            $profilePic = '';
        }
        
     
        
                 try{
                    $hashed_password = password_hash($_POST["password"], PASSWORD_DEFAULT);


        $query = "insert into users(name, email, password,room_no,ext,profile_pic,is_admin) values (?,?,?,?,?,?,?)";

        $stmt = $this->conn->prepare($query);
        
      $stmt->execute([$_POST['name'], $_POST['email'], $hashed_password,$_POST['room_no'],$_POST['ext'],$upload_dir.$_FILES['profile_pic']['name'],$_POST['is_admin']] ) ;

      return 'done';

    }    catch(Exception $e) {
        return  'Connection failed: ' . $e->getMessage();

    }

    }  



    public function get_users(){
        try{

            $db=new PDO('mysql:dbname=cafeteria;host=localhost','main_user','php2024');

        $page=isset($_GET{'page'})?(int)$_GET['page']:1;
        $perPage=isset($_GET{'per-page'})?(int)$_GET['per-page']:5;

        $start=($page>1) ? ($page * $perPage) - $perPage : 0;


        $query=$db->prepare("select SQL_CALC_FOUND_ROWS * from users limit $start,$perPage
        ");
        $query->execute();
        $query = $query->fetchAll(PDO::FETCH_ASSOC);

        $total=$db->query("select FOUND_ROWS() as total")->fetch()['total'];
        $pages=ceil($total/$perPage);

        echo'<table  class="table">
                <tr>
                <th>
                    id
                    </th><th>
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
                        foreach($query as$q)
                        {  $id=$q['id'];
                            echo '<tr>
                            <td>'.$id.'</td>
                            <td>'.$q['name'].'</td>
                            <td>'.$q['email'].'</td>
                            <td>'.$q['room_no'].'</td>
                            <td>'.$q['ext'].'</td>';
                            echo '<td><img width=70px src="../uploads/users/';
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
                        <a class='btn btn-primary 'href='?page=<?php echo $i ?>&per-page=<?php echo $perPage?>'> <?php echo $i?> </a>
                        <?php endfor?>
                    </div>

                    <?php
                 
                        echo'</table>';
                        }catch (PDOException $e) {
                        echo 'Connection failed: ' . $e->getMessage();
                        }
    }


public function get_user(){
    $id = $_GET['id'];
    try {
        $sql = 'SELECT * FROM users WHERE id = :id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            throw new Exception('User not found');
        }

        return $user;
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}


public function update_user_with_image() {
    $id = $_GET['id'];
    if (isset($_FILES['profile_pic'])) {
        $upload_dir = '../uploads/users/';
        $filename = uniqid() . '_' . basename($_FILES['profile_pic']['name']);
        $profilePic = $upload_dir . $filename;
        move_uploaded_file($_FILES['profile_pic']['tmp_name'], $profilePic);
    } else {
        $profilePic = '';
    }


    $hashed_password = password_hash($_POST["password"], PASSWORD_ARGON2ID);

    try {
        $query = "update users set name = ?, password = ?, room_no = ?, ext = ?, profile_pic = ?, is_admin = ? where id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$_POST['name'], $hashed_password, $_POST['room_no'], $_POST['ext'], $profilePic, $_POST['is_admin'], $id]);
return 'done';
    } catch (PDOException $e) {
        return 'Error updating user: ' . $e->getMessage();
    }
}

public function update_user() {
    $id = $_GET['id'];


    $hashed_password = password_hash($_POST["password"], PASSWORD_ARGON2ID);

    try {
        $query = "update users set name = ?, password = ?, room_no = ?, ext = ?,  is_admin = ? where id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$_POST['name'], $hashed_password, $_POST['room_no'], $_POST['ext'],  $_POST['is_admin'], $id]);
return 'done';
    } catch (PDOException $e) {
        return 'Error updating user: ' . $e->getMessage();
    }
}


public function delete_user(){
    $id=$_GET['id'];
    try{
        $query="delete from users where id = $id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        header("Location: view_users.php");
    }catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        };
}

}

?>