<!-- SMARV Informática MEI (91)98156-5857-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>	
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>        
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Localizacao de Carga</title>
<style type="text/css">

<!-- Estilo da tabela -->

table {
    border-collapse: collapse;
    width: 50%;	
    border: 1px solid black;
}

th, td {
    text-align: left;
    padding: 3px;
}

tr:nth-child(even){background-color: #f2f2f2}

th {
    background-color: #ba0000;
    color: white;  
}

<!--
.style1 {
	color: #FF0000;
	font-size: x-small;
}
.style3 {color: #0000FF; font-size: x-small; }
-->
</style>
<!-- Autor: Wesley C. Nascimento
			Email: wesley_zeus@yahoo.com.br	
			Nome do script:FormularioCliente
			Bonus: validaCampo				
			Favor não retire os créditos	
			Duvidas por mandem email.

-->
</head>

<body bgcolor="#FFFFF0">
<form id="documento" name="documento" method="post" action="localiza.php" onsubmit="">
  <table width="100%" border="0">
      <tr><div align="center"><img src=img/logo.jpg></div></tr>	  
	  <tr><th colspan="5" align="center" valign="top"><h2>Localizacao de Carga</h2></th>
	  </tr>
    <tr>
      <td width="50">CNPJ:</td>
      <td width="835"><input name="CNPJ" type="text" id="CNPJ" size="20" maxlength="14" required="" title="Obrigatorio informar o CNPJ do pagador do frete fluvial" value="<?php if (isset($_POST["CNPJ"])){echo $_POST ["CNPJ"];} ?>"/>
        <span class="style1">*</span> <span class="style3">somente n&uacute;meros</span></td>
		<td width="156">Selecione o STATUS:</td>
		<td><select name="status" id="status" title="Informe o STATUS do produto">
			<option value=""></option>
		    <option value="0">Recebido</option>
  			<option value="1">Em tr&acirc;nsito</option>
  			<option value="2">Encerrado</option>
  			</select></td>		
    </tr>
	<tr>
      <td width="50">Processo:</td>
      <td width="835"><input name="DTC_PROCES" type="text" id="DTC_PROCES" size="6" maxlength="10" title="Informe o numero do Pedido"/>
      </td>
	</tr>
	<tr>
      <td width="50">No.Doc:</td>
      <td width="835"><input name="DTC_NUMNFC" type="text" id="DTC_NUMNFC" size="6" maxlength="10" title="Informe o numero do Documento"/>
      </td>
	</tr>
    <tr>
	  <td colspan="2"><p>
        <input name="cadastrar" type="submit" id="cadastrar" value="OK" /> 
        <br />
          <input name="limpar" type="reset" id="limpar" value="Limpar!" />
          <br />
		  <span class="style1">* Campos com * s&atilde;o obrigat&oacute;rios!</span>
          </p>
      </td>
    </tr>
  </table>
</form>
	<!-- Lista cada documento de acordo com o CNPJ, o STATUS e PROCESSO-->		
	<?php 
	//Pega o valor do CNPJ, do STATUS e do PROCESSO escolhidos na página anterior
	$CNPJ=null;
	$STATUS=null;
	$PROCESSO=null;
	$NUMNFC=null;
	if (isset($_POST["CNPJ"])){
		$CNPJ = $_POST ["CNPJ"];
	}
	if (isset($_POST["status"])){
		$STATUS = $_POST ["status"];
	}
	if (isset($_POST["DTC_PROCES"])){
		$PROCESSO = $_POST ["DTC_PROCES"];
	}
	if (isset($_POST["DTC_NUMNFC"])){
		$NUMNFC = $_POST ["DTC_NUMNFC"];
	}
	include("conexao.php");
	//Faz a consulta de acordo com o CNPJ, o STATUS e o PROCESSO
	
	$query="SELECT *,date_format(DTC_DATREC,'%d/%m/%Y') DTC_DATREC_BRASIL FROM DTC LEFT JOIN LOC ON LOC_COD=DTC_CDRDES WHERE ";
	$flag = 0;
	if ($CNPJ != null){
		if ($flag != 0) {$query = $query."AND ";}
		$query = $query."DTC_CGCPAG='$CNPJ' ";
		$flag = 1;
	}
	if ($STATUS != null){
		if ($flag != 0) {$query = $query."AND ";}
		$query = $query."DTC_STATUS='$STATUS' ";
		$flag = 1;
	}
	if ($PROCESSO != null){
		if ($flag != 0) {$query = $query."AND ";}
		$query = $query."DTC_PROCES='$PROCESSO' ";
		$flag = 1;
	}
	if ($NUMNFC != null){
		if ($flag != 0) {$query = $query."AND ";}
		$query = $query."DTC_NUMNFC LIKE '%$NUMNFC%'";
		$flag = 1;
	}
	if ($flag == 0){
		$query = null;
	}
	if ($query != null){
		$sql = mysqli_query($cx, $query." ORDER BY DTC_DATREC DESC");
	
		echo '<table width="100%" border="1">';
		echo '<thead><tr>';
		echo '<th align="center">CNPJ</th>';
		echo '<th align="center">Data rec</th>';
		echo '<th align="center">Tipo Doc</th>';
		echo '<th>N&ordm; Doc</th>';
		echo '<th>Quant. Vol</th>';
		echo '<th>Processo</th>';
		echo '<th>Destino</th>';
		echo '<th>Fornec</th>';
		echo '<th>Status</th>';
		echo '<th>Link</th>';
		echo '</tr></thead>';
	
		echo '<tbody>';
		while($aux = mysqli_fetch_assoc($sql)) { 
			echo '<tr>';
			echo '<td>'.$aux["DTC_CGCPAG"].'</td>';
			echo '<td>'.$aux["DTC_DATREC_BRASIL"].'</td>';
			echo '<td>'.$aux["DTC_TIPDOC"].'</td>';
			echo '<td>'.$aux["DTC_NUMNFC"].'</td>';
			echo '<td>'.$aux["DTC_QTDVOL"].'</td>';
			echo '<td>'.$aux["DTC_PROCES"].'</td>';
			echo '<td>'.$aux["LOC_DESCR"].'</td>';
			echo '<td>'.$aux["DTC_FORNEC"].'</td>';
			if ($aux["DTC_STATUS"]==0){
				echo '<td>'.'Recebido'.'</td>';
			}
			elseif ($aux["DTC_STATUS"]==1){
				echo '<td>'.'Em tr&acirc;nsito'.'</td>';				
			}
			else{
				echo '<td>'.'Encerrado'.'</td>';
			}
			$link='http://www.linave.com.br/Cadastro_Nota/rt.php?chave='.$aux["DTC_STATUS"].'|'.$aux["DTC_CDRORI"].'|'.$aux["DTC_CDRDES"].'|'.$aux["DTC_CODVEI"].'|'.$aux["DTC_NUMVGA"].'|'.$aux["DTC_PROCES"];
			//echo "Processo=".$aux["DTC_PROCES"];
			echo '<td><a href='.$link.' target="_blank">Rastreamento</a></td>';
			//echo '<td align=center><a href=edita.php?cnpj='.$aux['DTC_CGC'].'&tipdoc='.$aux['DTC_TIPDOC'].'&doc='.$aux['DTC_NUMNFC'].'><img src=img/editar.png></a></td>';			
			echo '</tr>';
		}
		mysqli_close($cx);
		echo '</tbody></table>';
	}

?>	
</body>
</html>
<!-- SMARV Informática MEI (91)98156-5857-->