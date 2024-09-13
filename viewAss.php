<?php 
session_start();
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
$sql = "SELECT * FROM $c";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title> Fetch Data From Database </title>
    <link rel="stylesheet" type="text/css" href="Css/main.css">
</head>
<body>
    <table align="center" border="1px">
        <tr>
            <th colspan="3"><h2>Assignments</h2></th>
        </tr>
        <tr>
            <th>Assi_No</th>
            <th>Aim</th>
            <th>Hrs</th>
        </tr>
       
        <?php 
        if ($result->num_rows > 0) {
            while($rows = $result->fetch_assoc()) {
                $assi_no = isset($rows['Assi_no']) ? $rows['Assi_no'] : 'N/A';
                $aim = isset($rows['Aim']) ? $rows['Aim'] : 'N/A';
                $hrs = isset($rows['Hrs']) ? $rows['Hrs'] : 'N/A';
        ?>        
            <tr>
                <td><?php echo htmlspecialchars($assi_no); ?></td>
                <td><?php echo htmlspecialchars($aim); ?></td>
                <td><?php echo htmlspecialchars($hrs); ?></td>
            </tr>
        <?php  
            }
        } else {
            echo "<tr><td colspan='3'>No data found</td></tr>";
        }
        ?>    
    </table>
</body>
</html>
