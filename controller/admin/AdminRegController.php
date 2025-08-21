<?php
session_start();
require_once('../../config/config.php');
require_once('../../model/Admin.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: ../../view/student/login.php');
    exit();
}

$adminModel = new Admin($conn);

$firstname = $email = $password_input = "";
$firstname_err = $email_err = $password_err = "";
$success = "";


// Handle Admin Registration
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstname = htmlspecialchars(trim($_POST["firstname"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $password_input = trim($_POST["password"]);

    

    if (empty($firstname)) $firstname_err = "Firstname is required";
    if (empty($email)) $email_err = "Email is required";
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $email_err = "Invalid email format";
    if (empty($password_input)) $password_err = "Password is required";

    if (empty($firstname_err) && empty($email_err) && empty($password_err)) {
        $password_hashed = password_hash($password_input, PASSWORD_DEFAULT);
        if ($adminModel->register($firstname, $email, $password_hashed)) {
            $success = "Admin registration successful! You can now <a href='admin_login.php'>Login Here</a>.";
            $firstname = $email = $password_input = "";
        } else {
            $success = "Something went wrong. Try again.";
        }
    }
}