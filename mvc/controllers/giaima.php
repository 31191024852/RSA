<?php
    class giaima extends controller{
        function Show() {
            if(!isset($_SESSION['Id'])){
                header('Location: login');
            }else{
                $giaima = $this->model('process');
                $giaima->my_decrypt();
                $this->view('giaima',[]);
            }
            
        }
    }