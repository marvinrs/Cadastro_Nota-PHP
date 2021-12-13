<!-- SMARV Informática MEI (91)98156-5857-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manipulação de Dados</title>
</head>

<body>
	
<?php 
// RECEBENDO OS DADOS PREENCHIDOS DO FORMULÁRIO !
$CNPJ = $_POST ["CNPJ"];
$NFEID = $_POST ["NFEID"];
$DataRec = $_POST ["DataRec"];
//Converte a data do formato YYYY-MM-DD para YYYYMMDD
$DATREC = str_replace("-","",$DataRec);
$TipDoc	= $_POST ["TipDoc"];
$NumNFC	= $_POST ["NumNFC"];
$QTDVol	= $_POST ["QTDVol"];
$proces	= $_POST ["proces"];
$CDRDES	= $_POST ["CDRDES"];
$CDRORI	= $_POST ["CDRORI"];
$FORNEC	= $_POST ["FORNEC"];	
	
include("conexao.php");
$inclui="INSERT INTO DTC (DTC_CDRORI,DTC_CDRDES,DTC_CGCPAG,DTC_NFEID,DTC_TIPDOC,DTC_NUMNFC,DTC_QTDVOL,DTC_DATREC,DTC_PROCES,DTC_FORNEC,DTC_STATUS) VALUES ('$CDRORI','$CDRDES','$CNPJ','$NFEID','$TipDoc','$NumNFC','$QTDVol','$DATREC','$proces','$FORNEC','0')";	
$sucesso=mysqli_query($cx,$inclui) or die(mysqli_error($cx));
if($sucesso):
		echo "<script>
					//alert('Cadastro Incluido com sucesso.');
					window.location='inclui.php';
			</script>";
	else:
	 	echo "<script>
				alert('Erro! Verifique se o cadastro ja consta na lista!');
				window.location='inclui.php';
			</script>";
	endif;
	
//mysqli_close($mysqli);
	
	
?> 
</body>
</html>
<!-- SMARV Informática MEI (91)98156-5857-->
