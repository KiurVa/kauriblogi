<?php
class Db {
    private $con; // Ühendus salvestatakse siin

    function __construct(){
        $this->con = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        if($this->con->connect_errno) {
            echo "<strong>Viga andmebaasiga</strong> ".$this->con->connect_errno;
        } else {
            mysqli_set_charset($this->con, "utf8");
        }
    } 
}