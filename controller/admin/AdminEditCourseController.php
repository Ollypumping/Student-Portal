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

//To edit courses for a particular student
$success = $error = "";
$student_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['courses'])) {
    $selected_courses = $_POST['courses'];
    $courseModel->updateStudentCourses($student_id, $selected_courses);
    $success = "Courses updated successfully!";
}
$all_courses = $courseModel->getAllCourses();
$student_courses_raw = $courseModel->getCoursesByStudent($student_id);
$student_courses = array_column($student_courses_raw, 'course_id');
