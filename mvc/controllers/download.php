<?php

    class download extends controller{
        function Show(){
            if(!isset($_SESSION['Id'])){
                header('Location: login');
            }else{
                //xử lí down
                if(isset($_REQUEST["file"])){
                    // Get parameters
                    $file = urldecode($_REQUEST["file"]); // Decode URL-encoded string
                    $filepath = "uploads/" . $file;
                    // Process download
                    if(file_exists($filepath)) {
                        header('Content-Description: File Transfer');
                        header('Content-Type: application/octet-stream');
                        header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
                        header('Expires: 0');
                        header('Cache-Control: must-revalidate');
                        header('Pragma: public');
                        header('Content-Length: ' . filesize($filepath));
                        flush(); // Flush system output buffer
                        readfile(BASE_URL.'/'.$filepath);
                        exit;
                    }
                }
                $dow = isset($_SESSION['dow'])? $_SESSION['dow']:NULL;
                $ver = isset($_SESSION['verify'])? $_SESSION['verify']:NULL;
                $this->view('download',['dow'=>$dow,'ver'=>$ver]);
            }
            
        }
    }

?>