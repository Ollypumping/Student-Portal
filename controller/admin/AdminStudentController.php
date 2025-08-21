<?php
// controller/admin/AdminStudentController.php

session_start();
require_once('../../config/config.php'); 
require_once('../../model/Student.php');


// Check admin session
if (!isset($_SESSION['user_id'])) {
    header('Location: ../../view/student/login.php');
    exit();
}

$studentModel = new Student($conn);

$student = null;
if (isset($_GET['id'])) {
    $student = $studentModel->getStudentById((int) $_GET['id']);
    if (!$student) {
        $error = "Student not found.";
    }
}



// To edit Student Details
    $success = "";
    $error = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $data = [
            'id' => intval($_POST['id']),
            'firstname' => $_POST['firstname'],
            'lastname' => $_POST['lastname'],
            'email' => $_POST['email'],
            'gender' => $_POST['gender'],
            'dob' => $_POST['dob'],
            'phone' => $_POST['phone'],
            'address' => $_POST['address'],
            'matric_no' => $_POST['matric_no'],
            'department' => $_POST['department'],
            'level' => $_POST['level'],
            'programme' => $_POST['programme'],
            'faculty' => $_POST['faculty'],
            'entry_year' => $_POST['entry_year']
        ];
        if ($studentModel->updateStudent($data)) {
            $success = "Student record updated successfully.";
            $student = $studentModel->getStudentById($data['id']);
        } else {
            $error = "Failed to update student record.";
        }
    }

// View All Students
$students = $studentModel->getAllStudents();

?>
