<?php
	$predmet = $_POST['Predmet'];
	$kol = $_POST['Kolokvij'];
	if(strcmp($predmet,"Grgec") == 0){
		echo "<p style='font-size:40px'><img src='slike/error.jpg' alt='kvacica' height='40' width='40' />";
		echo " Stali ste na Grgec polje dobili ste -2 boda! :)</p>";
		echo "<button id='makni_div'>OK</button>";
		echo "<p style='display:none;' id='bodovi'>-2</p>";
	}
	else if(strcmp($predmet,"Radovan") == 0)
	{
		echo "<p style='font-size:40px'><img src='slike/kvacica.png' alt='kvacica' height='40' width='40' />";
		echo " Stali ste ne Radovan polje.Dobivate 2 boda! :)</p>";
		echo "<button id='makni_div'>OK</button>";
		echo "<p style='display:none;' id='bodovi'>2</p>";
	}
	else{
		$con = mysql_connect("localhost","root","");
		if (!$con)
		{
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db("dwadb", $con);
		mysql_query("SET NAMES utf8;");
		$result = mysql_query("SELECT * FROM pitanja WHERE Kratica = '".$predmet."' AND Kolokvij=".$kol);
		$row = mysql_fetch_array($result);
		$broj = mysql_num_rows($result);
		$broj = rand(1,$broj);
		for($i=1;$i < $broj;$i++)
		{
			$row = mysql_fetch_array($result);	
		}
		$result2 = mysql_query("SELECT * FROM krivi_odgovori WHERE Pitanje ='".$row['Pitanje']."'");
		$odgovori = array($row['Tocni_odgovor']); 
		echo "<p style='font-family:Tahoma, Geneva, sans-serif;font-size:15px;color:#F00'>".$row['Predmet']." Kol ".$kol."</p>
				<img src='slike/question-things.jpg' width='300' height='230' />
				<p id='pitanje_predmet'>".$row['Pitanje']."</p>(".$row['Bodovi']." bod)<br><br>";
		
		while($row = mysql_fetch_array($result2))
		{
			array_push($odgovori,$row['Krivi_Odgovor']);	
		}
		shuffle($odgovori);
		foreach($odgovori as $odgovor)
		{
			echo "<input type='radio' name='odgovor' value='".$odgovor."'>".$odgovor."<br><br>";	
		}
		echo "<hr />
			  <button id='provjera'>Posalji</button>";
	}
?>
