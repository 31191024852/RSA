<?php
    class chukyso extends controller{
        function Show() {
            if(!isset($_SESSION['Id'])){
                header('Location: login');
            }else{
                $chukyso = $this->model('process');
                $this->view('chukyso',[]);
            }
            
        }
    }