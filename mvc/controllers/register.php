<?php
    class register extends controller{
        function Show() {
            $login = $this->model('userModel');
            $login->register();
            $this->view('register',[]);
        }
    }