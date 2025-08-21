<?php
include('../../controller/admin/AdminCourseController.php');
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Students Registered - Admin</title>
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
            background-color: #f44336;
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

        .container {
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
            margin-bottom: 30px;
        }

        h3 {
            text-align: center;
            color: #555;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 12px 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            font-size: 15px;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
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
    <div class="container">
        <h2>Students Registered</h2>
        <h3><?php echo htmlspecialchars($course['course_code']) . " - " . htmlspecialchars($course['course_title']); ?></h3>

        <table>
            <thead>
                <tr>
                    <th>Matric No</th>
                    <th>Full Name</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($students->num_rows > 0): ?>
                    <?php while($student = $students->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($student['matric_no']); ?></td>
                            <td><?php echo htmlspecialchars($student['firstname'] . " " . $student['lastname']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="2" style="text-align:center;">No students registered for this course.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <a href="admin_courses.php" class="back-link">← Back to Courses</a>
    </div>
</div>

</body>
</html>