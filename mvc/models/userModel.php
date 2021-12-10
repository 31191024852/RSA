<?php
    require_once './mvc/models/createkey.php';
    class userModel extends db{

        function login(){
            if (isset($_SESSION['Id'])) {
                header("Location: ".BASE_URL."/home");
            }
            if (isset($_POST['login'])) {
                $email = $_POST['email'];
                $password = md5($_POST['password']);
    
                $sql = "SELECT * FROM `tbl_users` WHERE `Email`='$email' AND `Password`='$password'";
                $result = mysqli_query($this->con, $sql);
                if ($result->num_rows > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $_SESSION['Id'] = $row['Id'];
                    $_SESSION['Password'] = ($row['Password']);
                    header("Location: ".BASE_URL."/home");
                } else {
                    echo "<script>alert('Email or Password is Wrong.')</script>";
                }
            }
            
        }

        function logout(){
            $files = glob('uploads/*');
            foreach($files as $file){ 
                if(is_file($file)) {
                    unlink($file); 
                }
            }
            session_destroy();
            header("Location: " . BASE_URL . "/login");
        }

        function register(){
            if(isset($_POST['register'])){ 
                $email = $_POST['email'];
                $password = md5($_POST['password']);
                $re_password= md5($_POST['re_password']);
                $fullname = $_POST['fullname'];
                $cccd = $_POST['cccd'];
                $createkey = new createKey();
                if($re_password==$password){
                    $sql = "SELECT * FROM `tbl_users` WHERE `Email`=$email";
                    $result = mysqli_query($this->con,$sql);
                    if (is_bool($result)) {
                        $key = $createkey->createKey($cccd);
                        $qr = "INSERT INTO `tbl_users` VALUES (NULL,'$fullname','$email','$password','".$key['privatekey']."','".$key['publickey']."','".$key['crt']."');";
                        echo $qr;
                        $add = mysqli_query($this->con,$qr);
                        if($add){
                            header("Location: " . BASE_URL . "/login&kq=done");
                        }else{
                            echo "<script>alert('Dang ky that bai.')</script>";
                        }
                    }else{
                        echo "<script>alert('Email Already Exists.')</script>";
                    }
                }else{
                    echo "<script>alert('Password Not Matched.')</script>";
                }

            }
        }

        function getprofile($id){
            $qr = "SELECT * FROM `tbl_users` WHERE `Id`= $id";
            $result = mysqli_query($this->con, $qr);
            if(is_bool($result)){
                echo "<script>alert('You aren't login.')</script>";
            }else{
                $data = mysqli_fetch_assoc($result);
                return $data;
            }
        }
    }