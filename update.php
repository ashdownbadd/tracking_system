<?php
// Database connection
$host = "localhost"; // Change if different
$dbUsername = "root"; // Change if different
$dbPassword = ""; // Change if different
$dbname = "student_tracking"; // Your database name

$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = $_POST['email'];
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $extension = $_POST['extension'];
    $mobilenumber = $_POST['mobilenumber'];
    $studentnumber = $_POST['studentnumber'];
    $yearlevel = $_POST['yearlevel'];
    $section = $_POST['section'];
    $program = $_POST['program'];
    $emergencyname = $_POST['fullname'];
    $emergencymobilenumber = $_POST['emergencymobilenumber'];
    
    // New fields
    $role = "student"; // Default role; adjust if needed
    $username = $_POST['username']; // Assuming you added a username field in the HTML form
    $password = $_POST['password']; // Assuming you added a password field in the HTML form
    
    // Hash the password before storing
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // SQL query to insert data
    $sql = "INSERT INTO student (student_id, last_name, first_name, middle_name, extension, mobile_no, email, year_level, section, program, emergency_name, emergency_no, role, username, password)
    VALUES ('$studentnumber', '$lastname', '$firstname', '$middlename', '$extension', '$mobilenumber', '$email', '$yearlevel', '$section', '$program', '$emergencyname', '$emergencymobilenumber', '$role', '$username', '$hashedPassword')";

    // Execute query
    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>
