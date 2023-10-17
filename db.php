<?php

class DB {
    //public $ms;
    public function __construct($host, $user, $pass, $db)
    {
        $ms = mysqli_connect($host, $user, $pass, $db);
        $this->ms = $ms;
        return $ms;
    }
    public function __destruct()
    {
        $this->ms->close();
    }
    public function query($query) {

        return mysqli_query ($this->ms, $query);
    }

    public function insert($query) {
        try {
            return mysqli_query($this->ms,$query);
        } catch(Exception $e) {
            echo $e;
            return false;
        }

    }
}
