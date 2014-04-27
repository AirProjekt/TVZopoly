<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Registracija</title>
<body bgcolor="#FFFFCC">
<?php
$izlaz = <<< EOT
		<div class="box3">
		<form action="register.php" method="post">
			<fieldset>
			<p class="notice">Please fill out this short registration form to make a valid TVZopoly account.</p>
			<legend>Register</legend>
			<p><label>Username: </label><input type="text" name="username" /></p>
			<p><label>Password: </label><input type="password" name="password" /></p>
			<input class="register-button" type="submit" value="Register" /> 
			</fieldset>
		</form>
		</div>
EOT;
if(!isset($_POST['username']) && !isset($_POST['password']) ){
	echo $izlaz;
	echo "<div class='result'>Za povratak na prijavu pritisnite <a href='login.php'>ovdje</a>.</div>";
}
else{
	$username = $_POST['username'];
	$password = $_POST['password'];
	$real_username = addslashes($username);
	$real_password = addslashes($password);
	$real_username = strip_tags($real_username);
	$real_password = strip_tags($real_password);
	$real_username = htmlspecialchars($real_username);
	$real_password = htmlspecialchars($real_password);
	if(empty($real_username)|| empty($real_password)){
			echo $izlaz;
			echo "<div class='result'><img src='slike/fail.png' height='70' width='70' alt='fail' /><br>Prazan tekst nije dozvoljen za unos! Pokušajte ponovno.<br>";
			echo "Za povratak na prijavu pritisnite <a href='login.php'>ovdje</a>.</div>";
			
	}
	else if(strcmp($username,$real_username) == 0 && strcmp($password,$real_password) == 0){
		$con = mysql_connect("localhost","root","");
		if (!$con)
		{
		  die('Could not connect: ' . mysql_error());
		}
		
		mysql_select_db("dwadb", $con);
		
		$query = "INSERT INTO korisnik VALUES('".$real_username."',MD5('".$real_password."'));";
		
		if (!mysql_query($query,$con))
		{
		  echo $izlaz;
		  echo "<div class='result'><img src='slike/fail.png' height='70' width='70' alt='fail' /><br>Korisničko ime koje ste unijeli več postoji.Pokusajte s drugim imenom.<br>";
		  echo "Za povratak na prijavu pritisnite <a href='login.php'>ovdje</a>.</div>";
		}
		else
		{
			$registracija_izlaz = <<< EOT
								<div class="result"><img src='slike/regsuccess.jpg' height='70' width='70' alt='success' /><br>Registracija uspješna!<br>Za povratak na prijavu pritisnite <a href="login.php" >ovdje</a>.</div>
EOT;
			echo $izlaz;
			echo $registracija_izlaz;
		}
		
		mysql_close($con);
			
	}
	else{
		echo $izlaz;
		echo "<div class='result'><img src='slike/fail.png' height='70' width='70' alt='fail' /><br>Unijeli ste nedozvoljene znakove!Pokusajte ponovno.<br>";
		echo "Za povratak na prijavu pritisnite <a href='login.php'>ovdje</a>.</div>";	
	}
}
?>
</body>
</html>













