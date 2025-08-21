<?php
include('../../controller/admin/AdminStudentController.php');
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Student - Admin</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
        }

        .sidebar {
            width: 220px;
            background-color: #004080;
            height: 100vh;
            color: white;
            padding-top: 20px;
            position: fixed;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.2);
            color: #ffcc00;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 15px 20px;
            text-decoration: none;
            font-weight: bold;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #0066cc;
            border-left: 4px solid #ffcc00;
        }

        .sidebar form {
            margin-top: auto;
            padding: 20px;
        }

        .logout-btn {
            background-color: #f44336 !important;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .main-content {
            margin-left: 220px;
            padding: 40px;
            width: 100%;
        }

        .form-container {
            max-width: 700px;
            background: #fff;
            margin: auto;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="date"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 20px;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .success {
            color: green;
            text-align: center;
        }

        .error {
            color: red;
            text-align: center;
        }

        a.back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
            font-weight: bold;
            text-decoration: none;
            color: #007bff;
        }

        a.back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-header">Admin Portal</div>
    <a href="admin_dashboard.php" class="<?= $current_page == 'admin_dashboard.php' ? 'active' : '' ?>">Dashboard</a>
    <a href="student_list.php" class="<?= $current_page == 'student_list.php' ? 'active' : '' ?>">Manage Students</a>
    <a href="admin_manage_courses.php" class="<?= $current_page == 'admin_manage_courses.php' ? 'active' : '' ?>">Manage Courses</a>
    <a href="admin_courses.php" class="<?= $current_page == 'admin_courses.php' ? 'active' : '' ?>">Course Registrations</a>
    <form method="POST" action="../../view/student/logout.php">
        <input type="submit" class="logout-btn" value="Logout">
    </form>
</div>

<div class="main-content">
    <div class="form-container">
        <h2>Edit Student Details</h2>

        <?php if ($error): ?><p class="error"><?= $error ?></p><?php endif; ?>
        <?php if ($success): ?><p class="success"><?= $success ?></p><?php endif; ?>

        <?php if ($student): ?>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?= $student['id'] ?>">

            <label>First Name:</label>
            <input type="text" name="firstname" value="<?= htmlspecialchars($student['firstname']) ?>">

            <label>Last Name:</label>
            <input type="text" name="lastname" value="<?= htmlspecialchars($student['lastname']) ?>">

            <label>Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($student['email']) ?>">

            <label>Gender:</label>
            <input type="radio" name="gender" value="Male" <?= ($student['gender'] ?? '' == "Male") ? "checked" : "" ?>> Male
            <input type="radio" name="gender" value="Female" <?= ($student['gender'] ?? '' == "Female") ? "checked" : "" ?>> Female

            <label>Phone:</label>
            <input type="text" name="phone" value="<?= htmlspecialchars($student['phone']) ?>">

            <label>Date of Birth:</label>
            <input type="date" name="dob" value="<?= htmlspecialchars($student['dob']) ?>">

            <label>Address:</label>
            <textarea name="address" rows="4"><?= htmlspecialchars($student['address']) ?></textarea>

            <label>Programme:</label>
            <select name="programme">
                <option value="">Select Programme</option>
                <option value="BSc" <?= ($student['programme'] == "BSc") ? "selected" : "" ?>>BSc</option>
                <option value="MSc" <?= ($student['programme'] == "MSc") ? "selected" : "" ?>>MSc</option>
                <option value="PhD" <?= ($student['programme'] == "PhD") ? "selected" : "" ?>>PhD</option>
            </select>

            <label>Matric Number:</label>
            <input type="text" name="matric_no" value="<?= htmlspecialchars($student['matric_no']) ?>" readonly>

            <label>Faculty:</label>
            <select name="faculty">
                <option value="">Select Faculty</option>
                <option value="Science" <?= ($student['faculty'] == "Science") ? "selected" : "" ?>>Science</option>
                <option value="Arts" <?= ($student['faculty'] == "Arts") ? "selected" : "" ?>>Arts</option>
                <option value="Engineering" <?= ($student['faculty'] == "Engineering") ? "selected" : "" ?>>Engineering</option>
                <option value="Business" <?= ($student['faculty'] == "Business") ? "selected" : "" ?>>Business</option>
                <option value="Education" <?= ($student['faculty'] == "Education") ? "selected" : "" ?>>Education</option>
            </select>

            <label>Department:</label>
            <input type="text" name="department" value="<?= htmlspecialchars($student['department']) ?>">

            <label>Level:</label>
            <input type="text" name="level" value="<?= htmlspecialchars($student['level']) ?>">

            <label>Entry Year:</label>
            <input type="number" name="entry_year" value="<?= htmlspecialchars($student['entry_year']) ?>">

            <input type="submit" value="Update Student">
        </form>
        <?php endif; ?>

        <a href="student_list.php" class="back-link">← Back to Student List</a>
    </div>
</div>

</body>
</html>