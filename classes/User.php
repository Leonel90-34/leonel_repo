<?php
require_once 'Database.php';

class User {
    public $db;

    public function __construct(){
        $this->db = new Database();
    }

    // Register or Add User with hashed password
    public function addUser($data){
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

        $stmt = $this->db->conn->prepare("INSERT INTO users (name, username, password, role) 
                                          VALUES (:name, :username, :password, :role)");
        return $stmt->execute([
            ':name' => $data['name'],
            ':username' => $data['username'],
            ':password' => $hashedPassword,
            ':role' => $data['role']
        ]);
    }

    // Login
    public function login($username, $password){
        $stmt = $this->db->conn->prepare("SELECT * FROM users WHERE username=:username");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user && password_verify($password, $user['password'])){
            return $user;
        }
        return false;
    }

    // Fetch all users
    public function getAllUsers(){
        $stmt = $this->db->conn->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllStudents(){
        $stmt = $this->db->conn->query("SELECT * FROM users WHERE role = 'student'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
