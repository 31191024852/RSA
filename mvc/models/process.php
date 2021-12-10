<?php

    class process extends db{

        function my_decrypt() {
            if(isset($_POST['upload'])){
                // Kiểm tra dữ liệu fileupload trong $_FILES
                if (!isset($_FILES["file"])){
                    echo "<script> alert('Dữ liệu không đúng cấu trúc')</script>";
                    die;
                }
                if ($_FILES["file"]['error'] != 0){
                    echo "<script> alert('Dữ liệu bị lỗi')</script>";
                    die;
                }
                //Get name
                $filename = $_FILES['file']['name'];
                $name  = explode('.', $filename);
                while(true){
                    $filename = str_replace('.','',uniqid($name[0], true));
                    if (!file_exists(sys_get_temp_dir() . ($filename.'.'.$name[1]))) break;
                }
                $_FILES['file']['name'] = $filename.'.'.$name[1];
                $target_name = $_FILES["file"]["name"];
 
                //Thư mục bạn sẽ lưu file upload
                $target_dir    = "uploads/";
                $target_file   = $target_dir .$target_name;

               
                $allowUpload   = true;
                $FileType = pathinfo($target_file,PATHINFO_EXTENSION);
                $maxfilesize   = 800000;
                ////Những loại file được phép upload
                $allowtypes    = array('txt');
                // Kiểm tra kích thước file upload cho vượt quá giới hạn cho phép
                if ($_FILES["file"]["size"] > $maxfilesize){
                    echo "Không được upload file lớn hơn $maxfilesize (bytes).";
                    $allowUpload = false;
                }
                // Kiểm tra kiểu file
                if (!in_array($FileType,$allowtypes )){
                    echo "Chỉ được upload các định dạng TXT";
                    $allowUpload = false;
                }


                if ($allowUpload){
                    // Xử lý di chuyển file tạm ra thư mục cần lưu trữ, dùng hàm move_uploaded_file
                    move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);

                    //Giải mã
                    $qr = 'SELECT * FROM `tbl_users` WHERE `ID`='.$_SESSION['Id'];
                    $result = mysqli_query($this->con,$qr);
                    $temp = mysqli_fetch_assoc($result);
                    $private_key = file_get_contents('key/private/'.$temp['Private'].'.pem');
                    $data = file_get_contents($target_file);

                    $data_bf = base64_decode($data);
                    if(openssl_private_decrypt($data_bf, $data, $private_key)){
                        file_put_contents($target_file,$data);
                        $_SESSION['dow']= $target_name;
                        $_SESSION['verify'] = 'Tệp đã được giải mã';
                        header('Location: '.BASE_URL.'/download');
                    }else{
                        echo "<script> alert('Đây không phải file của bạn')</script>";
                    }
                    

                    

                }
                else{
                    echo "<script> alert('Không upload được file, có thể do file lớn, kiểu file không đúng ...')</script>";
                }
            }
        }

        function my_encrypt() {
            if(isset($_POST['uploadkey'])){

                if (!isset($_FILES["file"])){
                    echo "<script> alert('Dữ liệu không đúng cấu trúc')</script>";
                    die;
                }
                if ($_FILES["file"]['error'] != 0){
                    echo "<script> alert('Dữ liệu bị lỗi')</script>";
                    die;
                }
                $filename = $_FILES["file"]['name'];
                $name  = explode('.', $filename);
                while (true){
                    $filename = str_replace('.','',uniqid($name[0], true));
                    if (!file_exists(sys_get_temp_dir() . ($filename.'.'.$name[1]))) break;
                }
                $_FILES["file"]['name'] = $filename.'.'.$name[1];
                $target_name = $_FILES["file"]["name"];
                $target_dir    = "uploads/";
                $target_file   = $target_dir . $target_name ;
                $allowUpload   = true;
                $FileType = pathinfo($target_file,PATHINFO_EXTENSION);
                $maxfilesize   = 800000;
                $allowtypes    = array('txt');
                if ($_FILES["file"]["size"] > $maxfilesize){
                    echo "Không được upload file lớn hơn $maxfilesize (bytes).";
                    $allowUpload = false;
                }
                if (!in_array($FileType,$allowtypes )){
                    echo "Chỉ được upload các định dạng TXT";
                    $allowUpload = false;
                }
                if ($allowUpload){
                    move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
                    $public_key = $_POST['key'];
                    echo $public_key;
                    $qr = 'SELECT * FROM `tbl_users` WHERE `Public`="'.$public_key.'";';
                    $result = mysqli_query($this->con,$qr);
                    if(!$result->num_rows>0){
                        echo "<script> alert('Key không tồn tại. Vui long nhập lại')</script>";
                    }else{
                        $key = file_get_contents('key/public/'.$public_key.'.pem');
                        echo $key;
                        $data = file_get_contents($target_file);
                        
                        openssl_public_encrypt($data, $data_bf, $key);
                        $data = base64_encode($data_bf);
                        
                        file_put_contents($target_file,$data);
                        $_SESSION['dow']= $target_name;
                        $_SESSION['verify'] = 'Tệp đã được mã hóa';
                        header('Location: '.BASE_URL.'/download');
                    }

                }
                else{
                    echo "<script> alert('Không upload được file, có thể do file lớn, kiểu file không đúng ...')</script>";
                }
            }
        }

        function my_sign(){
            if(isset($_POST['upload'])){

                if (!isset($_FILES["file"])){
                    echo "<script> alert('Dữ liệu không đúng cấu trúc')</script>";
                    die;
                }
                if ($_FILES["file"]['error'] != 0){
                    echo "<script> alert('Dữ liệu bị lỗi')</script>";
                    die;
                }
                $filename = $_FILES["file"]['name'];
                $name  = explode('.', $filename);
                while (true){
                    $filename = str_replace('.','',uniqid($name[0], true));
                    if (!file_exists(sys_get_temp_dir() . ($filename.'.'.$name[1]))) break;
                }
                $_FILES["file"]['name'] = $filename.'.'.$name[1];
                $target_name = $_FILES["file"]["name"];
                $target_dir    = "uploads/";
                $target_file   = $target_dir . $target_name ;
                $allowUpload   = true;
                $FileType = pathinfo($target_file,PATHINFO_EXTENSION);
                $maxfilesize   = 800000;
                $allowtypes    = array('txt');
                if ($_FILES["file"]["size"] > $maxfilesize){
                    echo "Không được upload file lớn hơn $maxfilesize (bytes).";
                    $allowUpload = false;
                }
                if (!in_array($FileType,$allowtypes )){
                    echo "Chỉ được upload các định dạng TXT";
                    $allowUpload = false;
                }


                if ($allowUpload){
                    move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);   
                    
                    //Ký tên
                    $qr = 'SELECT * FROM `tbl_users` WHERE `ID`='.$_SESSION['Id'];
                    $result = mysqli_query($this->con,$qr);
                    $temp = mysqli_fetch_assoc($result);
                    $private_key = file_get_contents('key/private/'.$temp['Private'].'.pem');
                    $sign = new process();
                    $data = file_get_contents($target_file);
                    $data_end = $sign->sign($data,$private_key); 
                    $data = base64_encode($data_end);
                    file_put_contents($target_file,$data);
                    $_SESSION['dow']= $target_name;
                    $_SESSION['verify'] = 'Tệp đã được Kí tên của bạn';
                    header('Location: '.BASE_URL.'/download');
                }else{
                    echo "<script> alert('Không upload được file, có thể do file lớn, kiểu file không đúng ...')</script>";
                }
            }
        }
        
        function sign($cleartext,$private_key){

            $msg_hash = md5($cleartext);
            openssl_private_encrypt($msg_hash, $sig, $private_key);
            $signed_data = $cleartext . "----SIGNATURE:----" . $sig;

            return $signed_data;
        }

        function my_verify(){
            if(isset($_POST['uploadkey'])){
                // Kiểm tra có dữ liệu fileupload trong $_FILES không
                // Nếu không có thì dừng
                if (!isset($_FILES["file"])){
                    echo "<script> alert('Dữ liệu không đúng cấu trúc')</script>";
                    die;
                }

                // Kiểm tra dữ liệu có bị lỗi không
                if ($_FILES["file"]['error'] != 0){
                    echo "<script> alert('Dữ liệu bị lỗi')</script>";
                    die;
                }

                // Đã có dữ liệu upload, thực hiện xử lý file upload
                //Get name
                $filename = $_FILES["file"]['name'];
                $name  = explode('.', $filename);
                
                while (true){
                    $filename = str_replace('.','',uniqid($name[0], true));
                    if (!file_exists(sys_get_temp_dir() . ($filename.'.'.$name[1]))) break;
                }
                $_FILES["file"]['name'] = $filename.'.'.$name[1];

                $target_name = $_FILES["file"]["name"];
                //Thư mục bạn sẽ lưu file upload
                $target_dir    = "uploads/";
                //Vị trí file lưu tạm trong server (file sẽ lưu trong uploads, với tên giống tên ban đầu)
                $target_file   = $target_dir . $target_name ;

                $allowUpload   = true;

                //Lấy phần mở rộng của file (jpg, png, ...)
                $FileType = pathinfo($target_file,PATHINFO_EXTENSION);

                // Cỡ lớn nhất được upload (bytes)
                $maxfilesize   = 800000;

                ////Những loại file được phép upload
                $allowtypes    = array('txt');

                
                // Kiểm tra kích thước file upload cho vượt quá giới hạn cho phép
                if ($_FILES["file"]["size"] > $maxfilesize){
                    echo "Không được upload file lớn hơn $maxfilesize (bytes).";
                    $allowUpload = false;
                }


                // Kiểm tra kiểu file
                if (!in_array($FileType,$allowtypes )){
                    echo "Chỉ được upload các định dạng TXT";
                    $allowUpload = false;
                }


                if ($allowUpload){
                    // Xử lý di chuyển file tạm ra thư mục cần lưu trữ, dùng hàm move_uploaded_file
                    move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);

                    // Kiểm tra
                    $public_key = $_POST['key'];
                    
                    $qr = 'SELECT `HoTen` FROM `tbl_users` WHERE `Public`="'.$public_key.'";';
                    $result = mysqli_query($this->con,$qr);
                    $data = file_get_contents($target_file);
                    $data_bf = base64_decode($data);
                    if(!is_bool($result)){
                        $name = mysqli_fetch_assoc($result)['HoTen'];
                        $key = file_get_contents(SSS.'/key/public/'.$public_key.'.pem');
                        
                            $verify = new process(); 

                            $data_end = $verify->verify($data_bf, $key);
                            if($data_end!=null){
                                file_put_contents($target_file,$data_end.$name);
                                $_SESSION['dow']= $target_name;
                                $_SESSION['verify'] = 'Chữ kí này đã được xác nhận và chủ nhân là '.$name;
                                header('Location: '.BASE_URL.'/download');
                            }else{
                                echo "<script> alert('Chữ ký không chính xác')</script>";
                            } 
                         
                    }else{
                        echo "<script> alert('Key không tồn tại. Vui lòng nhập lại')</script>";  
                    }
                }else{
                    echo "<script> alert('Không upload được file, có thể do file lớn, kiểu file không đúng ...')</script>";
                }
            }        
        }
        
        function verify($data,$public_key){
            $redata = explode("----SIGNATURE:----", $data);
            openssl_public_decrypt($redata[1], $decrypted_sig, $public_key);
            $data_hash = md5($redata[0]);
            if($decrypted_sig == $data_hash && strlen($data_hash)>0)
                return $redata[0].'----SIGNATURE:----';
            else
                return null;
        }
    }

    


