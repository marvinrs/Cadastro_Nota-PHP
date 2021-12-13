<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>	
        <script type="text/javascript" src="jquery-1.6.2.min.js"></script>        
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>VERIFICACAO DE CARGA</title>
<style type="text/css">
<!--
.style1 {
	color: #FF0000;
	font-size: x-small;
}
.style3 {color: #0000FF; font-size: x-small; }
-->
</style>
<!--
						########## • Créditos • #############
						#									#
						#	Autor: Wesley C. Nascimento		#
						#	Email: wesley_zeus@yahoo.com.br	#
						#									#
						#	Nome do script:FormularioCliente#
						#	Bonus: validaCampo				#
						#									#
						#	Favor não retire os créditos	#
						#	Duvidas por mandem email.		#
						#									#
						#####################################

-->
<script type="text/javascript">
function validaCampo()
{
if(document.documento.CNPJ.value=="")
	{
	alert("O Campo CNPJ é obrigatório!");
	return false;
	}
else
return true;
}
// Fim do JavaScript que validará os campos obrigatórios!
</script>
</head>

<body bgcolor="#FFFFF0">
<form id="documento" name="documento" method="post" action="mineracao.php" onsubmit="return validaCampo(); return false;">
  <table width="100%" border="0">
      <tr><div align="center"><img src=img/logo.jpg></div></tr>
	  <tr><th colspan="5" align="center" valign="top"><h2>Localizacao de Carga</h2></th>
	  </tr>
    <tr>
      <td width="50">CNPJ:</td>
      <td width="835"><input name="CNPJ" type="text" id="CNPJ" size="20" maxlength="14" />
        <span class="style1">*</span> <span class="style3">somente n&uacute;meros</span></td>
		<td width="156">Selecione o STATUS:</td>
		<td><select name="status" id="status">
		    <option value="0">Recebido</option>
  			<option value="1">Em trânsito</option>
  			<option value="2">Encerrado</option>
  			</select></td>		
    </tr>    	
    <tr>
	  <td colspan="2"><p>
        <input name="cadastrar" type="submit" id="cadastrar" value="OK" /> 
        <br />
          <input name="limpar" type="reset" id="limpar" value="Limpar!" />
          <br />
          </p>
      </td>
    </tr>
  </table>
</form>
	<!-- Lista cada documento de acordo com o CNPJ e o STATUS-->		
	<?php 
	//Pega o valor do CNPJ e do status escolhido na página anterior
	$CNPJ=null;
	$STATUS=null;
	if (isset($_POST["CNPJ"])){
		$CNPJ = $_POST ["CNPJ"];
	}
	if (isset($_POST["status"])){
		$STATUS = $_POST ["status"];
	}		
	include("conexao.php");
	//Faz a consulta de acordo com o CNPJ e o status
	$sql = mysqli_query($cx, "SELECT * FROM DTC WHERE DTC_CGC='$CNPJ' AND DTC_STATUS='$STATUS'");
	
	echo '<table width="100%" border="1">';
	echo '<thead><tr>';
	echo '<th align="center">CNPJ</th>';
	echo '<th align="center">Data rec</th>';
	echo '<th align="center">Tipo Doc</th>';
	echo '<th>N&ordm; Doc</th>';
	echo '<th>Quant. Vol</th>';
	echo '<th>Processo</th>';
	echo '<th>Loc. Ent.</th>';
	echo '<th>Fornec</th>';
	echo '<th>Status</th>';
	echo '</tr></thead>';
	
	echo '<tbody>';
	while($aux = mysqli_fetch_assoc($sql)) { 
		echo '<tr>';
		echo '<td>'.$aux["DTC_CGC"].'</td>';
		echo '<td>'.$aux["DTC_DATREC"].'</td>';
		echo '<td>'.$aux["DTC_TIPDOC"].'</td>';
		echo '<td>'.$aux["DTC_NUMNFC"].'</td>';
		echo '<td>'.$aux["DTC_QTDVOL"].'</td>';
		echo '<td>'.$aux["DTC_PROCES"].'</td>';
		echo '<td>'.$aux["DTC_CDRDES"].'</td>';
		echo '<td>'.$aux["DTC_FORNEC"].'</td>';
		if ($aux["DTC_STATUS"]==0){
			echo '<td>'.'Recebido'.'</td>';
		}
		elseif ($aux["DTC_STATUS"]==1){
			echo '<td>'.'Em trânsito'.'</td>';
			echo '<td>'.'Em trânsito'.'</td>';
		}
		else{
			echo '<td>'.'Encerrado'.'</td>';
		}
		//echo '<td align=center><a href=edita.php?cnpj='.$aux['DTC_CGC'].'&tipdoc='.$aux['DTC_TIPDOC'].'&doc='.$aux['DTC_NUMNFC'].'><img src=img/editar.png></a></td>';			
		echo '</tr>';
		}
	echo '</tbody></table>';


?>	
</body>
</html>
