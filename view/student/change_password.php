<?php
require_once('../../controller/student/StudentPasswordController.php');
// Get messages and then clear them
$current_password_err = $_SESSION['current_password_err'] ?? '';
$new_password_err = $_SESSION['new_password_err'] ?? '';
$confirm_password_err = $_SESSION['confirm_password_err'] ?? '';
$success = $_SESSION['change_success'] ?? '';

// Clear them so they don’t persist on reload
unset($_SESSION['current_password_err'], $_SESSION['new_password_err'], $_SESSION['confirm_password_err'], $_SESSION['change_success']);

$current_page = basename($_SERVER['PHP_SELF']);
?><!DOCTYPE html><html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            display: flex;
        }.sidebar {
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
            background-color: #f44336 !important;
            width: 100%;
            border: none;
            color: white;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .logout-btn:hover {
            background-color: #d32f2f !important;
        }

        .main-content {
            margin-left: 220px;
            padding: 40px;
            width: 100%;
        }

        .container {
            max-width: 500px;
            background: white;
            margin: auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
        }

        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 10px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            font-size: 14px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #c3e6cb;
            margin-bottom: 15px;
            text-align: center;
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
    <div class="sidebar">
        <div>
            <div class="sidebar-header">Student Portal</div>
            <a href="dashboard.php" class="<?= ($current_page == 'dashboard.php') ? 'active' : '' ?>">Dashboard</a>
            <a href="my_courses.php" class="<?= ($current_page == 'my_courses.php') ? 'active' : '' ?>">My Courses</a>
            <a href="course_list.php" class="<?= ($current_page == 'course_list.php') ? 'active' : '' ?>">Course Registration</a>
            <a href="edit_profile.php" class="<?= ($current_page == 'edit_profile.php') ? 'active' : '' ?>">Edit Profile</a>
            <a href="change_password.php" class="<?= ($current_page == 'change_password.php') ? 'active' : '' ?>">Change Password</a>
        </div>
        <form method="POST" action="logout.php">
            <input type="submit" class="logout-btn" value="Logout">
        </form>
    </div><div class="main-content">
    <div class="container">
        <h2>Change Password</h2>
        <?php if (!empty($success)) echo "<div class='success'>$success</div>"; ?>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <label>Current Password:</label>
            <input type="password" name="current_password">
            <span class="error"><?php echo $current_password_err ?? ''; ?></span>

            <label>New Password:</label>
            <input type="password" name="new_password">
            <span class="error"><?php echo $new_password_err ?? ''; ?></span>

            <label>Confirm Password:</label>
            <input type="password" name="confirm_password">
            <span class="error"><?php echo $confirm_password_err ?? ''; ?></span>

            

            <input type="submit" value="Change Password">
            
        </form>
    </div>
</div>

</body>
</html>