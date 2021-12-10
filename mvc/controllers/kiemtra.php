<?php
    class kiemtra extends controller{
        function Show() {
            if(!isset($_SESSION['Id'])){
                header('Location: login');
            }else{
                $chukyso = $this->model('process');
                $this->view('kiemtra',[]);
            }
            
        }
    }