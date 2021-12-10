<?php
class logout extends controller{
    function Show(){
        $teo = $this->model("userModel");
        $teo->logout();
     }     
}
?>