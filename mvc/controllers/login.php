<?php
    class login extends controller{
        function Show() {
            $login = $this->model('userModel');
            $login->login();
            $this->view('login',[]);
        }
    }