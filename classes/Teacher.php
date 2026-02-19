<?php
require_once 'User.php';

class Teacher extends User
{

    // Get all students
    public function getStudents()
    {
        $stmt = $this->db->conn->query("SELECT id, name FROM users WHERE role='student' ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get grades for a student
    public function getGrades($student_id)
    {
        $stmt = $this->db->conn->prepare("SELECT * FROM grades WHERE student_id=:sid ORDER BY subject ASC");
        $stmt->execute([':sid' => $student_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Add or update grade
    public function addOrUpdateGrade($student_id, $subject, $grade)
    {
        $stmt = $this->db->conn->prepare("
            SELECT * FROM grades WHERE student_id=:sid AND subject=:sub
        ");
        $stmt->execute([':sid' => $student_id, ':sub' => $subject]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            $stmt = $this->db->conn->prepare("UPDATE grades SET grade=:grade WHERE id=:id");
            return $stmt->execute([':grade' => $grade, ':id' => $existing['id']]);
        } else {
            $stmt = $this->db->conn->prepare("INSERT INTO grades (student_id, subject, grade) VALUES (:sid, :sub, :grade)");
            return $stmt->execute([':sid' => $student_id, ':sub' => $subject, ':grade' => $grade]);
        }
    }

    // =====================
    // Get attendance for a specific date
    public function getAttendance($date)
    {
        $stmt = $this->db->conn->prepare("
        SELECT a.*, u.name 
        FROM attendance a
        JOIN users u ON a.student_id = u.id
        WHERE a.teacher_id=:tid AND a.date=:date
        ORDER BY u.name
    ");
        $stmt->execute([
            ':tid' => $_SESSION['user_id'],
            ':date' => $date
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // =====================
    // Submit or update attendance
    public function submitAttendance($student_id, $date, $status)
    {
        // Check if attendance exists
        $stmt = $this->db->conn->prepare("
        SELECT * FROM attendance WHERE student_id=:sid AND date=:date AND teacher_id=:tid
    ");
        $stmt->execute([
            ':sid' => $student_id,
            ':date' => $date,
            ':tid' => $_SESSION['user_id']
        ]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            // Update
            $stmt = $this->db->conn->prepare("
            UPDATE attendance SET status=:status WHERE id=:id
        ");
            return $stmt->execute([
                ':status' => $status,
                ':id' => $existing['id']
            ]);
        } else {
            // Insert
            $stmt = $this->db->conn->prepare("
            INSERT INTO attendance (student_id, date, status, teacher_id)
            VALUES (:sid, :date, :status, :tid)
        ");
            return $stmt->execute([
                ':sid' => $student_id,
                ':date' => $date,
                ':status' => $status,
                ':tid' => $_SESSION['user_id']
            ]);
        }
    }

    // =====================
    // Get all tests for this teacher
    public function getTests()
    {
        $stmt = $this->db->conn->prepare("SELECT * FROM tests WHERE teacher_id=:tid ORDER BY date DESC");
        $stmt->execute([':tid' => $_SESSION['user_id']]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // =====================
    // Get single test
    public function getTest($id)
    {
        $stmt = $this->db->conn->prepare("SELECT * FROM tests WHERE id=:id AND teacher_id=:tid");
        $stmt->execute([':id' => $id, ':tid' => $_SESSION['user_id']]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // =====================
    // Add test
    public function addTest($data)
    {
        $stmt = $this->db->conn->prepare("
        INSERT INTO tests (teacher_id, subject, title, max_score, date)
        VALUES (:tid, :subject, :title, :max_score, :date)
    ");
        return $stmt->execute([
            ':tid' => $_SESSION['user_id'],
            ':subject' => $data['subject'],
            ':title' => $data['title'],
            ':max_score' => $data['max_score'],
            ':date' => $data['date']
        ]);
    }

    // =====================
    // Update test
    public function updateTest($id, $data)
    {
        $stmt = $this->db->conn->prepare("
        UPDATE tests SET subject=:subject, title=:title, max_score=:max_score, date=:date
        WHERE id=:id AND teacher_id=:tid
    ");
        return $stmt->execute([
            ':subject' => $data['subject'],
            ':title' => $data['title'],
            ':max_score' => $data['max_score'],
            ':date' => $data['date'],
            ':id' => $id,
            ':tid' => $_SESSION['user_id']
        ]);
    }

    // =====================
    // Delete test
    public function deleteTest($id)
    {
        $stmt = $this->db->conn->prepare("DELETE FROM tests WHERE id=:id AND teacher_id=:tid");
        return $stmt->execute([':id' => $id, ':tid' => $_SESSION['user_id']]);
    }
}
