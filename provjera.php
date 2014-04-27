<?php 
	$odgovor = $_POST['odgovor'];
	$pitanje = $_POST['pitanje'];
	$pitanje = htmlspecialchars($pitanje);
	$odgovor = htmlspecialchars($odgovor);
	$con = mysql_connect("localhost","root","");
	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db("dwadb", $con);
	mysql_query("SET NAMES utf8;");
	$result = mysql_query("SELECT * FROM pitanja WHERE Pitanje = '".$pitanje."'");
	$row = mysql_fetch_array($result);
	if(strcmp($row['Tocni_odgovor'],$odgovor) == 0)
	{
		echo "<p style='font-size:40px'><img src='slike/kvacica.png' alt='kvacica' height='40' width='40' />";
		echo " Odgovor je točan! Osvojili ste ".$row['Bodovi']." bod(a).</p>";
		echo "<p style='display:none;' id='bodovi'>".$row['Bodovi']."</p>";	
	}
	else
	{
		echo "<p style='font-size:40px'><img src='slike/error.jpg' alt='kvacica' height='40' width='40' />";
		echo " Odgovor je kriv! Izgubili ste 1 bod.</p>";
		echo "<p style='display:none;' id='bodovi'>-1</p>";	
	}
	
	echo "<button id='makni_div'>OK</button>"
?>