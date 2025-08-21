<?php
session_start();
require_once('../../config/config.php');
require_once('../../model/Student.php');


$studentModel = new Student($conn);


// Handle User Login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $login_id = trim($_POST['login_id']);
    $password = $_POST['password'];

    if (empty($login_id) || empty($password)) {
        $_SESSION['login_err'] = "Email and password are required.";
    }

    // Look up user by email or matric number
    $stmt = $conn->prepare("SELECT * FROM students WHERE email = ? OR matric_no = ?");
    $stmt->bind_param("ss", $login_id, $login_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // Set session variables correctly
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['firstname'] = $user['firstname'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];

        // Redirect based on role
        if ($user['role'] === 'admin') {
           
            header("Location: ../admin/admin_dashboard.php");
        } else {
            header("Location: dashboard.php");
        }
        
    } else {
        $_SESSION['login_err'] = "Invalid credentials.";
    }
}

// Handle Student Register
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $formData = $_POST;
    $success = $studentModel->register($formData);
}
