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

    // Handle Change Password
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $current_password_err = $new_password_err = $confirm_password_err = "";
        $success = "";

        
        $current_password = $_POST['current_password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        $result = $studentModel->changePassword($user_id, $current_password, $new_password, $confirm_password);

        // Store success or error messages in session
        $_SESSION['change_success'] = $result['success'] ?? '';

        $_SESSION['current_password_err'] = $result['current'] ?? '';
        $_SESSION['new_password_err'] = $result['new'] ?? '';
        $_SESSION['confirm_password_err'] = $result['confirm'] ?? '';

        // Redirect back to the change password page
        header("Location: ../../view/student/change_password.php");
        exit();
        
    }