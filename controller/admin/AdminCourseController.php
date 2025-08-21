<?php
session_start();
require_once('../../config/config.php'); 
require_once('../../model/Student.php');
require_once('../../model/Admin.php');
require_once('../../model/Course.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$courseModel = new Course($conn);
$studentModel = new Student($conn);

// Get all students
$students = $studentModel->getAllStudents(); 
//To display all courses
$courses = $courseModel->getAllCourses();



//To check the students registered for a particular course
if (isset($_GET['course_id'])) {
    $course_id = intval($_GET['course_id']);
    $courseData = $courseModel->getCourseWithStudents($course_id);

    if (!$courseData) {
        die("Course not found.");
    }

    $course = $courseData['course'];
    $students = $courseData['students'];
}



?>