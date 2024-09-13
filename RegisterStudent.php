<!DOCTYPE html>
<html>
<head>
    <title>Register Student to Course</title>
    <link rel="stylesheet" type="text/css" href="Css/admin.css">
</head>
<body>
<form action="RegisterStudent.php" method="post">
    <table>
        <tr><td>Course Name:</td><td><input type="text" name="course_name"></td></tr>
        <tr><td>Course Code:</td><td><select name="course_code">
            <option value="CM485">CM485</option>
            <option value="CM585">CM585</option>
            <option value="CM282">CM282</option>
            <option value="CM181">CM181</option>
        </select></td></tr>
        <tr><td>Enrollment No:</td><td><input type="number" name="en_no"></td></tr>
        <tr><td colspan="2"><input type="submit" name="submit" value="REGISTER"></td></tr>
    </table>
</form>
<a href="view_ass.php"><button name="view">View Assignments</button></a>
</body>
</html>

<?php
session_start();

$dum_en_no = isset($_SESSION['en_no']) ? $_SESSION['en_no'] : null;
$dum_course = isset($_SESSION["course"]) ? $_SESSION["course"] : null;

$_SESSION["en_no1"] = $dum_en_no;
$_SESSION["course1"] = $dum_course;

if(isset($_POST["submit"])) {
    $course = isset($_POST['course_name']) ? $_POST['course_name'] : null;
    $course_code = isset($_POST['course_code']) ? $_POST['course_code'] : null;
    $en_no = isset($_POST['en_no']) ? $_POST['en_no'] : null;

    if(!empty($course) && !empty($course_code) && !empty($en_no)) {
        $con = new mysqli('127.0.0.1', 'root', '', 'project_2k19');
        if(mysqli_connect_errno()) {
            die("MySQL connection failed: ". mysqli_connect_error());
        }

        $query_course = mysqli_query($con, "SELECT * FROM course WHERE course_code='".$course_code."'");
        $numrows1 = mysqli_num_rows($query_course);
        if($numrows1 != 0) {
            $row = mysqli_fetch_assoc($query_course);
            $mycourse = $row['course_name'];
            $course_name = $row['course_code'];

            if($course_name == $_SESSION["course"]) {
                $table = $row['course_name']."StudentList";
                $create_table = "CREATE TABLE IF NOT EXISTS ".$table." (
                    enrollment_no VARCHAR(20) NOT NULL,
                    no_ass_submitted INT(5),
                    course_code VARCHAR(7) REFERENCES course(course_code),
                    PRIMARY KEY (enrollment_no)
                );";

                $created = mysqli_query($con, $create_table);
                if($created) {
                    $query1 = mysqli_query($con, "SELECT * FROM ".$table." WHERE enrollment_no='".$en_no."'");
                    $numrows = mysqli_num_rows($query1);
                    if($numrows == 0) {
                        $sql = "INSERT INTO ".$table." (enrollment_no, no_ass_submitted, course_code) VALUES ('$en_no', 0, '$course_code')";
                        $result = mysqli_query($con, $sql);
                        if($result) {
                            echo "Student Successfully Registered!";
                        } else {   
                            echo "Failure!";
                        }
                    } else {
                        echo "Student already registered!";
                    }
                } else {   
                    echo "Error creating table!";
                }
            } else {
                echo "Course code does not match session course!";
            }
        } else {
            echo "Course does not exist!";
        }
    } else {
        echo "All fields are required!";
    }
}
?>
