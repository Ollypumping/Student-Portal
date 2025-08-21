<?php
include('../../config/config.php'); 
require_once('../../model/Student.php');
require_once('../../model/Course.php');

class Admin {
    public $conn;
    public $studentModel;
    public $courseModel;

    public function __construct($db) {
        $this->conn = $db;
        $this->studentModel = new Student($db);
        $this->courseModel = new Course($db);
    }

    // Register a new admin
    public function register($firstname, $email, $password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO students (firstname, email, password, role) VALUES (?, ?, ?, 'admin')";
        $stmt = $this->conn->prepare($sql);
        
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param("sss", $firstname, $email, $hashed_password);

        return $stmt->execute();
    }


    

    // Fetch admin by ID
    public function getAdminById($admin_id) {
        $sql = "SELECT * FROM students WHERE id = ? AND role = 'admin' LIMIT 1";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $admin_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    

    public function getAllStudents(){
        $sql = "SELECT * FROM students WHERE role = 'student' ORDER BY firstname ASC";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getAllCourses($id){
    
        $sql = "SELECT * FROM courses ORDER BY level ASC, course_code ASC";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getEntryYearStats() {
        $sql = "SELECT entry_year, COUNT(*) AS total FROM students GROUP BY entry_year ORDER BY entry_year ASC";
        $result = $this->conn->query($sql);
    
        $stats = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $stats[] = $row;
            }
        }
    
        return $stats;
    }

    public function countTotalStudents() {
        $sql = "SELECT COUNT(*) AS total FROM students WHERE role = 'student'";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc()['total'] : 0;
    }

    public function countStudentsByProgramme($programme) {
        $sql = "SELECT COUNT(*) AS total FROM students WHERE programme = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $programme);
        $stmt->execute();
        $result = $stmt->get_result();
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc()['total'] : 0;
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header("Location: admin_login.php");
        exit();
    }

    

    
    
}
?>