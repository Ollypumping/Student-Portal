<?php
session_start();
require_once('../../config/config.php');
require_once('../../model/Student.php');

$studentModel = new Student($conn);

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


$user_id = $_SESSION['user_id'];
$user = $studentModel->getStudentById($user_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle Profile Edit
    
    $formData = $_POST;
    $file = $_FILES['profile_pic'] ?? null;
    $updateSuccess = $studentModel->updateStudentProfile($user_id, $formData, $file);
    $_SESSION['success'] = $updateSuccess ? "Profile updated successfully." : "Failed to update profile.";
    $user = $studentModel->getStudentById($user_id);
    header("Location: ../../view/student/edit_profile.php");
    exit();

    

}