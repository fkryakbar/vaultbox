<?php

class Database
{
    public $db;
    public function __construct($hostname, $username, $password, $database)
    {
        $db = mysqli_connect($hostname, $username, $password, $database);
        if (!$db) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $this->db = $db;
        return $db;
    }

    public function query($query)
    {
        $query = $query;
        $data = mysqli_query($this->db, $query);
        return $data;
    }
}
