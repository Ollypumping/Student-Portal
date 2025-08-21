<?php
require_once('../../controller/student/StudentProfileController.php');
$success = $_SESSION['success'] ?? '';
unset($_SESSION['success']);
$current_page = basename($_SERVER['PHP_SELF']);
$profile_pic = $user['profile_pic'] ?? '../../uploads/picture.jpg';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
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
            background-color: #f44336 !important    ;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }

        .main-content {
            margin-left: 220px;
            padding: 40px;
            width: 100%;
        }

        .container {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            margin-top: 20px;
            font-weight: bold;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #c3e6cb;
        }

        img {
            display: block;
            margin: 10px auto;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #004080;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-header">Student Portal</div>
    <a href="dashboard.php" class="<?= $current_page == 'dashboard.php' ? 'active' : '' ?>">Dashboard</a>
    <a href="my_courses.php" class="<?= $current_page == 'my_courses.php' ? 'active' : '' ?>">My Courses</a>
    <a href="course_list.php" class="<?= $current_page == 'course_list.php' ? 'active' : '' ?>">Course Registration</a>
    <a href="edit_profile.php" class="<?= $current_page == 'edit_profile.php' ? 'active' : '' ?>">Edit Profile</a>
    <a href="change_password.php" class="<?= $current_page == 'change_password.php' ? 'active' : '' ?>">Change Password</a>
    <form method="POST" action="logout.php">
        <input type="submit" class="logout-btn" value="Logout">
    </form>
</div>

<div class="main-content">
    <div class="container">
        <h2>Edit Profile</h2>
        <?php if (!empty($success)) echo "<div class='success'>$success</div>"; ?>
        <form method="POST" enctype="multipart/form-data" action="../../controller/student/StudentProfileController.php">
            <label>First Name:</label>
            <input type="text" name="firstname" value="<?= htmlspecialchars($user['firstname']) ?>">

            <label>Last Name:</label>
            <input type="text" name="lastname" value="<?= htmlspecialchars($user['lastname']) ?>">

            <label>Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>">

            <label>Phone:</label>
            <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>">

            <label>Gender:</label>
            <select name="gender">
                <option value="Male" <?= ($user['gender'] == "Male") ? 'selected' : '' ?>>Male</option>
                <option value="Female" <?= ($user['gender'] == "Female") ? 'selected' : '' ?>>Female</option>
            </select>

            <label>Date of Birth:</label>
            <input type="date" name="dob" value="<?= htmlspecialchars($user['dob']) ?>">

            <label>Address:</label>
            <textarea name="address"><?= htmlspecialchars($user['address']) ?></textarea>

            <label>Matric No:</label>
            <input type="text" name="matric_no" value="<?= htmlspecialchars($user['matric_no']) ?>">

            <label>Department:</label>
            <input type="text" name="department" value="<?= htmlspecialchars($user['department']) ?>">

            <label>Faculty:</label>
            <input type="text" name="faculty" value="<?= htmlspecialchars($user['faculty']) ?>">

            <label>Programme:</label>
            <input type="text" name="programme" value="<?= htmlspecialchars($user['programme']) ?>">

            <label>Entry Year:</label>
            <input type="number" name="entry_year" value="<?= htmlspecialchars($user['entry_year']) ?>">

            <label>Level:</label>
            <input type="text" name="level" value="<?= htmlspecialchars($user['level']) ?>">

            <label>Change Profile Picture:</label>
            <input type="file" name="profile_pic">
            <img src="<?= htmlspecialchars($profile_pic) ?>" alt="Profile Picture">

            <!-- <input type="hidden" name="edit_profile" value="1"> -->

            <input type="submit" value="Update Profile">
        </form>
    </div>
</div>

</body>
</html>