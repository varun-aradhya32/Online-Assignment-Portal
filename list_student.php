<?php
session_start();
?>
<!DOCTYPE html>

<html>
<head>
	<title></title>
	<script type="text/javascript">
		function changePass() {
			parent.f3.location.href='change.html';
		}
		function change() {
			parent.f3.location.href='actio.html';
			// body...
		}
		function course()
		{
			parent.f3.location.href='d.html';
		}
		function studentReport()
		{
			parent.f3.location.href='studentMarks.html';
		}
		function viewassignment()
		{
			parent.f3.location.href='viewAss.php';
		}
		function endSession() {
			<?php
				
//				unset($_SESSION['User']);
//				unset($_SESSION['pass']);
//				unset($_SESSION['Batch']);
//				unset($_SESSION['Course']);
				//session_unset();
				//session_destroy();
				//echo "hello";
				
			?>
			parent.location.href='t.php';

			// body...

		}
	</script>
</head>
<link rel="stylesheet" type="text/css" href="Css/button.css">

<body>
	
	
	
	<input type="submit" value="View Assignments" name="b4" onclick="viewassignment()" >
	<br>
	<input type="submit" value="Upload Assignments" name="b4" onclick="course()">
	<br>
	<input type="submit" value="Student Reports" name="b5" onclick="studentReport()" >
	<br>
	<input type="submit" value="Logout" name="b7" onclick="endSession()">
	<br>
	<input type="submit" value="Change Password" name="b7" onclick="changePass()">
	
	


</body>
</html>