<?php
class Auth {
    // Start session securely
    public static function startSession(){
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }

        // Session timeout (10 minutes = 600 seconds)
        $timeout = 600;
        if(isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout){
            session_unset();
            session_destroy();
            header("Location: ../views/login.php?timeout=1");
            exit;
        }
        $_SESSION['LAST_ACTIVITY'] = time();
    }

    // Require login and check role
    public static function requireRole($role){
        self::startSession();
        if(!isset($_SESSION['user_id']) || $_SESSION['role'] != $role){
            header("Location: ../views/login.php");
            exit;
        }
    }

    // Get current user session data
    public static function user(){
        self::startSession();
        if(isset($_SESSION['user_id'])){
            return [
                'id'=>$_SESSION['user_id'],
                'role'=>$_SESSION['role']
            ];
        }
        return null;
    }

    // Logout
    public static function logout(){
        self::startSession();
        session_unset();
        session_destroy();
        header("Location: /student_monitoring_system/views/login.php?success=1");
        exit;
    }
}
?>
