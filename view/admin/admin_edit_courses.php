<?php
include('../../controller/admin/AdminEditCourseController.php');
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Student Courses - Admin</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
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
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .success {
            color: green;
            text-align: center;
            margin-bottom: 20px;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 20px;
        }

        .course-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 10px;
        }

        .course-item {
            background: #f9f9f9;
            padding: 12px;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
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

        a.back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
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
        <h2>Edit Student Courses</h2>

        <?php if ($success): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php elseif ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="course-list">
                <?php foreach($courseModel->getAllCourses() as $course): ?>
                    <div class="course-item">
                        <label>
                            <input type="checkbox" name="courses[]" value="<?php echo $course['id']; ?>"
                                <?php if (in_array($course['id'], $student_courses)) echo 'checked'; ?>>
                            <?php echo htmlspecialchars($course['course_code']) . " - " . htmlspecialchars($course['course_title']); ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>

            <input type="submit" value="Update Courses">
        </form>

        <a href="admin_manage_courses.php" class="back-link">← Back to Students List</a>
    </div>
</div>

</body>
</html>