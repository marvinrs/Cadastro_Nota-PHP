<?php require "verifica.php"; ?>
<!-- SMARV Informática MEI (91)98156-5857-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Alteracao de Dados</title>
</head>

<body>
	
<?php 
// RECEBENDO OS DADOS PREENCHIDOS DO FORMULÁRIO
$CNPJ = $_POST ["CNPJ"];
$DataRec = $_POST ["DataRec"];
$TipDoc	= $_POST ["TipDoc"];
$NFEID = $_POST ["NFEID"];	
$NumNFC	= $_POST ["NumNFC"];
$QTDVol	= $_POST ["QTDVol"];
$proces	= $_POST ["proces"];
$CDRORI	= $_POST ["CDRORI"];
$CDRDES	= $_POST ["CDRDES"];
$FORNEC	= $_POST ["FORNEC"];
$STATUS = $_POST ["STATUS"];

$ID = $_GET ["id"];
//Converte a data do formato YYYY-MM-DD para YYYYMMDD
$DATREC = str_replace("-","",$DataRec);
//Realiza conexão com banco de dados
include("conexao.php");
//Grava query de atualização
$altera="UPDATE DTC SET DTC_CDRORI='$CDRORI',DTC_CDRDES='$CDRDES',DTC_CGCPAG='$CNPJ',DTC_NFEID='$NFEID',DTC_TIPDOC='$TipDoc',DTC_NUMNFC='$NumNFC',DTC_QTDVOL='$QTDVol',DTC_DATREC='$DATREC',DTC_PROCES='$proces',DTC_FORNEC='$FORNEC',DTC_STATUS='$STATUS' WHERE DTC_ID='$ID'" ;		
//Associa a query com a conexão
$sucesso=mysqli_query($cx,$altera) or die (mysqli_error($cx)); 
if($sucesso):
		echo "<script>
					alert('Cadastro Alterado com sucesso.');
					window.location='inclui.php';
			</script>";
	else:	 	
		echo "<script>
				alert('Erro! Verifique se o cadastro ja consta na lista!');
				window.location='inclui.php';
			</script>";
	endif;
	
mysqli_close($cx);	
?> 
</body>
</html>
<!-- SMARV Informática MEI (91)98156-5857-->