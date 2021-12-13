<?php require "verifica.php"; ?>
<!-- SMARV Informática MEI (91)98156-5857-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>CADASTRO DE DOCUMENTOS</title>
<style type="text/css">

<!-- estilo da barra de rolagem -->

div.rolagem {
    background-color: #eee;
    width: 1330px;
    height: 170px;
    overflow: auto;
	border: 2px dotted red;
}

<!-- Estilo do menu -->
body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

.topnav {
  overflow: hidden;
  background-color: #333;
}

.topnav a {
  float: left;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  background-color: #ddd;
  color: black;
}

.topnav a.active {
  background-color: #4CAF50;
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

</head>
<body bgcolor="#FFFFF0">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<form id="documento" name="documento" method="post" action="inclusao.php" onsubmit="return is_cnpj(document.documento.CNPJ.value); return false;">
  <table width="100%" border="0">
      <tr><div align="center"><img src=img/logo.jpg></div></tr>
	  <tr>	  
	  <div class="topnav">
		<a class="active" href="inclui.php">Incluir Nota</a>
		<a href="rastreamento.php">Rastreamento</a>
		<a href="localiza.php">Localizacao</a>
		<a href="sair.php">Sair</a>
	  </div>
	  </tr>
	  <tr><th colspan="2" align="center" valign="top"><h2>Cadastro de Documento</h2></th>
	  </tr>
    <tr>
      <td width="138">Local de Origem:</td>
      <td width="835"><input name="CDRORI" type="text" id="CDRORI" value="PA0001" size="6" pattern="\s*(\S\s*){6,}" title="Digite os 6 carateres da origem" maxlength="6" required=""/>
        <span class="style1">*</span></td>
    </tr>
	<tr>
      <td width="138">Local de Destino:</td>
      <td width="835"><input name="CDRDES" type="text" id="CDRDES" value="PA0003" size="6" pattern="\s*(\S\s*){6,}" title="Digite os 6 carateres do destino" maxlength="6" required=""/>
        <span class="style1">*</span></td>
    </tr>
	<tr>
      <td width="138">CPF/CNPJ Pag Frete:</td>
	  <!-- Esse pattern aceita a partir de 14 digitos e nao aceita o espaco e tabulacao -->
      <td width="835"><input name="CNPJ" type="text" placeholder="Digite o CNPJ" id="CNPJ" value="04932216000146" size="14" pattern="\s*(\S\s*){14,}" title="Digite os 14 dígitos do CNPJ (Apenas números)" maxlength="14" required="" />
        <span class="style1">*</span> <span class="style3">somente numeros</span></td>
    </tr>
    <tr>
      <td>Data Recebimento:</td>
      <td><input type="date" required="required" maxlength="10" name="DataRec" id="DataRec" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" min="2012-01-01" max="2300-08-03" />
        <!-- <input type="text" name="DataRec" placeholder="data" id="DataRec" size="6" pattern="\s*(\S\s*){6,}" maxlength="10" required=""/> <span class="style1">*</span><span class="style3"> Formato DDMMAAAA</span> -->
      </td>
	</tr>
	  <tr>
	    <td>Tipo de Documento:</td><td><select name="TipDoc" id="TipDoc">
		    <option value="NF">NF</option>
  			<option value="CTO">CTO</option>
  			<option value="MTO">MTO</option>
  			<option value="OUTROS">OUTROS</option></select> <span class="style1">*</span></td></tr>
	  <tr>
		<td>Chave NFE:</td>
	    <td><input type="tel" placeholder="Digite o numero da Chave da Nota" pattern="\s*(\S\s*){44,}" name="NFEID" id="NFEID" title="Digite os 44 digitos da Chave da Nota (Apenas numeros)" size="40" maxlength="44" required="" onkeyup="preencheNumDoc()"/> <span class="style1">*</span></td>
	  </tr>
	<tr>
      <td>N&uacute;mero do Documento.:</td>
		<td><input type="tel" name="NumNFC" id="NumNFC" size="6" maxlength="9" required=""/> <span class="style1">*</span></td>
      
    </tr>
    <tr>
      <td>Quantidade (Volume)</td>
      <td><input name="QTDVol" type="tel" id="QTDVol" size="4" maxlength="4" required=""/> <span class="style1">*</span> <span class="style3">em litros</span></td>
    </tr>
    <tr>
      <td>Processo</td>
      <td><input name="proces" type="text" id="proces" size="14" maxlength="14" required=""/> <span class="style1">*</span></td>
    </tr>   
    <tr>
      <td>Fornecedor:</td>
      <td> <input name="FORNEC" type="text" id="FORNEC" maxlength="20" size="20" required=""/> <span class="style1">*</span>
        </td>
    </tr>
    <tr>
      <td colspan="2"><p>		
        <input name="cadastrar" type="submit" id="cadastrar" value="Confirmar" /> 
        <br />		
          <input name="limpar" type="reset" id="limpar" value="Limpar Campos preenchidos!"/>
          <br />
          <span class="style1">* Campos com * s&atilde;o obrigat&oacute;rios!          </span></p>
      </td>
    </tr>
  </table>
</form>

<script>
is_cnpj = function (c) {
    var b = [6,5,4,3,2,9,8,7,6,5,4,3,2];
    if(/0{14}/.test(c))
        return false;
    if((c = c.replace(/[^\d]/g,"")).length != 14)
        return false;
    for (var i = 0, n = 0; i < 12; n += c[i] * b[++i]);
    if(c[12] != (((n %= 11) < 2) ? 0 : 11 - n))
        return false;
    for (var i = 0, n = 0; i <= 12; n += c[i] * b[i++]);
    if(c[13] != (((n %= 11) < 2) ? 0 : 11 - n))
        return false;
    return true;
};
cnpjCheck = function (el) {
    document.getElementById('cnpjResponse').innerHTML = is_cnpj(el.value)? '<span style="color:green">válido</span>' : '<span style="color:red">inválido</span>';
    if(el.value=='') document.getElementById('cnpjResponse').innerHTML = '';
}
</script>

<script type="text/javascript">
function is_cnpjtemp(c) {    
	var b = [6,5,4,3,2,9,8,7,6,5,4,3,2];
	alert (c);
    /*if((c = c.replace(/[^\d]/g,"")).length != 14){
        alert("O Campo data !");    
		return false;}*/

    if(/0{14}/.test(c)){
        alert("O Campo data receb \u00e9 obrigat\u00f3rio!");    
		return false;
	}	

    for (var i = 0, n = 0; i < 12; n += c[i] * b[++i]){
    if(c[12] != (((n %= 11) < 2) ? 0 : 11 - n)){
		alert("O Campo data receb \u00e9 obrigat\u00f3rio!");
		return false;
		}
	}
    for (var i = 0, n = 0; i <= 12; n += c[i] * b[i++]){
    if(c[13] != (((n %= 11) < 2) ? 0 : 11 - n)){
        alert("O Campo data receb \u00e9 obrigat\u00f3rio!");
		return false;
		}
	}
    return true;
};

//Funcao que grava o numero da Nota a partir da chave da NFE
function preencheNumDoc() {
	x = document.getElementById('NFEID');
		document.getElementById('NumNFC').value = x.value.substr(26,9);
}

</script>
<script>
//Muda o campo de texto ao pressionar Enter
$("input, select", "form") // busca input e select no form
.keypress(function(e){ // evento ao presionar uma tecla válida keypress
   
   var k = e.which || e.keyCode; // pega o código do evento
   
   if(k == 13){ // se for ENTER
      e.preventDefault(); // cancela o submit
      $(this)
      .closest('tr') // seleciona a linha atual
      .next() // seleciona a próxima linha
      .find('input, select') // busca input ou select
      .first() // seleciona o primeiro que encontrar
      .focus(); // foca no elemento
   }

});
</script>	
	<!-- Lista cada documento-->	
	<?php 
	include("conexao.php");	
	$sql = mysqli_query($cx, "SELECT *,date_format(DTC_DATREC,'%d/%m/%Y') DTC_DATREC FROM DTC WHERE DTC_STATUS=0 ORDER BY 1 DESC");	
	echo '<div class="rolagem">';	
	echo '<table width="100%" border="1">';
	echo '<thead><tr>';
	echo '<th align="center">L. Origem</th>';
	echo '<th align="center">L. Destino</th>';
	echo '<th align="center">CNPJ PAG</th>';
	echo '<th align="center">Data rec</th>';
	echo '<th align="center">Tipo Docum.</th>';
	echo '<th align="center">N&ordm; Chave NFE</th>';
	echo '<th align="center">N&ordm; Doc</th>';
	echo '<th align="center">Quant. Vol</th>';
	echo '<th align="center">Viagem</th>';
	echo '<th align="center">Processo</th>';
	echo '<th align="center">Fornec</th>';
	echo '<th align="center">Status</th>';
	echo '</tr></thead>';	
	echo '<tbody>';
	while($aux = mysqli_fetch_assoc($sql)) { 
		echo '<tr>';
		echo '<td>'.$aux["DTC_CDRORI"].'</td>';
		echo '<td>'.$aux["DTC_CDRDES"].'</td>';
		echo '<td>'.$aux["DTC_CGCPAG"].'</td>';
		echo '<td>'.$aux["DTC_DATREC"].'</td>';
		echo '<td>'.$aux["DTC_TIPDOC"].'</td>';
		echo '<td>'.$aux["DTC_NFEID"].'</td>';
		echo '<td>'.$aux["DTC_NUMNFC"].'</td>';
		echo '<td>'.$aux["DTC_QTDVOL"].'</td>';
		echo '<td>'.$aux["DTC_NUMVGA"].'</td>';
		echo '<td>'.$aux["DTC_PROCES"].'</td>';
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
		echo '<td align=center><a href=edita.php?id='.$aux['DTC_ID'].'><img src=img/editar.png></a></td>';
		echo '<td align=center><a href=deleta.php?id='.$aux['DTC_ID'].'><img src=img/excluir.png></a></td>';		
		echo '</tr>';
		}
	echo '</tbody></table></div>';


?>	
</body>
</html>
<!-- SMARV Informática MEI (91)98156-5857-->

