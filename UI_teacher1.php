<?php
	session_start();
	?>

<!DOCTYPE html>

<html>
<head>
	<title>UI_TEACHER</title>
	<script type="text/javascript">
		
			history.pushState(null,null,location.href)
			window.onpopstate=function()
			{
				history.go(1);
			};
		
	</script>
</head>
<frameset rows="25,75">
	<frame name="f1" src="frame1.html" noresize="f1" > </frame>
<frameset cols="20,80">
	<frame name="f2" src="list_teacher.php" noresize="f2"> </frame>
	<frame name="f3" src="abc.php" noresize="f3"></frame>
	
</frameset>
</frameset>
<body>
<form>
	
</form>
</body>
</html>