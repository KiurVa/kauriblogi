<?php
class Db
{
    private $con; // Ühendus salvestatakse siin

    function __construct()
    {
        $this->con = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        if ($this->con->connect_errno) {
            echo "<strong>Viga andmebaasiga</strong> " . $this->con->connect_errno;
        } else {
            mysqli_set_charset($this->con, "utf8");
        }
    }

    # UPDATE, INSERT VÕI DELETE
    function dbQuery($sql)
    {
        if ($this->con) {
            $res = mysqli_query($this->con, $sql);
            if ($res === false) {
                echo "<div>Vigane päring: " . htmlspecialchars($sql) . "</div>";
                return false;
            }
            return $res; // Tagastab objekti
        }
        return false;
    }

    # SELECT sql lause jaoks
    function dbGetArray($sql)
    {
        $res = $this->dbQuery($sql);
        if ($res !== false) {
            $data = array(); // Tühja massiivi loomine
            while ($row = mysqli_fetch_assoc($res)) {
                $data[] = $row; //Lisa uude massiivi
            }
            return (!empty($data)) ? $data : false; //Kui data pole tühi tagasta data
        }
        return false;
    }

    #$_POST (vormi andmed) / $_GET (URL andmed) väärtuse tagastamine
    # ?string saab olla post, get ja null
    function getVar(string $name, ?string $method = null)
    {
        if ($method === 'post') {
            return $_POST[$name] ?? null;
        } elseif ($method === 'get') {
            return $_GET[$name] ?? null;
        } else {
            return $_POST[$name] ?? $_GET[$name] ?? null;
        }
    }

    #Sisendi turvalisemaks muutmine
    function dbFix($var)
    {
        if (!$this->con || !($this->con instanceof mysqli)) { // || või/or
            return 'NULL';
        }
        if (is_null($var)) {
            return 'NULL';
        } elseif (is_bool($var)) {
            return $var ? '1' : '0'; // ? kui on tõene ja : kui on väär
        } elseif (is_numeric($var)) {
            return $var;
        } else {
            return $this->con->real_escape_string($var);
        }
    }

    #Inimlikul kujul massiivi sisu vaatamine
    function show($array)
    {
        echo "<pre>";
        print_r($array);
        echo "</pre>";
    }
    /**
     * Tagastab valmis HTML value atribuudi, näiteks: value="Andres"
     * @param string $name  - massiivi võti (vormi välja nimi) näiteks: heading või context
     * @param array $source - massiiv kust väärtus võtta
     * @return string       - valmis value="....." või tühi string
     */
    function htmlValue(string $name, array $source): string {
        if(isset($source[$name])) {
            return 'value="'.htmlspecialchars($source[$name], ENT_QUOTES).'"';
        }
        return '';
    }

    function htmlTextContent(string $name, array $source): string {
        return isset($source[$name]) ? htmlspecialchars($source[$name], ENT_QUOTES) : "";
    }

} // class Db lõpp