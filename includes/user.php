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

            return true;
            // $_SESSION["is_loged"] =true;

            // header("Location: ../index.php ");
            
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

    }


?>