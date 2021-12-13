<?php require "verifica.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- SMARV Informática (91)98156-5857-->
<head>	        
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>EDIÇÃO DE DOCUMENTO</title>
<style type="text/css">
<!--
.style1 {
	color: #FF0000;
	font-size: x-small;
}
.style3 {color: #0000FF; font-size: x-small; }
-->
</style>
<!--Autor: Wesley C. Nascimento		
	Email: wesley_zeus@yahoo.com.br	
	Nome do script:FormularioCliente
	Bonus: validaCampo			
	Favor não retire os créditos	
	Duvidas por mandem email.	
-->

</head>

<body bgcolor="#FFFFF0">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<?php 
	include("conexao.php");
	//Coloca valor do CNPJ, Tipdoc e numnfc vindo via ahref em uma variável
	$ID = $_GET ["id"];	
	//consulta tabela pra saber os outros valores da linha
	$sql = mysqli_query($cx, "SELECT * FROM DTC WHERE DTC_ID='$ID'") or die(mysqli_error($cx));
	$aux = mysqli_fetch_assoc($sql);
?><!-- Pega os parâmetros da página anterior para CNPJ, Tipo de Documento, Documento e Status -->
<form id="documento" name="documento" method="post" action="alteracao.php?id=<?php echo $ID?>" onsubmit="">
  <table width="100%" border="1">
	  <tr><div align="center"><img src=img/logo.jpg></div></tr>
	  <tr><th colspan="2" align="center" valign="top"><h2>Edicao de Documento </h2></th>
	  </tr>
    <tr>
      <td width="138">CPF/CNPJ:</td>
      <td width="835"><input name="CNPJ" type="text" value="<?php echo $aux["DTC_CGCPAG"]; ?>" placeholder="Digite o CNPJ" id="CNPJ" value="84156249000180" size="14" pattern="\s*(\S\s*){14,}" title="Digite os 14 dígitos do CNPJ (Apenas números)" maxlength="14" required=""/>
        <span class="style1">*</span> <span class="style3">somente n&uacute;meros</span></td>
    </tr>
    <tr>
      <td>Data Recebimento:</td>
      <td>	  
	  <?php
	  // transforma a data do formato YYYMMDD para YYYY-MM-DD para ser lido no campo tipo "date"
	  $DATREC = $aux["DTC_DATREC"];
	  $DAT_REC_TRACO_1 = substr_replace($DATREC, '-', 4, 0);;
	  $DAT_REC_TRACO_2 = substr_replace($DAT_REC_TRACO_1, '-', 7, 0);;	  
	  ?>
	    <input type="date" value="<?php echo $DAT_REC_TRACO_2; ?>" required="required" maxlength="10" name="DataRec" id="DataRec" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" min="2012-01-01" max="2300-08-03" />        
          </td>
	</tr>
	  <tr>
	    <td>Tipo de Documento:</td><td>
			<select name="TipDoc" id="TipDoc">
		    <option value="NF"<?=($aux["DTC_TIPDOC"] == 'NF')?'selected':''?>>NF</option>
  			<option value="CTO"<?=($aux["DTC_TIPDOC"] == 'CTO')?'selected':''?>>CTO</option>
  			<option value="MTO"<?=($aux["DTC_TIPDOC"] == 'MTO')?'selected':''?>>MTO</option>
  			<option value="OUTROS"<?=($aux["DTC_TIPDOC"] == 'OUT')?'selected':''?>>OUTROS</option>
			</select> <span class="style1">*</span></td></tr>
	<tr>
		<td>Chave da NFE:</td>
		<td>
		<input type="tel" value="<?php echo $aux["DTC_NFEID"];?>" placeholder="Digite os 44 dígitos da Chave da Nota" pattern="\s*(\S\s*){44,}" name="NFEID" id="NFEID" title="Digite os 44 dígitos da Chave da Nota (Apenas números)" size="40" maxlength="44" required=""/> <span class="style1">*</span>
		</td>
	</tr>
	<tr>
	    <td>N&uacute;mero do Documento:</td>
		<td><input type="tel" name="NumNFC" id="NumNFC" size="9" maxlength="9" value="<?php echo $aux["DTC_NUMNFC"];?>" required=""/> <span class="style1">*</span></td>
      
    </tr>
    <tr>
      <td>Quantidade (Volume):</td>
      <td><input name="QTDVol" type="tel" id="QTDVol" size="4" maxlength="4" value="<?php echo $aux["DTC_QTDVOL"];?>" required=""/> <span class="style1">*</span> <span class="style3">em litros</span></td>
    </tr>
    <tr>
      <td>Processo</td>
      <td><input name="proces" type="text" id="proces" size="14" maxlength="14" value="<?php echo $aux["DTC_PROCES"];?>" required=""/>
	  <span class="style1">*</span></td>
    </tr>
	<tr>
      <td>Local de Origem:</td>
      <td><input name="CDRORI" type="text" id="CDRORI" value="<?php echo $aux["DTC_CDRORI"];?>" size="6" pattern="\s*(\S\s*){6,}" title="Digite os 6 carateres da origem" maxlength="6" required=""/>
	  <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>Local de Destino:</td>
      <td><input name="CDRDES" type="text" id="CDRDES" value="<?php echo $aux["DTC_CDRDES"];?>" size="6" pattern="\s*(\S\s*){6,}" title="Digite os 6 carateres do destino" maxlength="6" required=""/>	  
        <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>Fornecedor:</td>
      <td> <input name="FORNEC" type="text" id="FORNEC" maxlength="20" size="20" value="<?php echo $aux["DTC_FORNEC"];?>" required=""/>
	    <span class="style1">*</span>
        </td>
    </tr>			
	<tr>
	    <td>Status:</td>
		<td>				
			<select name="STATUS" id="STATUS">
		    <option value="0"<?=($aux["DTC_STATUS"] == '0')?'selected':''?>>Recebido</option>
  			<option value="1"<?=($aux["DTC_STATUS"] == '1')?'selected':''?>>Em Tr&acirc;nsito</option>
  			<option value="2"<?=($aux["DTC_STATUS"] == '2')?'selected':''?>>Encerrado</option>
  			</select>			
			<span class="style1">*</span>
		</td>
	</tr>
    <tr>	
      <td colspan="2"><p>
        <input name="cadastrar" type="submit" id="cadastrar" value="Confirmar" /> 
        <br />		
          <span class="style1">* Campos com * s&atilde;o obrigat&oacute;rios!          </span></p>
		  <br />
		  <input type="button" value="Voltar" onClick="history.go(-1)">
      </td>
    </tr>
	
  </table>
</form>
	<!-- Lista cada documento-->		
	<?php 
		
	
?>	
</body>
</html>
<!-- SMARV Informática (91)98156-5857-->