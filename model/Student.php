<?php
include('../../config/config.php'); // Include database connection


class Student
{
    public $conn;

    // Constructor to receive database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Fetch a single student by ID
    public function getStudentById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM students WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Fetch all students with role 'student'
    public function getAllStudents()
    {
        $sql = "SELECT * FROM students WHERE role = 'student' ORDER BY firstname ASC";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function register($data) {
        // Sanitize and validate data
        $firstname = htmlspecialchars(trim($data['firstname']));
        $lastname = htmlspecialchars(trim($data['lastname']));
        $email = filter_var(trim($data['email']), FILTER_VALIDATE_EMAIL);
        $gender = htmlspecialchars(trim($data['gender']));
        $dob = date("Y-m-d", strtotime(trim($data['dob'])));
        $phone = htmlspecialchars(trim($data['phone']));
        $password = password_hash(trim($data['password']), PASSWORD_DEFAULT);
        $address = htmlspecialchars(trim($data['address']));
        $matric_no = strtoupper(trim($data['matric_no']));
        $department = htmlspecialchars(trim($data['department']));
        $level = htmlspecialchars(trim($data['level']));
        $programme = htmlspecialchars(trim($data['programme']));
        $faculty = htmlspecialchars(trim($data['faculty']));
        $entry_year = htmlspecialchars(trim($data['entry_year']));
    
        // Check if user already exists
        $check = $this->conn->prepare("SELECT id FROM students WHERE email = ? OR matric_no = ?");
        $check->bind_param("ss", $email, $matric_no);
        $check->execute();
        $result = $check->get_result();
        if ($result->num_rows > 0) {
            return "A user with this email or matric number already exists.";
        }
    
        // Insert new user
        $stmt = $this->conn->prepare("INSERT INTO students 
            (firstname, lastname, email, password, gender, phone, dob, address, matric_no, department, level, programme, faculty, entry_year, role) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'student')");
        
        $stmt->bind_param("sssssssssssssss", 
            $firstname, $lastname, $email, $password, $gender, $phone, $dob, $address,
            $matric_no, $department, $level, $programme, $faculty, $entry_year
        );
    
        return $stmt->execute() ? true : "Registration failed: " . $stmt->error;
    }

    // Update student profile
    public function updateStudentProfile($userId, $data, $file = null) {
        $firstname   = trim($data['firstname'] ?? '');
        $lastname    = trim($data['lastname'] ?? '');
        $email       = trim($data['email'] ?? '');
        $gender      = trim($data['gender'] ?? '');
        $dob         = trim($data['dob'] ?? '');
        $phone       = trim($data['phone'] ?? '');
        $address     = trim($data['address'] ?? '');
        $matric_no   = trim($data['matric_no'] ?? '');
        $department  = trim($data['department'] ?? '');
        $level       = trim($data['level'] ?? '');
        $programme   = trim($data['programme'] ?? '');
        $faculty     = trim($data['faculty'] ?? '');
        $entry_year  = trim($data['entry_year'] ?? '');
    
        $profilePicPath = null;
    
        // Handle profile picture upload
        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            $uploadDir = "../../uploads/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
    
            $filename = uniqid() . '_' . basename($file['name']);
            $targetPath = $uploadDir . $filename;
    
            if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                $profilePicPath = "uploads/" . $filename;
            }
        }
    
        // SQL query
        $query = "
            UPDATE students SET
                firstname = ?,
                lastname = ?,
                email = ?,
                gender = ?,
                dob = ?,
                phone = ?,
                address = ?,
                matric_no = ?,
                department = ?,
                level = ?,
                programme = ?,
                faculty = ?,
                entry_year = ?
        ";
    
        $params = [
            $firstname, $lastname, $email, $gender, $dob, $phone, $address,
            $matric_no, $department, $level, $programme, $faculty, $entry_year
        ];
    
        if ($profilePicPath) {
            $query .= ", profile_pic = ?";
            $params[] = $profilePicPath;
        }
    
        $query .= " WHERE id = ?";
        $params[] = $userId;
    
        $stmt = $this->conn->prepare($query);
    
        $types = str_repeat("s", count($params) - 1) . "i"; // 's' for strings, 'i' for user ID
        $stmt->bind_param($types, ...$params);
    
