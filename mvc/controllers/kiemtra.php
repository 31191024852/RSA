<?php
    class kiemtra extends controller{
        function Show() {
            if(!isset($_SESSION['Id'])){
                header('Location: login');
            }else{
                $chukyso = $this->model('process');
                $chukyso ->my_verify();
                $this->view('kiemtra',[]);
            }
            
        }
    }