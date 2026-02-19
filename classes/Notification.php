<?php
require_once 'Database.php';

class Notification {
    public $db;

    public function __construct(){
        $this->db = new Database();
    }

    // Send notification to a student
    public function send($student_id, $message){
        $stmt = $this->db->conn->prepare("INSERT INTO notifications (student_id, message) VALUES (:sid, :msg)");
        return $stmt->execute([':sid' => $student_id, ':msg' => $message]);
    }

    // Get notifications for a student
    public function getForStudent($student_id){
        $stmt = $this->db->conn->prepare("SELECT * FROM notifications WHERE student_id=:sid ORDER BY date DESC");
        $stmt->execute([':sid'=>$student_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
