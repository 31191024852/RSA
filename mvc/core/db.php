<?php

class db{

    public $con;
    protected $servername = "localhost";
    protected $username = "root";
    protected $password = "";
    protected $dbname = "rsa";

    function __construct(){
        $this->con = mysqli_connect($this->servername, $this->username, $this->password);
        mysqli_select_db($this->con, $this->dbname);
        mysqli_query($this->con, "SET NAMES 'utf8'");
    }

    function freeSystem($conn,$data){
        if($data==false||$data==true){
            mysqli_close($conn);
        }else{
            mysqli_free_result($data);
            mysqli_close($conn);
        }
        
    }

}

?>