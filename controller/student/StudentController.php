<?php
// controller/student/StudentController.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../../config/config.php');
require_once('../../model/Student.php');


if (!isset($_SESSION['user_id'])) {
    header('Location: ../../view/student/login.php');
    exit();
}
$_SESSION['user_id'] = $_SESSION['user_id'] ?? null; // Ensure user_id is set in session
$user_id = $_SESSION['user_id'] ?? null; // Get user ID from session    

$studentModel = new Student($conn);




// Handle Student Dashboard    
$user = $studentModel->getStudentById($_SESSION['user_id']);
    
// Get registered courses
$registeredCourses = $studentModel->getRegisteredCourses($_SESSION['user_id']);
    
// Get the total registered courses count
$total_courses = $studentModel->getTotalRegisteredCourses($_SESSION['user_id']);
    
// Get the number of core and elective courses
$courseTypes = $studentModel->getCourseTypes($_SESSION['user_id']);
$core_courses = $courseTypes['core_courses'];   
$elective_courses = $courseTypes['elective_courses'];  


    

?>
