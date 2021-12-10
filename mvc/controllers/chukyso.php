<?php
    class chukyso extends controller{
        function Show() {
            if(!isset($_SESSION['Id'])){
                header('Location: login');
            }else{
                $chukyso = $this->model('process');
                $chukyso ->my_sign();
                $this->view('chukyso',[]);
            }
            
        }
    }