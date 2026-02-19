<?php
require_once 'User.php';

class ParentUser extends User {

    // Get children for this parent
    public function getChildren(){
        $stmt = $this->db->conn->prepare("
            SELECT u.id, u.name 
            FROM users u
            JOIN parent_student ps ON u.id = ps.student_id
            WHERE ps.parent_id = :pid
        ");
        $stmt->execute([':pid'=>$_SESSION['user_id']]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get grades for a student
    public function getGrades($student_id){
        $stmt = $this->db->conn->prepare("
            SELECT subject, grade 
            FROM grades
            WHERE student_id = :sid
        ");
        $stmt->execute([':sid'=>$student_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get notifications
    public function getNotifications(){
        $stmt = $this->db->conn->prepare("
            SELECT * FROM notifications WHERE user_id = :uid ORDER BY created_at DESC
        ");
        $stmt->execute([':uid'=>$_SESSION['user_id']]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
