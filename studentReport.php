<?php
session_start();

// Start HTML output
echo "<!DOCTYPE html>
<html>
<head>
    <title>Marks Display</title>
    <link href='Css/main.css' rel='stylesheet'>
</head>
<body>";

// Database connection
include 'Connection.php';

$c = $_SESSION['Course'];
$ct = '';
$u = $_POST['t5'];

// Determine the table based on the course
switch ($c) {
    case 'JS':
        $ct = "jsmarks";
        break;
    case 'SE':
        $ct = "semarks";
        break;
    case 'ACN':
        $ct = "acnmarks";
        break;
    case 'JAVA':
        $ct = "javamarks";
        break;
    case 'NMA':
        $ct = "nmamarks";
        break;
    default:
        die("Invalid course");
}

// Use a prepared statement to prevent SQL injection
$sql = $dbLink->prepare("SELECT * FROM $ct WHERE Enrollment_no = ?");
$sql->bind_param("s", $u);
$sql->execute();
$res = $sql->get_result();

if ($res) {
    if ($res->num_rows == 0) {
        echo "<p>There are no files in the database</p>";
    } else {
        echo "<table width='100%'>
        <tr>
        <td><b>Enrollment_no</b></td>
        <td><b>Assignment Id</b></td>
        <td><b>Marks</b></td>
        <td><b>&nbsp;</b></td>
        </tr>";
        
        // Open file for writing
        $my_file = $u . '.txt';
        $handle = fopen($my_file, 'w') or die('Cannot open file: ' . $my_file);
        
        while ($row = $res->fetch_assoc()) {
            echo "<tr>
            <td><b>" . htmlspecialchars($row['Enrollment_no']) . "</b></td>
            <td><b>" . htmlspecialchars($row['Id']) . "</b></td>
            <td><b>" . htmlspecialchars($row['Marks']) . "</b></td>
            </tr>";
            
            // Write data to the file
            fwrite($handle, "Enrollment_no: " . $row['Enrollment_no'] . "\n");
            fwrite($handle, "Assignment Id: " . $row['Id'] . "\n");
            fwrite($handle, "Marks: " . $row['Marks'] . "\n\n");
        }
        
        // Close the file
        fclose($handle);
        
        echo "</table>";
    }
} else {
    echo "<p>Error in query execution</p>";
}

$sql->close();
$dbLink->close();

echo "</body></html>";
?>
