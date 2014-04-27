<?php 
	session_start();
	if(!isset($_SESSION['user'])){
		header("Location:error.php");
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tvzopoly Game</title>
<style type="text/css">
	.main
	{
		background-image:url('slike/bg17.jpg');
		z-index:0;
		height:1900px;
		left:0px;
		top:0px;
	}
	
	.logo
	{
		position:absolute;
		left:40%;
			
	}
	.polozaj
	{
		display:none;
		z-index:-1;
	}
	
	.slikakocke
	{
		position:fixed;
		right:20px;
		top: 110px; 
	}
	
	.result 
	{
		font-family: 'Palatino Linotype', 'Book Antiqua', Palatino, serif;
		color:#C33;
		font-size:35px;
		position:absolute;
		left:15px;
		top:10px;
	}
	
	.odjava
	{
		position:absolute;
		right:20px;
		top:30px;
	}
	
	.ranglista
	{
		position:absolute;
		top:30px;
		right:100px;
	}
	
</style>
<script type="text/javascript" src="jquery-1.6.1.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
 		$("#bacikocku").click(function(){
				$('#bacikocku').attr('disabled', 'disabled');
				var prosliBroj = $("#kocka").html();
				prosliBroj = Number(prosliBroj);
				var randomnumber=Math.floor((Math.random()*6))+1;
				alert("Dobili ste broj "+randomnumber);
				randomnumber += prosliBroj;
				if(randomnumber <= 56){
					var Predmet = $("#"+randomnumber).html();
					var Kratica = Predmet.substring(0,Predmet.indexOf("<"));
					var Kolokvij = Predmet.charAt(Predmet.length -2);
				}
				else{
					randomnumber = 57;
					var highscore = $("#bodovno_stanje").html();
					$.ajax({url:"unosbodova.php",
								   type:"POST",
								   data:"bodovi="+highscore,
								   success:function(data){
								   }
					});	
				}
				for(var i=prosliBroj+1;i<=randomnumber;i++){
					var left = $("#"+i).css("left");
					left = left.slice(0,left.length-2);
					var top = $("#"+i).css("top");
					top = top.slice(0,top.length-2);
					if(i == randomnumber){
						$("#figura").animate({left:left+"px"},500);
						$("#figura").animate({top:top+"px"},500,function(){
							if(randomnumber != 57)
							{
								$("#pitanje").css("z-index","2");
								$("#pozadina").css("z-index","2");
							}
							else
							{
								alert("Čestitam završili ste igru sa osvojenih "+highscore+" bodova.");	
							}
						});	
					}
					else{
						$("#figura").animate({left:left+"px"},500);
						$("#figura").animate({top:top+"px"},500);
					}
				}
				$.ajax({
					type: "POST",
					url: "pitanja.php",
					data: 'Predmet='+Kratica+'&Kolokvij='+Kolokvij,
					success: function(data){
						$("#inner_div").html(data);
						$("#makni_div").click(function(){
							var bod = $("#bodovi").html();
							var bodovi = $("#bodovno_stanje").html();
							bodovi = Number(bod)+Number(bodovi);
							$("#bodovno_stanje").html(bodovi);
							$('#bacikocku').removeAttr("disabled");
							$("#pitanje").css("z-index","-1");
							$("#pozadina").css("z-index","-1");
						});
						$("#provjera").click(function(){
							var odgovor = $(":checked").val();
							var pitanje = $("#pitanje_predmet").html();
							pitanje = pitanje.replace('&lt;','<');
							pitanje = pitanje.replace('&gt;','>');
							odgovor = odgovor.replace('&lt;','<');
							odgovor = odgovor.replace('&gt;','>');
							$.ajax({url:"provjera.php",
								   type:"POST",
								   data:"odgovor="+odgovor+"&pitanje="+pitanje,
								   success:function(data){
									   $("#inner_div").html(data);
										$("#makni_div").click(function(){
											var bod = $("#bodovi").html();
											var bodovi = $("#bodovno_stanje").html();
											bodovi = Number(bod)+Number(bodovi);
											$("#bodovno_stanje").html(bodovi);
											$('#bacikocku').removeAttr("disabled");
											$("#pitanje").css("z-index","-1");
											$("#pozadina").css("z-index","-1");
										});	
									}
							});
					
						});
				}});
				$("#kocka").html(randomnumber);
 		 });
	});
</script>
</head>

