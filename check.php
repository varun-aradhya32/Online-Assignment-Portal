<?php
session_start();
include 'Connection1.php'; // Ensure this file correctly sets up $conn

$c = $_SESSION['Course'];
$ass_no = $_POST['field1'] ?? ''; // Use null coalescing operator to handle missing POST data

// Determine the assignment table based on the course
switch ($c) {
    case 'JS':
        $ct = 'js';
        break;
    case 'NMA':
        $ct = 'nma';
        break;
    case 'ACN':
        $ct = 'acn';
        break;
    case 'SE':
        $ct = 'se';
        break;
    case 'JAVA':
        $ct = 'java';
        break;
    default:
        die('Invalid course');
}

// Prepare and execute query to get Aim
$stmt = $conn->prepare("SELECT Aim FROM $ct WHERE Assi_no = ?");
$stmt->bind_param('s', $ass_no);
$stmt->execute();
$res = $stmt->get_result();

// Fetch and display Aim
if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $aim = $row['Aim'];
} else {
    $aim = "SORRY!! ASSIGNMENT NOT FOUND";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Assignment Aim</title>
    <link rel="stylesheet" type="text/css" href="Css/s2.css">
</head>
<body>
<div class="form-style-6">
    <h1>Aim:</h1>
    <input type="text" size="200" name="a" value="<?php echo htmlspecialchars($aim, ENT_QUOTES, 'UTF-8'); ?>" disabled>
</div>
</body>
</html>
