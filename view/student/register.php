<?php
require_once('../../controller/student/StudentAuthController.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Student Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 40px;
            margin: 0;
        }

        .form-container {
            max-width: 600px;
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

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 3px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
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
            font-size: 15px;
            margin-bottom: 15px;
            text-align: center;
        }

        .error {
            color: red;
            font-size: 14px;
        }

        p {
            text-align: center;
            margin-top: 20px;
        }

        a {
            color: #007BFF;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Student Registration</h2>

        <?php if (!empty($success)): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <label>First Name <span class = "error">*</span></label>
            <input type="text" name="firstname" required>

            <label>Last Name <span class = "error">*</span></label>
            <input type="text" name="lastname" required>

            <label>Email <span class = "error">*</span></label>
            <input type="email" name="email" required>

            <label>Password <span class = "error">*</span></label>
            <input type="password" name="password" required>

            <label>Gender <span class = "error">*</span></label>
            <select name="gender" required>
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>

            <label>Date of Birth <span class = "error">*</span></label>
            <input type="date" name="dob" required>

            <label>Phone <span class = "error">*</span></label>
            <input type="text" name="phone" required>

            <label>Address <span class = "error">*</span></label>
            <textarea name="address" rows="3" required></textarea>

            <label>Programme <span class = "error">*</span></label>
            <select name="programme" required>
                <option value="">Select Programme</option>
                <option value="BSc">BSc</option>
                <option value="MSc">MSc</option>
                <option value="PhD">PhD</option>
            </select>

            <label>Matric Number <span class = "error">*</span></label>
            <input type="text" name="matric_no" required>

            <label>Faculty <span class = "error">*</span></label>
            <select name="faculty" required>
                <option value="">Select Faculty</option>
                <option value="Science">Science</option>
                <option value="Arts">Arts</option>
                <option value="Engineering">Engineering</option>
                <option value="Business">Business</option>
                <option value="Education">Education</option>
            </select>

            <label>Department <span class = "error">*</span></label>
            <input type="text" name="department" required>

            <label>Level <span class = "error">*</span></label>
            <select name="level" required>
                <option value="">Select Level</option>
                <option value="100">100</option>
                <option value="200">200</option>
                <option value="300">300</option>
                <option value="400">400</option>
                <option value="500">500</option>
            </select>

            <label>Entry Year <span class = "error">*</span></label>
            <input type="number" name="entry_year" min="2005" max="2025" required>

            <input type="hidden" name="register" value="1">

            <input type="submit" value="Register">

            <p>Already have an account? <a href="login.php">Login here</a></p>
        </form>
    </div>
</body>
</html>