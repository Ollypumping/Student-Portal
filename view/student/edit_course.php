<?php
require_once('../../controller/student/CourseController.php');
include('../../controller/student/CourseRegController.php');
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Registered Course</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .sidebar {
            width: 220px;
            background-color: #004080;
            height: 100vh;
            padding-top: 30px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: fixed;
            top: 0;
            left: 0;
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
            transition: background 0.3s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #0066cc;
            border-left: 4px solid #ffcc00;
        }

        .sidebar form {
            padding: 20px;
        }

        .logout-btn {
            background-color: #f44336;
            width: 100%;
            border: none;
            color: white;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            margin-bottom : 20px;
        }

        .logout-btn:hover {
            background-color: #d32f2f;
        }

        .main-content {
            margin-left: 220px;
            padding: 40px;
            width: 100%;
        }

        .container {
            max-width: 500px;
            margin: auto;
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        .success {
            color: #28a745;
            font-weight: bold;
            margin-bottom: 15px;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
        }

        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fafafa;
            font-size: 16px;
        }

        input[type="submit"] {
            width: 100%;
            background-color: #007bff;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        @media screen and (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 20px;
            }

            .sidebar {
                width: 100%;
                height: auto;
                flex-direction: row;
                overflow-x: auto;
                padding: 10px 0;
            }

            .sidebar a, .sidebar form {
                display: inline-block;
                margin-right: 10px;
            }

            .container {
                margin-top: 20px;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div>
            <div class="sidebar-header">Student Portal</div>
            <a href="dashboard.php" class="<?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">Dashboard</a>
            <a href="my_courses.php" class="<?php echo ($current_page == 'my_courses.php' || $current_page == 'edit_course.php') ? 'active' : ''; ?>">My Courses</a>
            <a href="course_list.php" class="<?php echo ($current_page == 'course_list.php') ? 'active' : ''; ?>">Course Registration</a>
            <a href="edit_profile.php" class="<?php echo ($current_page == 'edit_profile.php') ? 'active' : ''; ?>">Edit Profile</a>
        </div>
        <form method="POST" action="logout.php">
            <input type="submit" class="logout-btn" value="Logout">
        </form>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <h2>Edit Course Registration</h2>

            <?php if (!empty($success)) echo "<p class='success'>$success</p>"; ?>

            <form method="POST" action="">
            <label>Select a course to switch to:</label>
            <select name="new_course_id" required>
                <option value="">-- Choose a new course --</option>

                <!-- Current course -->
                <option value="<?php echo $current['course_id']; ?>" selected>
                    <?php echo $course_info['course_code'] . " - " . $course_info['course_title']; ?>
                </option>

                <?php while ($course = $course_options->fetch_assoc()): ?>
                    <option value="<?php echo $course['id']; ?>">
                        <?php echo $course['course_code'] . " - " . $course['course_title']; ?>
                    </option>
                <?php endwhile; ?>
            </select>

                <input type="submit" value="Update Course">
                <input type =  "hidden" name = "edit_course_id" value = "1">
            </form>

            <a class="back-link" href="my_courses.php">← Back to My Courses</a>
        </div>
    </div>
</body>
</html>