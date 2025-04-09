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

    # UPDATE, INSERT VÕI DELETE
    function dbQuery($sql) {
        if($this->con) {
            $res = mysqli_query($this->con, $sql);
            if($res === false) {
                echo "<div>Vigane päring: " .htmlspecialchars($sql). "</div>";
                return false;
            }
            return $res; // Tagastab objekti
        }
        return false;
    }

    # SELECT sql lause jaoks
    function dbGetArray($sql) {
        $res = $this->dbQuery($sql);
        if($res !== false) {
            $data = array(); // Tühja massiivi loomine
            while($row = mysqli_fetch_assoc($res)) {
                $data[] = $row; //Lisa uude massiivi
            }
            return (!empty($data)) ? $data : false; //Kui data pole tühi tagasta data
        }
        return false;
    }

    #$_POST (vormi andmed) / $_GET (URL andmed) väärtuse tagastamine
    function() {
        
    }

} // class Db lõpp