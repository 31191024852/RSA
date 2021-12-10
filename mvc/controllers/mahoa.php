<?php
    class mahoa extends controller{
        function Show() {
            if(!isset($_SESSION['Id'])){
                header('Location: login');
            }else{
                $mahoa = $this->model('process');
                $mahoa->my_encrypt();             
                $this->view('mahoa',[]);
            }
            
        }
    }