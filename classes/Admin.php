<?php
require_once 'User.php';

class Admin extends User
{

    // Get all users
    public function getAllUsers()
    {
        $stmt = $this->db->conn->query("SELECT * FROM users ORDER BY id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Search users
    public function searchUsers($keyword)
    {
        $stmt = $this->db->conn->prepare("SELECT * FROM users 
                                         WHERE name LIKE :kw OR username LIKE :kw 
                                         ORDER BY id ASC");
        $stmt->execute([':kw' => "%$keyword%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Add new user
    public function addUser($data)
    {
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt = $this->db->conn->prepare(
            "INSERT INTO users (name, username, password, role) 
             VALUES (:name, :username, :password, :role)"
        );
        return $stmt->execute([
            ':name' => $data['name'],
            ':username' => $data['username'],
            ':password' => $hashedPassword,
            ':role' => $data['role']
        ]);
    }

    // Get a single user by ID
    public function getUser($id)
    {
        $stmt = $this->db->conn->prepare("SELECT * FROM users WHERE id=:id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update user
    public function updateUser($id, $data)
    {
        if (!empty($data['password'])) {
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            $stmt = $this->db->conn->prepare(
                "UPDATE users SET name=:name, username=:username, password=:password, role=:role WHERE id=:id"
            );
            return $stmt->execute([
                ':name' => $data['name'],
                ':username' => $data['username'],
                ':password' => $hashedPassword,
                ':role' => $data['role'],
                ':id' => $id
            ]);
        } else {
            $stmt = $this->db->conn->prepare(
                "UPDATE users SET name=:name, username=:username, role=:role WHERE id=:id"
            );
            return $stmt->execute([
                ':name' => $data['name'],
                ':username' => $data['username'],
                ':role' => $data['role'],
                ':id' => $id
            ]);
        }
    }

    // Delete user
    public function deleteUser($id)
    {
        $stmt = $this->db->conn->prepare("DELETE FROM users WHERE id=:id");
        return $stmt->execute([':id' => $id]);
    }

    // Get system settings
    public function getSettings()
    {
        $stmt = $this->db->conn->query("SELECT * FROM system_settings LIMIT 1");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update system settings
    public function updateSettings($data)
    {
        $stmt = $this->db->conn->prepare(
            "UPDATE system_settings SET school_name=:school, school_address=:address WHERE id=1"
        );
        return $stmt->execute([
            ':school' => $data['school_name'],
            ':address' => $data['school_address']
        ]);
    }

    // =========================
    // USERS REPORT
    public function getUsersReport($role = null)
    {
        if ($role) {
            $stmt = $this->db->conn->prepare("SELECT * FROM users WHERE role=:role ORDER BY id ASC");
            $stmt->execute([':role' => $role]);
        } else {
            $stmt = $this->db->conn->query("SELECT * FROM users ORDER BY id ASC");
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // =========================
    // GRADES REPORT
    public function getGradesReport()
    {
        $stmt = $this->db->conn->query("
        SELECT g.id, u.name AS student_name, g.subject, g.grade
        FROM grades g
        JOIN users u ON g.student_id = u.id
        ORDER BY u.name, g.subject
    ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // =========================
    // ATTENDANCE REPORT
    public function getAttendanceReport()
    {
        $stmt = $this->db->conn->query("
        SELECT a.id, u.name AS student_name, a.date, a.status
        FROM attendance a
        JOIN users u ON a.student_id = u.id
        ORDER BY a.date DESC
    ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // =====================
    // Get all parents
    public function getParents()
    {
        $stmt = $this->db->conn->prepare("SELECT id, name, username FROM users WHERE role='parent' ORDER BY name");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // =====================
    // Get all students
    public function getStudents()
    {
        $stmt = $this->db->conn->prepare("SELECT id, name FROM users WHERE role='student' ORDER BY name");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // =====================
    // Get children assigned to a parent
    public function getChildrenOfParent($parent_id)
    {
        $stmt = $this->db->conn->prepare("
        SELECT u.id, u.name
        FROM users u
        JOIN parent_student ps ON u.id = ps.student_id
        WHERE ps.parent_id = :pid
    ");
        $stmt->execute([':pid' => $parent_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // =====================
    // Assign parent to multiple students
    public function assignParentToStudents($parent_id, $student_ids)
    {
        // First delete previous assignments
        $stmt = $this->db->conn->prepare("DELETE FROM parent_student WHERE parent_id=:pid");
        $stmt->execute([':pid' => $parent_id]);

        // Insert new assignments
        $stmt = $this->db->conn->prepare("
        INSERT INTO parent_student (parent_id, student_id) VALUES (:pid, :sid)
    ");
        foreach ($student_ids as $sid) {
            $stmt->execute([':pid' => $parent_id, ':sid' => $sid]);
        }
        return true;
    }
}
