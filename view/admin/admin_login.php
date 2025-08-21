<?php
require_once('../../controller/admin/AdminController.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
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

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 3px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 15px;
        }

        .error {
            color: red;
            font-size: 13px;
        }

        .success {
            color: red;
            font-size: 15px;
            margin-bottom: 15px;
            text-align: center;
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

        p {
            margin-top: 20px;
            text-align: center;
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
        <h2>Admin Login</h2>
        <?php if ($success) echo "<p class='success'>$success</p>"; ?>
        <form method="POST" action="">
            <label>Email</label>
            <input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>">
            <span class="error"><?php echo $email_err; ?></span>

            <label>Password</label>
            <input type="password" name="password">
            <span class="error"><?php echo $password_err; ?></span>

            <input type="submit" value="Login">
            <p>Don't have an account? <a href="admin_register.php">Register here</a></p>
        </form>
    </div>
</body>
</html>