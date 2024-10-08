<?php
session_start();

// Database configuration
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "student_tracking";

// Create connection
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Prepare and bind
    // Include last_name in the SELECT statement
    $stmt = $conn->prepare("SELECT password, last_name, role, section, program FROM student WHERE username = ?");
    $stmt->bind_param("s", $username);
    
    // Execute and store result
    $stmt->execute();
    $stmt->store_result();
    
    // Check if username exists
    if ($stmt->num_rows > 0) {
        // Bind the result variables
        $stmt->bind_result($db_password, $last_name, $role, $section, $program);
        $stmt->fetch();
        
        // Check if the password is hashed
        if (password_needs_rehash($db_password, PASSWORD_DEFAULT)) {
            // If rehashing is needed, consider it as not hashed
            if ($password === $db_password) {
                // Password is correct, set session variables
                $_SESSION['username'] = $username;
                $_SESSION['last_name'] = $last_name; // Add last name to session
                $_SESSION['role'] = $role;
                $_SESSION['section'] = $section; // Add section to session
                $_SESSION['program'] = $program; // Add program to session
                
                // Redirect based on role
                if ($role === 'admin') {
                    header("Location: home.html");
                    exit();
                } elseif ($role === 'student') {
                    header("Location: profile.php"); // Change to profile.php
                    exit();
                } else {
                    // Undefined role
                    echo "<script>alert('Undefined user role.'); window.location.href='signin.html';</script>";
                }
            } else {
                // Incorrect password
                echo "<script>alert('Invalid username or password. Please try again.'); window.location.href='signin.html';</script>";
            }
        } else {
            // If the password is hashed, use password_verify
            if (password_verify($password, $db_password)) {
                // Password is correct, set session variables
                $_SESSION['username'] = $username;
                $_SESSION['last_name'] = $last_name; // Add last name to session
                $_SESSION['role'] = $role;
                $_SESSION['section'] = $section; // Add section to session
                $_SESSION['program'] = $program; // Add program to session
                
                // Redirect based on role
                if ($role === 'admin') {
                    header("Location: home.html");
                    exit();
                } elseif ($role === 'student') {
                    header("Location: profile.php"); // Change to profile.php
                    exit();
                } else {
                    // Undefined role
                    echo "<script>alert('Undefined user role.'); window.location.href='signin.html';</script>";
                }
            } else {
                // Incorrect password
                echo "<script>alert('Invalid username or password. Please try again.'); window.location.href='signin.html';</script>";
            }
        }
    } else {
        // Username doesn't exist
        echo "<script>alert('Invalid username or password. Please try again.'); window.location.href='signin.html';</script>";
    }
    
    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    // If not a POST request, redirect to sign-in page
    header("Location: signin.html");
    exit();
}
