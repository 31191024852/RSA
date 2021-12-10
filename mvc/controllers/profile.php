<?php
    class profile extends controller{
        function Show(){
            if(!isset($_SESSION['Id'])){
                header('Location:   login');
            }else{
                $profile = $this->model('userModel');
                $data=$profile -> getProfile($_SESSION['Id']);
                $this ->view('profile',['pro'=>$data]);
            }
            
        }
    }