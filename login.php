<?php
session_start();
$izlaz = <<< EOT
			<div class="box2"> 
             <form action="login.php" method = "post"> 
              <fieldset class="login"> 
                <legend>Login</legend> 
                <p class="notice">Login and play TVZopoly.</p> 
                <p><label>Username: </label><input type="text" name="username" /></p> 
                <p><label>Password: </label><input type="password" name="password" /></p> 
                <input class="login-button" type="submit" value="Login" /> 
              </fieldset> 
            </form> 
            <form method="post" action="register.php"> 
              <fieldset class="login"> 
                <legend>Register</legend> 
                <p>If you do not already have an account, please create a new account to register.</p> 
                <input class="submit-button" type="submit" value="Create Account" /> 
              </fieldset> 
            </form>
		</div>
EOT;
$zaglavlje = <<< EOT
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
			<link rel="stylesheet" type="text/css" href="style.css" />
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<title>Prijava</title>
			<body bgcolor="#FFFFCC">
EOT;
if(isset($_POST['username']) && isset($_POST['password']) ){
	$username = $_POST['username'];
	$password = $_POST['password'];
	$real_username = addslashes($username);
	$real_password = addslashes($password);
	$real_username = strip_tags($real_username);
	$real_password = strip_tags($real_password);
	$real_username = htmlspecialchars($real_username);
	$real_password = htmlspecialchars($real_password);
	if(strcmp($username,$real_username) == 0 && strcmp($password,$real_password) == 0){
		$con = mysql_connect("localhost","root","");
		if (!$con)
		{
			die('Could not connect: ' . mysql_error());
		}
		$real_password = md5($real_password);
		$query = "SELECT * FROM korisnik WHERE Korisnicko_ime = '".$real_username."' AND Lozinka = '".$real_password."'";
		
		mysql_select_db("dwadb", $con);
		
		$result = mysql_query($query);
		if(mysql_num_rows($result) == 1){
			$_SESSION['user'] = $real_username;
			header('Location:/DWA_Projekt/Application_Page.php');
		}
		else{
			echo $zaglavlje;
			echo $izlaz;
			echo "<div class='result'><img src='slike/fail.png' height='70' width='70' alt='fail' /><br>Korisničko ime ili Lozinka su pogrešni.<br>Pokusajte ponovno.</div>";
		}
	}
	else{
		echo $zaglavlje;
		echo $izlaz;
		echo "<div class='result'><img src='slike/fail.png' height='70' width='70' alt='fail' /><br>Unijeli se znakove koji nisu dozvoljeni.<br>Pokusajte ponovno.</div>";	
	}
}
else{
	echo $zaglavlje;
	echo $izlaz;
}
?>	
</body>
</html>