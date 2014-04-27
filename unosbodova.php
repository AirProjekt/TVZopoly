<?php
session_start();
$username = $_SESSION['user'];
$highscore = $_POST['bodovi'];
$con = mysql_connect("localhost","root","");
	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db("dwadb", $con);
	mysql_query("SET NAMES utf8;");
	$result = mysql_query("SELECT * FROM bodovi WHERE Korisnicko_ime = '".$username."'");
	$row = mysql_fetch_array($result);
	$count = mysql_num_rows($result);
	if($count > 0){
		if($highscore > $row['Highscore']){
			mysql_query("UPDATE bodovi SET Highscore = ".$highscore." WHERE Korisnicko_ime = '".$username."'");	
		}	
	}
	else{
		mysql_query("INSERT INTO bodovi VALUES('".$username."',".$highscore.")");		
	}
?>