        return $stmt->execute();
    }
    

    // Login method
    public function login($login_id, $password)
    {
        $login_id = trim($login_id);

        // Query user by email or matric_no regardless of role
        $stmt = $this->conn->prepare("SELECT * FROM students WHERE email = ? OR matric_no = ?");
        $stmt->bind_param("ss", $login_id, $login_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {

                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['firstname'] = $user['firstname'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];

                // Redirect based on role
                if ($user['role'] === 'admin') {
                    header("Location: ../admin/admin_dashboard.php");
                } else {
                    header("Location: dashboard.php");
                }
                exit();
            } else {
                return "Invalid email or password.";
            }
        } else {
            return "User does not exist.";
        }
    }
    

    // Register multiple courses for a student
    public function registerCourses($user_id, $selected_courses)
    {
        $registered = 0;

        foreach ($selected_courses as $course_id) {
            $course_id = intval($course_id);

            $check = $this->conn->prepare("SELECT * FROM course_registrations WHERE user_id = ? AND course_id = ?");
            $check->bind_param("ii", $user_id, $course_id);
            $check->execute();
            $check_result = $check->get_result();

            if ($check_result->num_rows == 0) {
                $register = $this->conn->prepare("INSERT INTO course_registrations (user_id, course_id) VALUES (?, ?)");
                $register->bind_param("ii", $user_id, $course_id);
                if ($register->execute()) {
                    $registered++;
                }
                $register->close();
            }

            $check->close();
        }

        return $registered;
    }

    // Fetch unregistered courses for a student
    public function getUnregisteredCourses($user_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM courses WHERE id NOT IN (
            SELECT course_id FROM course_registrations WHERE user_id = ?
        ) ORDER BY level ASC, course_code ASC");

        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Fetch registered courses for a student
    public function getRegisteredCourses($user_id)
    {
        $stmt = $this->conn->prepare("
            SELECT 
                cr.id AS registration_id,
                c.course_code,
                c.course_title,
                c.credit_unit,
                c.semester,
                c.level,
                c.programme,
                cr.date_registered
            FROM course_registrations cr
            JOIN courses c ON cr.course_id = c.id
            WHERE cr.user_id = ?
        ");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getTotalRegisteredCourses($user_id)
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS total_courses FROM course_registrations WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        return $data['total_courses'];
    }

    public function getCourseTypes($user_id)
    {
        $stmt = $this->conn->prepare("SELECT c.credit_unit FROM course_registrations cr 
                                      JOIN courses c ON cr.course_id = c.id 
                                      WHERE cr.user_id = ?");

        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $core_courses = 0;
        $elective_courses = 0;

        while ($row = $result->fetch_assoc()) {
            $credit = strtolower($row['credit_unit']);

            if (strpos($credit, '(c)') !== false) {
                $core_courses++;
            } elseif (strpos($credit, '(e)') !== false) {
                $elective_courses++;
            }
        }

        return ['core_courses' => $core_courses, 'elective_courses' => $elective_courses];
    }

    //  FETCH one course registration info
    public function getRegistrationById($registration_id, $user_id)
    {
        $stmt = $this->conn->prepare("SELECT cr.id AS registration_id, cr.course_id, c.level, c.programme
                                      FROM course_registrations cr
                                      JOIN courses c ON cr.course_id = c.id
                                      WHERE cr.id = ? AND cr.user_id = ?");
        $stmt->bind_param("ii", $registration_id, $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
        
    }

    //  FETCH alternative courses (same level/programme, different ID)
    public function getAlternativeCourses($level, $programme, $exclude_course_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM courses WHERE level = ? AND programme = ? AND id != ?");
        $stmt->bind_param("isi", $level, $programme, $exclude_course_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    // UPDATE a registered course with a new course ID
    public function updateCourseRegistration($registration_id, $user_id, $new_course_id)
    {
        // Prevent duplicate registration
        $check = $this->conn->prepare("SELECT id FROM course_registrations WHERE user_id = ? AND course_id = ?");
        $check->bind_param("ii", $user_id, $new_course_id);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            return "You already registered for that course.";
        }

        // Proceed with update
        $stmt = $this->conn->prepare("UPDATE course_registrations SET course_id = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("iii", $new_course_id, $registration_id, $user_id);
        return $stmt->execute() ? true : "Failed to update course.";
    }

    //  Get course details by ID
    public function getCourseById($course_id)
    {
        $stmt = $this->conn->prepare("SELECT course_code, course_title FROM courses WHERE id = ?");
        $stmt->bind_param("i", $course_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function dropCourse($user_id, $registration_id) {
        // Verify ownership
        $check = $this->conn->prepare("SELECT * FROM course_registrations WHERE user_id = ? AND id = ?");
        $check->bind_param("ii", $user_id, $registration_id);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            $drop = $this->conn->prepare("DELETE FROM course_registrations WHERE user_id = ? AND id = ?");
            $drop->bind_param("ii", $user_id, $registration_id);
            $drop->execute();
            return $drop->affected_rows > 0;
        }
        return false;
    }

    public function changePassword($user_id, $current_password, $new_password, $confirm_password)
    {

        $errors = ['current' => '', 'new' => '', 'confirm' => '', 'success' => ''];

        // Validate input
        if (empty($current_password)) {
            $errors['current'] = "Current password is required";
        }
        if (empty($new_password)) {
            $errors['new'] = "New password is required";
        }
        if (empty($confirm_password)) {
            $errors['confirm'] = "Confirm password is required";
        } elseif ($new_password !== $confirm_password) {
            $errors['confirm'] = "Passwords do not match";
        }
        // Return if validation failed
        if (!empty($errors['current']) || !empty($errors['new']) || !empty($errors['confirm'])) {
            return $errors;
        }

        // Fetch the hashed password from the database
        $stmt = $this->conn->prepare("SELECT password FROM students WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        // Check if user exists and password is correct
        if (!$user || !password_verify($current_password, $user['password'])) {
            $errors['current'] = "Current password is incorrect";
            return $errors;
        }

        // Hash the new password
        $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update the password in the database
        $update = $this->conn->prepare("UPDATE students SET password = ? WHERE id = ?");
        $update->bind_param("si", $new_hashed_password, $user_id);

        if ($update->execute()) {
            $errors['success'] = "Password changed successfully!";
        } else {
            $errors['success'] = "Failed to change password.";
        }

        return $errors;
    }


    public function countTotalStudents() {
        $sql = "SELECT COUNT(*) as total FROM students WHERE role = 'student'";
        $result = $this->conn->query($sql);
        if ($result && $row = $result->fetch_assoc()) {
            return $row['total'];
        }
        return 0;
    }

    

    public function groupByEntryYear() {
        $sql = "SELECT entry_year, COUNT(*) AS total FROM students GROUP BY entry_year ORDER BY entry_year ASC";
        $result = $this->conn->query($sql);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    public function countByProgramme($programme) {
        $sql = "SELECT COUNT(*) AS total FROM students WHERE programme = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $programme);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'] ?? 0;
    }

    public function countByRole($role) {
        $sql = "SELECT COUNT(*) AS total FROM students WHERE role = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $role);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'] ?? 0;
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }
    
    
    
    
}



?>