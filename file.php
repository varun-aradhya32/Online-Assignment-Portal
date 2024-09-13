<?php
session_start();

if (isset($_POST['submit']) && !empty($_FILES['uploaded_file'])) {
    if (isset($_FILES['uploaded_file'])) {
        // Make sure the file was sent without errors
        if ($_FILES['uploaded_file']['error'] == 0) {
            // Connect to the database
            include 'Connection.php';

            // Check if the connection was successful
            if ($dbLink->connect_error) {
                die("Connection failed: " . $dbLink->connect_error);
            }

            // Reconnect to MySQL (in case the connection was closed)
            mysqli_ping($dbLink);

            $file_name = $_SESSION['User'] . $_SESSION['Course'] . $_SESSION['ass_id'];
            $en_no_db = $_SESSION['User'];

            // Gather all required data
            $name = $dbLink->real_escape_string($_FILES['uploaded_file']['name']);
            $mime = $dbLink->real_escape_string($_FILES['uploaded_file']['type']);
            $data = $dbLink->real_escape_string(file_get_contents($_FILES['uploaded_file']['tmp_name']));
            $size = intval($_FILES['uploaded_file']['size']);

            $table = $_SESSION['Course'] . "UploadedAss";

            // Create the table if it doesn't exist
            $create_table = "CREATE TABLE IF NOT EXISTS $table (
                enrollment_no VARCHAR(20) NOT NULL,
                id INT NOT NULL,
                file_name VARCHAR(255) NOT NULL,
                mime VARCHAR(50) NOT NULL,
                size BIGINT UNSIGNED NOT NULL DEFAULT 0,
                data MEDIUMBLOB NOT NULL,
                created DATETIME NOT NULL
            );";

            if ($dbLink->query($create_table) === TRUE) {
                $ifExists = "SELECT * FROM $table WHERE file_name='$name'";
                $num_rec = $dbLink->query($ifExists);

                if ($num_rec && $num_rec->num_rows == 0) {
                    $i = $_SESSION['ass_id'];

                    $query = "INSERT INTO $table (enrollment_no, id, file_name, mime, size, data, created) 
                              VALUES ('$en_no_db', '$i', '$name', '$mime', '$size', '$data', NOW())";

                    if ($dbLink->query($query) === TRUE) {
                        echo "<script type='text/javascript'>alert('Your file was successfully added!');</script>";
                    } else {
                        echo "Error! Failed to insert the file: " . $dbLink->error;
                    }
                } else {
                    echo "<script type='text/javascript'>alert('You have already submitted this assignment!');</script>";
                }
            } else {
                echo "Error creating table: " . $dbLink->error;
            }

            // Close the MySQL connection
            $dbLink->close();
        } else {
            echo "An error occurred while the file was being uploaded. Error code: " . intval($_FILES['uploaded_file']['error']);
        }
    } else {
        echo "Error! A file was not sent!";
    }
} else {
    echo "No file uploaded.";
}

// Echo a link back to the main package
echo '<p>Click <a href="#">here</a> to go back</p>';
?>
