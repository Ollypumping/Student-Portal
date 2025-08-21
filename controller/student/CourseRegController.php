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

// To handle Register Course
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['course_ids'])) {
    $course_ids = $_POST['course_ids']; // An array of selected course IDs
    $success = $studentModel->registerCourses($_SESSION['user_id'], $course_ids);
    // Refresh the course list
    $courses = $studentModel->getUnregisteredCourses($user_id);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['selected_courses'])) {
    $selected_courses = $_POST['selected_courses'];
    $registered_count = $studentModel->registerCourses($user_id, $selected_courses);

    if ($registered_count > 0) {
        // Store message in session
        $_SESSION['success'] = "$registered_count course(s) registered successfully.";
    } else {
        $_SESSION['error'] = "No new courses were registered.";
    }

    header("Location: ../../view/student/course_list.php");
    exit();
}

