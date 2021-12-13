<!-- SMARV Informática MEI (91)98156-5857-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>	        
</head>

<body>
	<?php 
		//$cx = new mysqli('localhost', 'root', '', 'datalin');
		//$cx = @mysqli_connect('datalin.mysql.dbaas.com.br', 'datalin', 'senha-do-banco-MySQL-locaweb', 'datalin');
		$cx = new mysqli('datalin.mysql.dbaas.com.br', 'datalin', 'senha-do-banco-MySQL-locaweb', 'datalin'); 
	// Check connection
	if (mysqli_connect_errno())
	{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
	?>	
</body>
</html>
<!-- SMARV Informática MEI (91)98156-5857-->