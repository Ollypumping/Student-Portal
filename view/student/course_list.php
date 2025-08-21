<?php
 include('../../controller/student/CourseController.php');//This connects it to the controller
 require_once('../../controller/student/CourseRegController.php');
 if(isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION['success']);
}
$current_page = basename($_SERVER['PHP_SELF']);
?><!DOCTYPE html><html>
<head>
    <title>Course Registration</title>
    <style>
        * {
            box-sizing: border-box;
        }body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #eef1f5;
        margin: 0;
        padding: 0;
        display: flex;
        }

        .sidebar {
            width: 220px;
            height: 100vh;
            background-color: #004080;
            padding-top: 20px;
            position: fixed;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .sidebar-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            padding: 20px 0;
        }

        .sidebar-header {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.2);
            margin: 0 15px 10px;
            color: #ffcc00;
        }

        .sidebar .nav-links {
            flex-grow: 1;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            width: 100%;
            font-weight: normal;
            transition: background-color 0.3s ease;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #0066cc;
            border-left: 4px solid #ffcc00;
        }

        .sidebar a.logout {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 8px;
            width: 70%;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
            margin-left: 30px;
        }

        .sidebar a.logout:hover {
            background-color: #d32f2f;
        }

        .main-content {
            margin-left: 220px;
            padding: 40px;
            flex: 1;
        }

        .container {
            max-width: 1000px;
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            padding: 12px;
            border: 1px solid #c3e6cb;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 14px 12px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
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

        input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 16px;
            font-size: 14px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        input[type="checkbox"] {
            transform: scale(1.2);
        }

        a.back-link {
            display: inline-block;
            margin-top: 25px;
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        @media screen and (max-width: 768px) {
            body {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
            }

            table, th, td {
                font-size: 14px;
            }

            input[type="submit"] {
                width: 100%;
                margin-top: 5px;
            }
        }
</style>

</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-content">
            <div class="sidebar-header">Student Portal</div>
            <div class="nav-links">
                <a href="dashboard.php" class="<?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">Dashboard</a>
                <a href="my_courses.php" class="<?php echo ($current_page == 'my_courses.php') ? 'active' : ''; ?>">My Courses</a>
                <a href="course_list.php" class="<?php echo ($current_page == 'course_list.php') ? 'active' : ''; ?>">Course Registration</a>
                <a href="edit_profile.php" class="<?php echo ($current_page == 'edit_profile.php') ? 'active' : ''; ?>">Edit Profile</a>
            </div>
        </div>
        <a href="logout.php" class="logout">Logout</a>
    </div><!-- Main Content -->
<div class="main-content">
    <div class="container">
        <h2>Available Courses</h2>

        <?php if ($success) echo "<div class='success'>$success</div>"; ?>

        <form method="POST" action="">
            <input type="submit" value="Register Selected Courses">
            <table>
                <thead>
                    <tr>
                        <th>Select</th>
                        <th>Course Code</th>
                        <th>Course Title</th>
                        <th>Credit Units</th>
                        <th>Semester</th>
                        <th>Level</th>
                        <th>Programme</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($course = $courses->fetch_assoc()): ?>
                        <tr>
                            <td><input type="checkbox" name="selected_courses[]" value="<?php echo $course['id']; ?>"></td>
                            <td><?php echo htmlspecialchars($course['course_code']); ?></td>
                            <td><?php echo htmlspecialchars($course['course_title']); ?></td>
                            <td><?php echo htmlspecialchars($course['credit_unit']); ?></td>
                            <td><?php echo htmlspecialchars($course['semester']); ?></td>
                            <td><?php echo htmlspecialchars($course['level']); ?></td>
                            <td><?php echo htmlspecialchars($course['programme']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </form>

        <a href="dashboard.php" class="back-link">← Back to Dashboard</a>
    </div>
</div>

</body>
</html>