<?php
require_once 'User.php';

class Student extends User {

    // Get grades for this student
    public function getGrades(){
        $stmt = $this->db->conn->prepare("
            SELECT subject, grade FROM grades WHERE student_id=:sid
        ");
        $stmt->execute([':sid'=>$_SESSION['user_id']]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get notifications for this student
    public function getNotifications(){
        $stmt = $this->db->conn->prepare("
            SELECT * FROM notifications WHERE user_id=:uid ORDER BY created_at DESC
        ");
        $stmt->execute([':uid'=>$_SESSION['user_id']]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
