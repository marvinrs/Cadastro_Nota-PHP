<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Exclui cadastro</title>
</head>
<body background="background="clouds.gif"">	
	<?php
	
	include("conexao.php");

$id = $_GET["id"];

		//Aqui $cx é referente ao código conexao.php																		echo $cnpj;
     $deleta = mysqli_query($cx,"DELETE FROM DTC WHERE DTC_ID='$id'") or die(mysqli_error($cx));

	if($deleta):
		echo "<script>
					alert('Documento excluido com sucesso.');
					window.location='inclui.php';
			</script>";
	else:
	 	echo "<script>
				alert('Infelizmente não foi possível excluir.');
				window.location='inclui.php';
			</script>";
	endif;

?>
		
</body>
</html>
<!-- SMARV Informática MEI (91)98156-5857-->