<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ranglista</title>
<link rel="stylesheet" type="text/css" href="styletable.css" />
<script type="text/javascript" src="jquery-1.6.1.js"></script> 
<script type="text/javascript" src="jquery.tablesorter.js"></script>
<script type="text/javascript">
	$(document).ready(function() 
    { 
        $("#myTable").tablesorter(); 
    } 
);
</script>
</head>

<body>
<table id="myTable" class="tablesorter">
	<thead>
	<tr>
        <th class="header">Pozicija</th>
        <th class="header">Korisnik</th>
        <th class="header">Highscore</th>
    </tr>
    </thead>
    <tbody>
    <?php 
		$con = mysql_connect("localhost","root","");
		if (!$con)
		{
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db("dwadb", $con);
		mysql_query("SET NAMES utf8;");
		$result = mysql_query("SELECT * FROM bodovi ORDER BY Highscore DESC");
		$i = 1;
		while($row = mysql_fetch_array($result)){
			if($i % 2 == 0){
				echo "<tr class='odd'>
						<td>".$i."</th>
						<td>".$row['Korisnicko_ime']."</th>
						<td>".$row['Highscore']."</th>
					  </tr>";
			}
			else{
				echo "<tr>
						<td>".$i."</th>
						<td>".$row['Korisnicko_ime']."</th>
						<td>".$row['Highscore']."</th>
					  </tr>";	
			}
			$i++;
		}
	?>
    </tbody>
    </table>
</table>
</body>
</html>