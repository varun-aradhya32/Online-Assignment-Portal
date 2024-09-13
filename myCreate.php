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

$c = $_SESSION['Course'];

// Prepare and execute the query
$query = $conn->prepare("SELECT Assi_no, Aim, Hrs FROM $c");
$query->execute();
$result = $query->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Fetch Data From Database</title>
    <link rel="stylesheet" type="text/css" href="Css/main.css">
    <link rel="stylesheet" type="text/css" href="Css/button.css">
</head>
<body>
    <form action="save.php" method="POST">
        
        <table align="center">
            <tr>
                <td>Enter Assignment Number:</td>
                <td><input type="number" name="n1" required></td>
            </tr>
            <tr>
                <td>Enter Aim:</td>
                <td><input type="text" name="aim" required></td>
            </tr>
            <tr>
                <td>Enter Hours:</td>
                <td><input type="number" name="hrs" required></td>
            </tr>
            <tr>
                <td>Enter Date for batch 1:</td>
                <td><input type="date" name="d1" required></td>
            </tr>
            <tr>
                <td>Enter Date for batch 2:</td>
                <td><input type="date" name="d2" required></td>
            </tr>
            <tr>
                <td>Enter Date for batch 3:</td>
                <td><input type="date" name="d3" required></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="Save"></td>    
            </tr>
        </table>
    </form>
</body>
</html>

<?php
// Close the statement and connection
$query->close();
$conn->close();
?>
