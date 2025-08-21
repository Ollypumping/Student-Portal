<?php
include_once('../../controller/student/CourseController.php'); //This connects it to the controller
include_once('../../controller/student/StudentController.php');
$result = $studentModel->getRegisteredCourses($user_id); // Fetch registered courses using the controller function
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Courses</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #eef1f5;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .sidebar {
            width: 220px;
            background-color: #004080;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            padding-top: 30px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            font-size: 16px;
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
            padding: 12px 20px;
            text-decoration: none;
            color: white;
            display: block;
            font-weight: normal;
            transition: background 0.3s;
        }

        .sidebar a:hover {
            background-color: #0066cc;
        }

        .sidebar a.active {
            background-color: #0066cc;
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
            width: 100%;
            background-color: #f44336 !important;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            font-weight: bold;
        }

        .logout-btn:hover {
            background-color: #d32f2f !important;
        }

        .main-content {
            margin-left: 240px;
            padding: 40px;
            flex: 1;
        }

        .course-container {
            background-color: white;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            max-width: 1000px;
            width: 100%;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        .success {
            color: green;
            font-weight: bold;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            table-layout: fixed;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
            word-wrap: break-word;
            min-width: 100px;
            max-width: 200px;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
            font-weight: bold;
            margin-right: 5px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        input[type="submit"].delete-btn {
            background-color: #f44336 !important;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"].delete-btn:hover {
            background-color: #d32f2f !important;
        }

        @media (max-width: 768px) {
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

            .course-container {
                padding: 20px;
            }

            input[type="submit"] {
                font-size: 12px;
                padding: 6px 10px;
            }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">Student Portal</div>
        <a href="dashboard.php" class="<?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">Dashboard</a>
        <a href="my_courses.php" class="<?php echo ($current_page == 'my_courses.php') ? 'active' : ''; ?>">My Courses</a>
        <a href="course_list.php" class="<?php echo ($current_page == 'course_list.php') ? 'active' : ''; ?>">Course Registration</a>
        <a href="edit_profile.php" class="<?php echo ($current_page == 'edit_profile.php') ? 'active' : ''; ?>">Edit Profile</a>
        <form method="POST" action="logout.php">
            <input type="submit" class="logout-btn" value="Logout">
        </form>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="course-container">
            <h2>My Courses</h2>
            <?php if($success): ?>
                <p class="success"><?php echo $success; ?></p>
            <?php endif; ?>

            <?php if($result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Course Code</th>
                            <th>Course Title</th>
                            <th>Credit Units</th>
                            <th>Semester</th>
                            <th>Level</th>
                            <th>Programme</th>
                            <th>Date Registered</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($course = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($course['course_code']); ?></td>
                            <td><?php echo htmlspecialchars($course['course_title']); ?></td>
                            <td><?php echo htmlspecialchars($course['credit_unit']); ?></td>
                            <td><?php echo htmlspecialchars($course['semester']); ?></td>
                            <td><?php echo htmlspecialchars($course['level']); ?></td>
                            <td><?php echo htmlspecialchars($course['programme']); ?></td>
                            <td><?php echo htmlspecialchars($course['date_registered']); ?></td>
                            <td>
                                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                    <form method="POST" action="" style="display:inline;">
                                        <input type="hidden" name="registration_id" value="<?php echo $course['registration_id']; ?>">
                                        <input type="submit" value="Delete" class="delete-btn" onclick="return confirm('Are you sure you want to drop this course?');">
                                    </form>
                                    <form method="GET" action="edit_course.php" style="display:inline;">
                                        <input type="hidden" name="registration_id" value="<?php echo $course['registration_id']; ?>">
                                        <input type="submit" value="Edit">
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No courses registered yet.</p>
            <?php endif; ?>

            <p>To register for more courses, <a href="course_list.php">click here</a>.</p>
            <p>Back to your dashboard, <a href="dashboard.php">click here</a>.</p>
        </div>
    </div>

</body>
</html>