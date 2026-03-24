<?php
class Database {
    private $host = getenv('DB_HOST');
    private $user = getenv('DB_USER');
    private $pass = getenv('DB_PASS');
    private $dbname = getenv('DB_NAME');
    public $conn;

    public function __construct() {
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname}",
                $this->user,
                $this->pass
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Database Connection Failed: " . $e->getMessage());
        }
    }
}
?>
