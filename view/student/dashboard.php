<?php
include('../../controller/student/StudentController.php'); //This connects it to the controller
$current_page = basename($_SERVER['PHP_SELF']);
$profile_pic = $user['profile_pic'] ?? '../../uploads/picture.jpg';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .sidebar {
            width: 220px;
            background-color: #004080;
            color: #fff;
            height: 100vh;
            padding-top: 20px;
            display: flex;
            flex-direction: column;
            position: fixed;
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

        .sidebar a {
            padding: 15px 20px;
            text-decoration: none;
            color: #fff;
            display: block;
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

        .logout-btn:hover {
            background-color: #d32f2f;
        }

        .main-content {
            margin-left: 220px;
            padding: 40px;
            width: 100%;
        }

        .dashboard-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            max-width: 900px;
            margin: auto;
            position: relative;
        }

        .profile-pic-container {
            position: absolute;
            top: 150px;
            right: 30px;
        }

        .profile-pic-container img {
            width: 100px;
            height: 100px;
            aspect-ratio: 1/1;
            border-radius: 50%;
            border: 3px solid #004080;
            object-fit: cover;
            background-color: #fff;
        }

        .stats-cards {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
            justify-content: space-between;
        }

        .card {
            background-color: #007bff;
            color: white;
            flex: 1;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        .card h3 {
            margin: 0;
            font-size: 28px;
        }

        .card p {
            margin: 5px 0 0;
            font-size: 16px;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
        }

        h4 {
            color: #333;
            font-size: 18px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f7f7f7;
            color: #333;
        }

        td {
            color: #555;
        }

        @media (max-width: 768px) {
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

            .sidebar form {
                margin-top: 10px;
            }

            .profile-pic-container {
                position: static;
                margin: 0 auto 20px;
                display: flex;
                justify-content: center;
            }

            .stats-cards {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <div class="sidebar-header">Student Portal</div>
        <a href="dashboard.php" class="<?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">Dashboard</a>
        <a href="my_courses.php" class="<?php echo ($current_page == 'my_courses.php') ? 'active' : ''; ?>">My Courses</a>
        <a href="course_list.php" class="<?php echo ($current_page == 'course_list.php') ? 'active' : ''; ?>">Courses</a>
        <a href="edit_profile.php" class="<?php echo ($current_page == 'edit_profile.php') ? 'active' : ''; ?>">Edit Profile</a>

        <form method="POST" action="logout.php">
            
            <input type="submit" class="logout-btn" value="Logout">
        </form>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="dashboard-container">
            <!-- Profile Picture -->
            <div class="profile-pic-container">
                <img src="<?php echo htmlspecialchars($profile_pic); ?>" alt="Profile Picture">

            </div>

            <!-- Stat Cards -->
            <div class="stats-cards">
                <div class="card">
                    <h3><?php echo $total_courses; ?></h3>
                    <p>Total Courses</p>
                </div>
                <div class="card">
                    <h3><?php echo $core_courses; ?></h3>
                    <p>Core Courses</p>
                </div>
                <div class="card">
                    <h3><?php echo $elective_courses; ?></h3>
                    <p>Elective Courses</p>
                </div>
            </div>

            <h2>Welcome, <?php echo htmlspecialchars($user['firstname']);?></h2>
            <h4>Your Details:</h4>
            <table>
                <tr><th>Matric Number</th><td><?php echo htmlspecialchars($user['matric_no']);?></td></tr>
                <tr><th>First Name</th><td><?php echo htmlspecialchars($user['firstname']);?></td></tr>
                <tr><th>Last Name</th><td><?php echo htmlspecialchars($user['lastname']);?></td></tr>
                <tr><th>Email</th><td><?php echo htmlspecialchars($user['email']);?></td></tr>
                <tr><th>Gender</th><td><?php echo htmlspecialchars($user['gender']);?></td></tr>
                <tr><th>Phone</th><td><?php echo htmlspecialchars($user['phone']);?></td></tr>
                <tr><th>Date of Birth</th><td><?php echo htmlspecialchars($user['dob']);?></td></tr>
                <tr><th>Address</th><td><?php echo htmlspecialchars($user['address']);?></td></tr>
                <tr><th>Programme</th><td><?php echo htmlspecialchars($user['programme']);?></td></tr>
                <tr><th>Faculty</th><td><?php echo htmlspecialchars($user['faculty']);?></td></tr>
                <tr><th>Department</th><td><?php echo htmlspecialchars($user['department']);?></td></tr>
                <tr><th>Level</th><td><?php echo htmlspecialchars($user['level']);?></td></tr>
                <tr><th>Entry Year</th><td><?php echo htmlspecialchars($user['entry_year']);?></td></tr>
            </table>
        </div>
    </div>

</body>
</html>