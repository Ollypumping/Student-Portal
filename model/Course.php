<?php
// model/Course.php

class Course {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllCourses() {
        $sql = "SELECT * FROM courses ORDER BY level ASC, course_code ASC";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getCourseById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM courses WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getStudentsByCourse($course_id) {
        $stmt = $this->conn->prepare("
            SELECT s.firstname, s.lastname, s.matric_no
            FROM course_registrations cr
            JOIN students s ON cr.user_id = s.id
            WHERE cr.course_id = ?
            ORDER BY s.firstname ASC
        ");
        $stmt->bind_param("i", $course_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getCourseWithStudents($course_id) {
        // Get course details
        $stmt = $this->conn->prepare("SELECT course_code, course_title FROM courses WHERE id = ?");
        $stmt->bind_param("i", $course_id);
        $stmt->execute();
        $course = $stmt->get_result()->fetch_assoc();
    
        if (!$course) return null;
    
        // Get registered students
        $students_stmt = $this->conn->prepare("
            SELECT s.matric_no, s.firstname, s.lastname 
            FROM course_registrations cr 
            JOIN students s ON cr.user_id = s.id 
            WHERE cr.course_id = ?
            ORDER BY s.firstname ASC
        ");
        $students_stmt->bind_param("i", $course_id);
        $students_stmt->execute();
        $students = $students_stmt->get_result();
    
        return ['course' => $course, 'students' => $students];
    }



    // Fetch courses registered by a specific student
    public function getCoursesByStudent($student_id) {
        $stmt = $this->conn->prepare("SELECT course_id FROM course_registrations WHERE user_id = ?");
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Update course registrations for a student
    public function updateStudentCourses($student_id, $selected_courses) {
        $this->conn->query("DELETE FROM course_registrations WHERE user_id = $student_id");

        $stmt = $this->conn->prepare("INSERT INTO course_registrations (user_id, course_id) VALUES (?, ?)");
        foreach ($selected_courses as $course_id) {
            $stmt->bind_param("ii", $student_id, $course_id);
            $stmt->execute();
        }
        return true;
    }

    public function countCourses() {
        $sql = "SELECT COUNT(*) AS total FROM courses";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc()['total'] : 0;
    }

    public function countRegisteredCourses() {
        $sql = "SELECT COUNT(DISTINCT course_id) AS total FROM course_registrations";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc()['total'] ?? 0;
    }

    public function countAllCourses() {
        $sql = "SELECT COUNT(*) as total FROM courses";
        $result = $this->conn->query($sql);
        if ($result && $row = $result->fetch_assoc()) {
            return $row['total'];
        }
        return 0;
    }

    public function countCoreCourses()
    {
        $sql = "SELECT COUNT(*) AS total FROM courses WHERE LOWER(credit_unit) LIKE '%(c)%'";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc()['total'] ?? 0;
    }

    public function countElectiveCourses()
    {
        $sql = "SELECT COUNT(*) AS total FROM courses WHERE LOWER(credit_unit) LIKE '%(e)%'";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc()['total'] ?? 0;
    }



}
?>