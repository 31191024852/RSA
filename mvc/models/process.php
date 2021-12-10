<?php

    class process extends db{

        function my_decrypt() {
            if(isset($_POST['upload'])){
                
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
                //Vị trí file lưu tạm trong server (file sẽ lưu trong uploads, với tên giống tên ban đầu)
                $target_file   = $target_dir . basename($_FILES["file"]["name"]);

               
                $allowUpload   = true;

                //Lấy phần mở rộng của file (jpg, png, ...)
                $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

                // Cỡ lớn nhất được upload (bytes)
                $maxfilesize   = 800000;

                ////Những loại file được phép upload
                $allowtypes    = array('docx', 'txt');

                
                // Kiểm tra kích thước file upload cho vượt quá giới hạn cho phép
                if ($_FILES["file"]["size"] > $maxfilesize){
                    echo "Không được upload ảnh lớn hơn $maxfilesize (bytes).";
                    $allowUpload = false;
                }


                // Kiểm tra kiểu file
                if (!in_array($imageFileType,$allowtypes )){
                    echo "Chỉ được upload các định dạng JPG, PNG, JPEG, GIF";
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
                $filename = $_FILES['file']['name'];
                $name  = explode('.', $filename);
                while (true){
                    $filename = str_replace('.','',uniqid($name[0], true));
                    if (!file_exists(sys_get_temp_dir() . ($filename.'.'.$name[1]))) break;
                }
                $_FILES['file']['name'] = $filename.'.'.$name[1];

                $target_name = $_FILES["file"]["name"];
                //Thư mục bạn sẽ lưu file upload
                $target_dir    = "uploads/";
                //Vị trí file lưu tạm trong server (file sẽ lưu trong uploads, với tên giống tên ban đầu)
                $target_file   = $target_dir . basename($_FILES["file"]["name"]);

                

                $allowUpload   = true;

                //Lấy phần mở rộng của file (jpg, png, ...)
                $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

                // Cỡ lớn nhất được upload (bytes)
                $maxfilesize   = 800000;

                ////Những loại file được phép upload
                $allowtypes    = array('docx', 'txt');

                
                // Kiểm tra kích thước file upload cho vượt quá giới hạn cho phép
                if ($_FILES["file"]["size"] > $maxfilesize){
                    echo "Không được upload ảnh lớn hơn $maxfilesize (bytes).";
                    $allowUpload = false;
                }


                // Kiểm tra kiểu file
                if (!in_array($imageFileType,$allowtypes )){
                    echo "Chỉ được upload các định dạng DOCX, TXT";
                    $allowUpload = false;
                }


                if ($allowUpload){
                    // Xử lý di chuyển file tạm ra thư mục cần lưu trữ, dùng hàm move_uploaded_file
                    move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);

                    //Mã hóa
                    // $qr = 'SELECT * FROM `tbl_users` WHERE `ID`='.$_SESSION['Id'];
                    // $result = mysqli_query($this->con,$qr);
                    // $temp = mysqli_fetch_assoc($result);
                    // $private_key = file_get_contents('key/private/'.$temp['Private'].'.pem');
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

                        header('Location: '.BASE_URL.'/download');
                    }

                }
                else{
                    echo "<script> alert('Không upload được file, có thể do file lớn, kiểu file không đúng ...')</script>";
                }
            
                
            
            
            
            
            
            }
        }
    }

    


