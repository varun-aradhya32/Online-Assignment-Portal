<?php 
session_start();

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "practical_table";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get course and form data from the session and POST request
$c = $_SESSION['Course'];
$ass_no = $_POST['n1'];
$aim = $_POST['aim'];
$hrs = $_POST['hrs'];
$dt_a = $_POST['d1'];
$dt_b = $_POST['d2'];
$dt_c = $_POST['d3'];

// Determine the appropriate table based on the course
$ct = '';
switch($c) {
    case 'JS':
        $ct = 'js_date';
        break;
    case 'NMA':
        $ct = 'nma_date';
        break;
    case 'ACN':
        $ct = 'acn_date';
        break;
    case 'SE':
        $ct = 'se_date';
        break;
    case 'JAVA':
        $ct = 'java_date';
        break;
    default:
        die("Invalid course");
}

// Escape the table name to prevent SQL injection
$table = $conn->real_escape_string($ct);

// Check if the assignment already exists
$query1 = $conn->prepare("SELECT * FROM $table WHERE Assi_no = ?");
$query1->bind_param("s", $ass_no);
$query1->execute();
$result1 = $query1->get_result();
$numrows = $result1->num_rows;

if ($numrows == 0) {
    // Insert the new assignment dates
    $sql = $conn->prepare("INSERT INTO $table (Assi_no, date_a, date_b, date_c, Assigned) VALUES (?, ?, ?, ?, ?)");
    $assigned = 1;
    $sql->bind_param("ssssi", $ass_no, $dt_a, $dt_b, $dt_c, $assigned);
    $result2 = $sql->execute();

    if ($result2) {
        echo "Assignment Successfully Registered!";
    } else {
        echo "Failure: " . $conn->error;
    }

    // Insert the new assignment details into the course table
    $insertAssignment = $conn->prepare("INSERT INTO $c (Assi_no, Aim, Hrs) VALUES (?, ?, ?)");
    $insertAssignment->bind_param("ssi", $ass_no, $aim, $hrs);
    $insertAssignment->execute();
    $insertAssignment->close();
} else {
    echo "Assignment already exists";
}

// Close the statement and connection
$query1->close();
if (isset($sql)) {
    $sql->close();
}
$conn->close();
?>
