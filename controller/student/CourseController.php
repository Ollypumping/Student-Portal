<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once('../../config/config.php');
require_once('../../model/Student.php');

$user_id = $_SESSION['user_id'];
$studentModel = new Student($conn);
$success = "";


if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}


// Handle Edit Course 
if (isset($_GET['registration_id']) && $_SERVER['REQUEST_METHOD'] == 'GET') {

    $registration_id = isset($_GET['registration_id']) ? intval($_GET['registration_id']) : 0;
    $success = "";


    
    $current = $studentModel->getRegistrationById($registration_id, $user_id);
    

    if (!$current) {
        header("Location: my_courses.php");
    }

    $current_course_id = $current['course_id'];
 
    $course_info = $studentModel->getCourseById($current_course_id);
    $course_options = $studentModel->getAlternativeCourses($current['level'], $current['programme'], $current_course_id);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_course_id'])) {
    $registration_id = isset($_GET['registration_id']) ? intval($_GET['registration_id']) : 0;
    $new_course_id = intval($_POST['new_course_id']);
    $result = $studentModel->updateCourseRegistration($registration_id, $user_id, $new_course_id);

    if ($result === true) {
        header("Location: my_courses.php");
        exit();
    } else {
        $success = $result;
    }
}

// Handle course drop
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['registration_id'])) {
    $registration_id = intval($_POST['registration_id']);
    $result = $studentModel->dropCourse($user_id, $registration_id);
    $success = $result ? "Course dropped successfully!" : "Error dropping course or unauthorized.";
    header("Location: my_courses.php?success=$success");
    exit();
}

// To View Course List
$courses = $studentModel->getUnregisteredCourses($user_id);


// To View My Courses
$my_courses = $studentModel->getRegisteredCourses($_SESSION['user_id']);




?>