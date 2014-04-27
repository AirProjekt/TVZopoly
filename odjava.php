<?php
	session_start();
	session_destroy();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Odjava</title>
</head>

<body>
	<?php 
		echo "Uspješno ste se odjavili.<br>Za povratak na prijavu pritisnite <a href='login.php'>ovdje</a>" 
	?>
</body>
</html>