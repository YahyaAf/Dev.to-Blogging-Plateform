<?php
namespace config;

use PDO; 

class Database {
    private $host = "localhost";
    private $db_name;
    private $username = "root";
    private $password = "";
    public $conn;

    public function __construct($db_name){
        $this->db_name = $db_name;
    }

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
