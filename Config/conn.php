<?php

class Connection
{
    public $conn; 
    private $serverName = "localhost";
    private $username = "postgres";
    private $password = "yasser";
    private $database = "youdemy";

    public function __construct()
    {
        try {
            $this->conn = new PDO("pgsql:host=$this->serverName;dbname=$this->database", $this->username, $this->password);

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } 
        catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function prepare($sql) {
        return $this->conn->prepare($sql);
    }

    public function lastInsertId() {
        return $this->conn->lastInsertId();
    }
}

$conn = new Connection();
