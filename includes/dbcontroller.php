<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);

class DbController {
    private $conn;


    public function __construct($db) {
        $this->conn = $db;
    }


    public function login($email,$password) {
        $query = "select * from users where email = :email";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row && password_verify($password, $row['password'])) {
            
            $_SESSION["is_admin"] = $row["is_admin"];
            $_SESSION["user_name"] = $row["name"];
            $_SESSION["image"] = $row["profile_pic"];

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
        
     
            if ($_POST["password"] !== $_POST["confirmPassword"]) {
                echo "Passwords do not match.";
            } else {
                 try{
                    $hashed_password = password_hash($_POST["password"], PASSWORD_DEFAULT);


        $query = "insert into users(name, email, password,room_no,ext,profile_pic,is_admin) values (?,?,?,?,?,?,?)";

        $stmt = $this->conn->prepare($query);
        
      $stmt->execute([$_POST['name'], $_POST['email'], $hashed_password,$_POST['room_no'],$_POST['ext'],$upload_dir.$_FILES['profile_pic']['name'],$_POST['is_admin']] ) ;

      echo"user added successfully";

    }    catch(Exception $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
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

        
        return ['users'=> $query , 'total'=>$total , 'perPage'=>$perPage];
                    
                        
                        }catch (PDOException $e) {
                        echo 'Connection failed: ' . $e->getMessage();
                        }
    }

public function get_user($id ){
    
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


public function update_user() {
    $id = $_GET['id'];

    if (isset($_FILES['profile_pic'])) {
        $upload_dir = '../uploads/users/';
        $filename = uniqid() . '_' . basename($_FILES['profile_pic']['name']);
        $profilePic = $upload_dir . $filename;
        move_uploaded_file($_FILES['profile_pic']['tmp_name'], $profilePic);
    } else {
        $profilePic = '';
    }

    $passwordRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';
    if (!preg_match($passwordRegex, $_POST["password"])) {
        echo "Password must be at least 8 characters and contain at least one lowercase letter, one uppercase letter, one number, and one special character.";
        return;
    }

    if ($_POST["password"] !== $_POST["confirmPassword"]) {
        echo "Passwords do not match.";
        return;
    }

    $hashed_password = password_hash($_POST["password"], PASSWORD_ARGON2ID);

    try {
        $query = "update users set name = ?, password = ?, room_no = ?, ext = ?, profile_pic = ?, is_admin = ? where id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$_POST['name'], $hashed_password, $_POST['room_no'], $_POST['ext'], $profilePic, $_POST['is_admin'], $id]);
        header("Location: get_users.php");
    } catch (PDOException $e) {
        echo 'Error updating user: ' . $e->getMessage();
    }
}

public function delete_user(){
    $id=$_GET['id'];
    try{
        $query="delete from users where id = $id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        header("Location: get_users.php");
    }catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        };
}



    }


?>