<body>
<div class="main">
	<?php
		$user = $_SESSION['user'];
		echo "<div class='result'>Dobrodošao ".$user."</div>";
	?>
    <div style="position:fixed;top:400px;right:100px">Vaše bodovno stanje : <b id="bodovno_stanje">0</b></div> 
    <a class="odjava" href="odjava.php">Odjavi se</a>
    <a class="ranglista" href="ranglista.php" target="_blank">Rang lista</a>
	<div id="kocka" class="polozaj">0</div>
	<button id="bacikocku" style="position:fixed;right:20px;top:200px;">Baci Kocku</button>
	<img src="slike/dices.jpg" alt="kocke" class="slikakocke" width="85" height="85" />
	<div style="position: absolute;left:0px;top:0px;z-index: -1;background-color: #000000;height: 1920px;width:1348px;opacity:0.8;" id="pozadina"></div>
	<div style="z-index:-1;background-color:#9C9;position:fixed;left:35%;top:10%;border-style:dashed;overflow:auto;width:340px;height:550px;border-width:2px;border-color:blue;" id="pitanje">
	    <div style="margin:15px;" id="inner_div">
	    </div>
	</div>
    <img src="slike/logo.png" alt="logo" class="logo" />
    <img id="figura" src='slike/Covjeculjak.png' width='75px' height='75px' alt='covjeculjak' style='position:absolute;top:200px;left:10px;z-index:1' />
    <?php
		$con = mysql_connect("localhost","root","");
		if (!$con)
		  {
		  die('Could not connect: ' . mysql_error());
		  }
		mysql_select_db("dwadb", $con);
		mysql_query("SET NAMES utf8;");
		$result = mysql_query("SELECT DISTINCT(Kratica),Semestar,Predmet FROM pitanja ORDER BY Semestar");
		$pomak = 170;
		$lijevo = false;
		$pomakDolje = 200;
		$pomakDoljeCrta = 225;
		$j = 0;
		$i = 1;
		echo "<img src='slike/starting_line.png' width='80px' height='80px' alt='krug' style='position:absolute;top:200px;left:10px;' />";
		echo "<img src='slike/crta.png' width='80px' height='30px' alt='crta' style='position:absolute;top:225px;left:90px;' />";
		while($row = mysql_fetch_array($result)){
		  echo "<img src='slike/blue_circle.png' width='80px' height='80px' alt='krug' style='position:absolute;top:".$pomakDolje."px;left:".$pomak."px;' />";
			
			$pomakDoljeSadrzaj = $pomakDolje;
			$pomakSadrzaj = $pomak + 3;
			echo "<p id='".$i."' style='position:absolute;color:DarkSalmon;font:italic bold 12px/30px Georgia,serif;top:".$pomakDoljeSadrzaj."px;left:".$pomakSadrzaj."px;'>".$row['Kratica']."<br>&nbsp;&nbsp;kol 1."."</p>";
			$i++;
			if($j == 5){
				$pomak += 25;
				$pomakDoljeCrta += 55;
				echo "<img src='slike/crtadolje.png' width='30px' height='80px' alt='crta' style='position:absolute;top:".$pomakDoljeCrta."px;left:".$pomak."px;' />";
				$pomakDoljeCrta += 105;
				$pomakDolje += 160;
				$pomak -= 25;
				$lijevo = !$lijevo;
				$j = -1;
			}
			else if($lijevo){
				$pomak -= 80;
				echo "<img src='slike/crtalijevo.png' width='80px' height='30px' alt='crta' style='position:absolute;top:".$pomakDoljeCrta."px;left:".$pomak."px;' />";
				$pomak -= 80;
			}
			else{
				$pomak += 80;
				echo "<img src='slike/crta.png' width='80px' height='30px' alt='crta' style='position:absolute;top:".$pomakDoljeCrta."px;left:".$pomak."px;' />";
				$pomak += 80;	
			}
			$j++;
			echo "<img src='slike/blue_circle.png' width='80px' height='80px' alt='krug' style='position:absolute;top:".$pomakDolje."px;left:".$pomak."px;' />";
			$pomakDoljeSadrzaj = $pomakDolje;
			$pomakSadrzaj = $pomak+3;
			echo "<p id='".$i."' style='position:absolute;color:white;font:italic bold 12px/30px Georgia,serif;top:".$pomakDoljeSadrzaj."px;left:".$pomakSadrzaj."px;'>".$row['Kratica']."<br>&nbsp;&nbsp;kol 2."."</p>";
			$i++;
			if($j == 5){
				$pomak += 25;
				$pomakDoljeCrta += 55;
				echo "<img src='slike/crtadolje.png' width='30px' height='80px' alt='crta' style='position:absolute;top:".$pomakDoljeCrta."px;left:".$pomak."px;' />";
				$pomakDoljeCrta += 105;
				$pomakDolje += 160;
				$pomak -= 25;
				$lijevo = !$lijevo;
				$j = -1;
			}
			else if($lijevo){
				$pomak -= 80;
				echo "<img src='slike/crtalijevo.png' width='80px' height='30px' alt='crta' style='position:absolute;top:".$pomakDoljeCrta."px;left:".$pomak."px;' />";
				$pomak -= 80;
			}
			else{
				$pomak += 80;
				echo "<img src='slike/crta.png' width='80px' height='30px' alt='crta' style='position:absolute;top:".$pomakDoljeCrta."px;left:".$pomak."px;' />";
				$pomak += 80;	
			}
			$j++;
		}
		$pomakSadrzaj -= 160; 
		echo "<img id='".$i."' src='slike/finish_flag.png' width='80px' height='80px' alt='krug' style='position:absolute;top:".$pomakDolje."px;left:".$pomakSadrzaj."px;' />";
	?>
</div>
</body>
</html>