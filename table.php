<?php
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

// Function to fetch unique values for dropdowns
function fetchUniqueValues($conn, $column) {
    $sql = "SELECT DISTINCT $column FROM student WHERE $column IS NOT NULL";
    $result = $conn->query($sql);
    $values = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $values[] = $row[$column];
        }
    }
    return $values;
}

// Fetch all student data with filters
$studentID = isset($_POST['studentID']) ? $_POST['studentID'] : '';
$fullName = isset($_POST['fullName']) ? $_POST['fullName'] : '';
$section = isset($_POST['section']) ? $_POST['section'] : '';
$yearLevel = isset($_POST['yearLevel']) ? $_POST['yearLevel'] : '';
$program = isset($_POST['program']) ? $_POST['program'] : '';

// Prepare SQL statement based on filter
$sql = "SELECT student_id, CONCAT(first_name, ' ', middle_name, ' ', last_name) AS full_name, section, year_level, program FROM student WHERE 1=1";

if ($studentID) {
    $sql .= " AND student_id LIKE ?";
}
if ($fullName) {
    $sql .= " AND (first_name LIKE ? OR middle_name LIKE ? OR last_name LIKE ?)";
}
if ($section) {
    $sql .= " AND section LIKE ?";
}
if ($yearLevel) {
    $sql .= " AND year_level LIKE ?";
}
if ($program) {
    $sql .= " AND program LIKE ?";
}

$stmt = $conn->prepare($sql);

// Prepare parameters for binding
$params = [];
$types = '';

if ($studentID) {
    $params[] = "%$studentID%";
    $types .= "s";
}
if ($fullName) {
    $params[] = "%$fullName%";
    $params[] = "%$fullName%"; // For middle name
    $params[] = "%$fullName%"; // For last name
    $types .= "sss";
}
if ($section) {
    $params[] = "%$section%";
    $types .= "s";
}
if ($yearLevel) {
    $params[] = "%$yearLevel%";
    $types .= "s";
}
if ($program) {
    $params[] = "%$program%";
    $types .= "s";
}

// Bind parameters if available
if ($params) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

// Fetch the results and build the table rows
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['student_id']}</td>
                <td>{$row['full_name']}</td>
                <td>{$row['section']}</td>
                <td>{$row['year_level']}</td>
                <td>{$row['program']}</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='5' class='text-center'>No results found</td></tr>";
}

$stmt->close();

// If the dropdowns need to be populated, call the fetchUniqueValues function for each column
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    echo json_encode([
        'studentID' => fetchUniqueValues($conn, 'student_id'),
        'fullName' => fetchUniqueValues($conn, 'first_name'), // Adjust as necessary to get full names
        'section' => fetchUniqueValues($conn, 'section'),
        'yearLevel' => fetchUniqueValues($conn, 'year_level'),
        'program' => fetchUniqueValues($conn, 'program'),
    ]);
}

$conn->close();
?>
