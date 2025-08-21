<?php
require_once('../../controller/admin/AdminController.php');
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 220px;
            background-color: #004080;
            color: white;
            padding-top: 20px;
            position: fixed;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
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
            transition: background-color 0.3s ease;
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

        .logout-btn:hover {
            background-color: #d32f2f;
        }

        .main-content {
            margin-left: 220px;
            padding: 40px;
            width: calc(100% - 220px);
            background-color: #f9f9f9;
            height: 100vh;
            overflow-y: auto;
        }

        .dashboard-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            margin: auto;
        }

        .dashboard-header {
            font-size: 26px;
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }

        .stats-section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 22px;
            margin-bottom: 15px;
            color: #004080;
        }

        .stats-cards {
            display: flex;
            gap: 20px;
            justify-content: space-around;
            margin-bottom: 20px;
        }

        .card {
            background-color: #007bff;
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            flex: 1;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: scale(1.03);
        }

        .card h3 {
            margin: 0;
            font-size: 26px;
        }

        .card p {
            margin: 5px 0 0;
            font-size: 18px;
        }

        .sub-cards {
            display: flex;
            gap: 10px;
            justify-content: space-around;
        }

        .sub-card {
            background-color: #007bff;
            color: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            flex: 1;
            transition: transform 0.3s ease;
        }

        .sub-card:hover {
            transform: scale(1.02);
        }

        .sub-card h4 {
            margin: 0;
            font-size: 20px;
        }

        .sub-card p {
            margin: 5px 0;
            font-size: 16px;
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
    <div class="dashboard-container">
        <div class="dashboard-header">Welcome, <strong> <?php echo htmlspecialchars($admin['firstname'] ?? 'Admin'); ?></strong></div>

        <div class="stats-section">
            <div class="section-title">Student Information</div>
            <div class="stats-cards">
                <div class="card">
                    <h3><?php echo $adminController->countTotalStudents(); ?></h3>
                    <p>Total Students</p>
                </div>
            </div>
            <div class="sub-cards">
                <div class="sub-card">
                    <h4><?php echo $adminController->countStudentsByProgramme('BSc'); ?></h4>
                    <p>BSc</p>
                </div>
                <div class="sub-card">
                    <h4><?php echo $adminController->countStudentsByProgramme('MSc'); ?></h4>
                    <p>MSc</p>
                </div>
                <div class="sub-card">
                    <h4><?php echo $adminController->countStudentsByProgramme('PhD'); ?></h4>
                    <p>PhD</p>
                </div>
            </div>
        </div>

        <div class="stats-section">
            <div class="section-title">Course Information</div>
            <div class="stats-cards">
                <div class="card">
                    <h3><?php echo $adminController->countCourses(); ?></h3>
                    <p>Total Courses</p>
                </div>
            </div>
            <div class="sub-cards">
                <div class="sub-card">
                    <h4><?php echo $adminController->countRegisteredCourses(); ?></h4>
                    <p>Registered</p>
                </div>
                <div class="sub-card">
                    <h4><?php echo $adminController->countUnregisteredCourses(); ?></h4>
                    <p>Unregistered</p>
                </div>
                <div class="sub-card">
                    <h4><?php echo $adminController->countCoreCourses(); ?></h4>
                    <p>Core Courses</p>
                </div>
                <div class="sub-card">
                    <h4><?php echo $adminController->countElectiveCourses(); ?></h4>
                    <p>Elective Courses</p>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>