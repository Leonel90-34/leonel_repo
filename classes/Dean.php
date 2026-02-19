<?php
require_once 'User.php';

class Dean extends User {

    // Get all faculty (teachers)
    public function getAllFaculty(){
        $stmt = $this->db->conn->prepare("SELECT * FROM users WHERE role='teacher' ORDER BY id ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get a single faculty
    public function getFaculty($id){
        $stmt = $this->db->conn->prepare("SELECT * FROM users WHERE id=:id AND role='teacher'");
        $stmt->execute([':id'=>$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Add faculty (teacher)
    public function addFaculty($data){
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt = $this->db->conn->prepare(
            "INSERT INTO users (name, username, password, role) VALUES (:name,:username,:password,'teacher')"
        );
        return $stmt->execute([
            ':name'=>$data['name'],
            ':username'=>$data['username'],
            ':password'=>$hashedPassword
        ]);
    }

    // Update faculty
    public function updateFaculty($id, $data){
        if(!empty($data['password'])){
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            $stmt = $this->db->conn->prepare(
                "UPDATE users SET name=:name, username=:username, password=:password WHERE id=:id AND role='teacher'"
            );
            return $stmt->execute([
                ':name'=>$data['name'],
                ':username'=>$data['username'],
                ':password'=>$hashedPassword,
                ':id'=>$id
            ]);
        } else {
            $stmt = $this->db->conn->prepare(
                "UPDATE users SET name=:name, username=:username WHERE id=:id AND role='teacher'"
            );
            return $stmt->execute([
                ':name'=>$data['name'],
                ':username'=>$data['username'],
                ':id'=>$id
            ]);
        }
    }

    // Delete faculty
    public function deleteFaculty($id){
        $stmt = $this->db->conn->prepare("DELETE FROM users WHERE id=:id AND role='teacher'");
        return $stmt->execute([':id'=>$id]);
    }
}
?>
