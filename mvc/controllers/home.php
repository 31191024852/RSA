<?php
    class home extends controller{
        function Show() {
            $home = $this->model('homeModel');
            $this->view('home',[]);
        }
    }