<?php
session_start();
require_once('../../config/config.php');
require_once('../../model/Admin.php');
require_once('../../model/Student.php');
require_once('../../model/Course.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: ../../view/student/login.php');
    exit();
}

$adminModel = new Admin($conn);
$studentModel = new Student($conn);
$courseModel = new Course($conn);


// Admin Dashboard Data
  
$admin = $adminModel->getAdminById($_SESSION['user_id']) ?? [];
$error = $admin ? "" : "Admin not found.";

// Dashboard Stats
$totalStudents = $studentModel->countTotalStudents();
$totalCourses = $courseModel->countCourses();
$entryYearStats = $studentModel->groupByEntryYear();
$programmeStats = [
    'BSc' => $studentModel->countByProgramme('BSc'),
    'MSc' => $studentModel->countByProgramme('MSc'),
    'PhD' => $studentModel->countByProgramme('PhD')
];

// AdminController Class
class AdminController {
    private $conn;
    private $studentModel;
    private $courseModel;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->studentModel = new Student($conn);
        $this->courseModel = new Course($conn);
    }

    public function getAdminDetails($adminId) {
        return $this->studentModel->getStudentById($adminId);
    }

    public function countTotalStudents() {
        return $this->studentModel->countByRole('student');
    }

    public function countStudentsByProgramme($programme) {
        return $this->studentModel->countByProgramme($programme);
    }

    public function countCourses() {
        return $this->courseModel->countCourses();
    }

    
    public function getEntryYearStats() {
        return $this->studentModel->groupByEntryYear();
    }

    public function countRegisteredCourses() {
        return $this->courseModel->countRegisteredCourses();
    }

    public function countUnregisteredCourses() {
        $total = $this->courseModel->countAllCourses();
        $registered = $this->courseModel->countRegisteredCourses();

        return $total - $registered;
    }

    public function countCoreCourses() {
        return $this->courseModel->countCoreCourses();
    }

    public function countElectiveCourses() {
        return $this->courseModel->countElectiveCourses();
    }

    public function logout() {
        session_destroy();
        header("Location: ../../view/student/login.php");
        exit();
    }
}
$adminController = new AdminController($conn);