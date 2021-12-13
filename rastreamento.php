<?php require "verifica.php"; ?>
<!-- SMARV Informática MEI (91)98156-5857-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>	                
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Rastreamento</title>
<style type="text/css">
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
<!--Autor: Wesley C. Nascimento		
	Email: wesley_zeus@yahoo.com.br	
	Nome do script:FormularioCliente
	Bonus: validaCampo				
	Favor não retire os créditos	
	Duvidas por mandem email.		
-->
<style>
table {
    border-collapse: collapse;
    width: 50%;	
    border: 1px solid black;
}

th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

th {
    background-color: #ba0000;
    color: white;  
}

</style>
</head>
<body bgcolor="#FFFFF0">
<script type="text/javascript">
	function coletaDados(){	
		var ids = document.getElementsByClassName('editar');
	coletaIDs(ids);         
	}  

	function coletaIDs(dados){
		var array_dados = dados; 
		//document.write(array_dados.length);
		var newArray = [];
		for(var x = 0; x <= array_dados.length; x++){     
			if(typeof array_dados[x] == 'object'){
				if(array_dados[x].checked){
					newArray.push(array_dados[x].id);
				}          
			}
		}
		if(newArray.length <= 0){
			alert("Selecione um pelo menos 1 documento!");
		}else{
//			alert("Seu novo array de IDs tem os seguites ids [ "+newArray+" ]");
		}  
	}
</script>

<?php
    $CNPJ=null;
	$VIAGEM=null;
	$STATUS=null;
	$NUMNFC=null;

	if (isset($_POST["CNPJ"])){
		$CNPJ = $_POST ["CNPJ"];}
	if (isset($_POST ["VIAGEM"])){
		$VIAGEM = $_POST ["VIAGEM"];}
	if (isset($_POST ["NUMNFC"])){
		$NUMNFC = $_POST ["NUMNFC"];}
	if (isset($_POST ["status"])) {	
		$STATUS = $_POST ["status"];}
	if (isset($_POST ["EMBARC"])) {	
		$EMBARC	= $_POST ["EMBARC"];}
	if (isset($_POST ["DATREC"])) {
		$DATREC	= $_POST ["DATREC"];}
	if (isset($_POST ["DATSAI"])) {
		$DATSAI	= $_POST ["DATSAI"];}
	if (isset($_POST ["HORSAI"])) {	
		$HORSAI	= $_POST ["HORSAI"];}
	if (isset($_POST ["DATCHE"])) {	
		$DATCHE = $_POST ["DATCHE"];}
	if (isset($_POST ["HORCHE"])) {	
		$HORCHE	= $_POST ["HORCHE"];}
	if (isset($_POST ["CDRORI"])) {	
		$CDRORI	= $_POST ["CDRORI"];}		
	if (isset($_POST ["CDRDES"])) {	
		$CDRDES = $_POST ["CDRDES"];}
?>
<style>
	table{
	float: left;
	}
</style>
<form id="localizacao" name="localizacao" method="post" action="?a=1" onsubmit="return true;">
  <table width="100%" border="0">
  <tr><div align="center"><img src=img/logo.jpg></div></tr>
  <tr>	  
	  <div class="topnav">
		<a href="inclui.php">Incluir Nota</a>
		<a class="active" href="rastreamento.php">Rastreamento</a>
		<a href="localiza.php">Localizacao</a>
		<a href="sair.php">Sair</a>
	  </div>
  </tr>
  </table>
  <table width="50%" border="0">      
	<tr><th colspan="5" align="center" valign="top"><h2>Pesquisa Documento</h2></th>
	</tr>
	<tr>
	<td width="156">Selecione status:</td>
		<td><select name="status" id="status">
			<option value=""></option>
		    <option value="0"<?=($STATUS == '0')?'selected':''?>>Recebido</option>
  			<option value="1"<?=($STATUS == '1')?'selected':''?>>Transito</option>
  			<option value="2"<?=($STATUS == '2')?'selected':''?>>Encerrado</option>
  			</select></td>
	</tr>
	<tr>
	<td>
	Viagem:
	</td>
	<td width="835"><input name="VIAGEM" type="text" id="VIAGEM" size="2" maxlength="6" />
	</td>
	</tr>
    <tr>
      <td>CNPJ:</td>
      <td width="835"><input name="CNPJ" type="text" placeholder="So n&uacute;meros" id="CNPJ" size="10" title="Digite os 14 dígitos do CNPJ (Apenas números)" maxlength="14" />
      </td>				
    </tr>
	<tr>
      <td>Numero da Nota:</td>
      <td width="835"><input name="NUMNFC" type="text" placeholder="So numeros" id="NUMNFC" size="6" title="Digite os digitos correspondentes ao Documento" maxlength="9" />
      </td>				
    </tr>
    <tr>
	  <td colspan="2"><p>
        <input name="pesquisar" type="submit" id="pesquisar" value="Pesquisar" />
        <br />
          
		  <input name="limpar" type="reset" id="limpar" value="Limpar!" />
          <br />
          </p>
		  
      </td>
    </tr>
  </table>
</form>

<form id="alteracoes" name="alteracoes" method="post" action="?a=2" onsubmit="return coletaDados(); return false;">  
  <table width="50%" border="0">
   <tr><th colspan="5" align="center" valign="top"><h2>Alteracoes</h2></th></tr>
   <tr>
      <td>Status:</td>
      <td><select name="status" id="status">
		    <option value=""></option>
		    <option value="0">Recebido</option>
  			<option value="1">Tr&acirc;nsito</option>
  			<option value="2">Encerrado</option>
  			</select></td>
	  <td width="92"></td>
      <td></td>
   </tr>
   <tr>
      <td width="90">Viagem:</td>
      <td width="100"><input name="VIAGEM" type="text" id="VIAGEM" placeholder="Viagem" size="2" pattern="\s*(\S\s*){6,}" title="Digite os 6 caracteres da viagem" maxlength="6" value=""/></td>
	  <td></td>
	  <td></td>
   </tr>
   <tr>
	  <?php
	  include("conexao.php");
	  $query_prv = $cx->query("SELECT * FROM PRV");
	  //$sql_prv = mysqli_query($cx, $query_prv) or die(mysqli_error($cx));
	  ?>
      <td>Embarcacao:</td>
      <td>
		<?php
		echo '<select name="EMBARC" id="EMBARC">';
		echo '<option value=""></option>';		
		while($reg = $query_prv->fetch_array()) {			
			echo '<option value=';
			echo $reg["PRV_VEICOD"];
			echo '>';
			echo $reg["PRV_DESCR"];
			echo '</option>';
			}
		echo '</select>';
		?>
	  </td>
	  <td>Data de Rec.</td>
      <td><input type="date" maxlength="10" name="DATREC" id="DATREC" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" min="2012-01-01" max="2300-08-03" /></td>
	  <?php
	  mysqli_close($cx);
	  ?>
   </tr>
   <tr>
      <td>Data Sa&iacute;da:</td>
	  <td><input type="date" maxlength="10" name="DATSAI" id="DATSAI" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" min="2012-01-01" max="2300-08-03" />      
      <td>Hora Sa&iacute;da:</td>
      <td><input name="HORSAI" type="text" id="HORSAI" placeholder="hhmm" size="1" maxlength="5" value=""/></td>        
   </tr>
   <tr>
      <td>Data Chegada:</td>
      <td><input type="date" maxlength="10" name="DATCHE" id="DATCHE" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" min="2012-01-01" max="2300-08-03" />      	  
      <td>Hora Chegada:</td>
      <td><input name="HORCHE" type="text" id="HORCHE" placeholder="hhmm" size="1" maxlength="5" value=""/></td>        
   </tr>
   <tr>
      <td>Origem:</td>
      <td><input name="CDRORI" type="text" id="CDRORI" value="" size="6" pattern="\s*(\S\s*){6,}" title="Digite os 6 carateres da origem" maxlength="6" /></td>        
      <td>Destino:</td>
      <td><input name="CDRDES" type="text" id="CDRDES" value="" size="6" pattern="\s*(\S\s*){6,}" title="Digite os 6 carateres do destino" maxlength="6" /></td>        
   </tr>   
   <tr>
	  <td colspan="2"><p>
        <input name="atualizar" type="submit" id="atualizar" value="Atualizar" /> 
        <br />
          </p>
      </td>
	  <td></td>
      <td></td>
    </tr>
  </table>
  <?php
	if (isset($_GET ["a"])){
	if ($_GET ["a"] == 2) {
		if(!empty($_POST['checkbox'])) {
			//ATUALIZA BANCO DE DADOS
			$flag = 0;
			$atualiza = "UPDATE DTC SET ";
			if 	($VIAGEM != null) {
				if ($flag != 0) {$atualiza = $atualiza.",";}
				$flag = 1;
				$atualiza = $atualiza."DTC_NUMVGA='$VIAGEM'";
			}
			if 	($STATUS != null) {
				if ($flag != 0) {$atualiza = $atualiza.",";}
				$flag = 1;
				$atualiza = $atualiza."DTC_STATUS='$STATUS'";
			}
			if 	($EMBARC != null) {
				if ($flag != 0) {$atualiza = $atualiza.",";}
				$flag = 1;
				$atualiza = $atualiza."DTC_CODVEI='$EMBARC'";
			}
			if 	($DATREC != null) {
//				echo "data recebimento".$DATREC."<br>";
				if ($flag != 0) {$atualiza = $atualiza.",";}
				$flag = 1;
				$DATREC = str_replace("-","",$DATREC);
				$atualiza = $atualiza."DTC_DATREC='$DATREC'";
			}
			if 	($DATSAI != null) {
//				echo "data saida".$DATSAI."<br>";
				if ($flag != 0) {$atualiza = $atualiza.",";}
				$flag = 1;
				$DATSAI = str_replace("-","",$DATSAI);
				$atualiza = $atualiza."DTC_DATSAI='$DATSAI'";
			}
			if 	($HORSAI != null) {
				if ($flag != 0) {$atualiza = $atualiza.",";}
				$flag = 1;
				$atualiza = $atualiza."DTC_HORSAI='$HORSAI'";
			}
			if 	($DATCHE != null) {
				if ($flag != 0) {$atualiza = $atualiza.",";}
				$flag = 1;
				$DATCHE = str_replace("-","",$DATCHE);
				$atualiza = $atualiza."DTC_DATCHE='$DATCHE'";
			}
			if 	($HORCHE != null) {
				if ($flag != 0) {$atualiza = $atualiza.",";}
				$flag = 1;
				$atualiza = $atualiza."DTC_HORCHE='$HORCHE'";
			}
			if 	($CDRORI != null) {
				if ($flag != 0) {$atualiza = $atualiza.",";}
				$flag = 1;
				$atualiza = $atualiza."DTC_CDRORI='$CDRORI'";
			}
			if 	($CDRDES != null) {
				if ($flag != 0) {$atualiza = $atualiza.",";}
				$flag = 1;
				$atualiza = $atualiza."DTC_CDRDES='$CDRDES'";
			}
			if ($flag != 0) {
				foreach($_POST['checkbox'] as $check) {
					echo "ID".$check."<br>"; //exibe pra nos o valor recebido atualmente e pula linha
					include("conexao.php");
					mysqli_query($cx,$atualiza." WHERE DTC_ID ='$check'") or die(mysqli_error($cx));
					mysqli_close($cx);
				}	
			}
			else {
				echo "Nenhum dado alterado";
			}
		} 
	}	
 	else{	
		echo '<table width="100%" border="1">';
		echo '<thead><tr>';
		echo '<th><input type="checkbox" name="checkTodos" id="checkTodos"></th>';
		echo '<th align="center">CNPJ_PAG</th>';
		echo '<th align="center">Data_REC</th>';
		echo '<th align="center">CNPJ_FOR</th>';
		echo '<th align="center">Tipo_Doc</th>';
		echo '<th>N&ordm;_Doc</th>';
		echo '<th>Fornec</th>';
		echo '<th>Quant. Vol</th>';
		echo '<th>Processo</th>';	
		echo '<th>STATUS</th>';
		echo '<th>Origem</th>';
		echo '<th>Viagem</th>';
		echo '<th>Destino</th>';
		echo '<th>Embarcação</th>';
		echo '<th>Data_Saida</th>';
		echo '<th>Hora_Saida</th>';
		echo '<th>Data_Cheg</th>';
		echo '<th>Hora_Chegada</th>';
		echo '</tr></thead>';
				
		//realiza a conexão com o banco de dados
		include("conexao.php");
		//Faz a consulta de acordo com o CNPJ, o status, a viagem e o numero da nota
		$query = "SELECT *,date_format(DTC_DATREC,'%d/%m/%Y') DTC_DATREC,date_format(DTC_DATSAI,'%d/%m/%Y') DTC_DATSAI,date_format(DTC_DATCHE,'%d/%m/%Y') DTC_DATCHE FROM DTC WHERE ";
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
		if ($VIAGEM != null){
			if ($flag != 0) {$query = $query."AND ";}
			$query = $query."DTC_NUMVGA='$VIAGEM' ";
			$flag = 1;
		}
		if ($NUMNFC != null){
			if ($flag != 0) {$query = $query."AND ";}
			$query = $query."DTC_NUMNFC LIKE '%$NUMNFC%'";
			$flag = 1;
		}
		if ($flag == 0){
			$query = $query." DTC_STATUS=0";
		}
	
		$sql_dtc = mysqli_query($cx, $query) or die(mysqli_error($cx));	
	
		echo '<tbody>';
		while($aux = mysqli_fetch_assoc($sql_dtc)) { 
			echo '<tr>';
			echo '<td><input class="editar" type="checkbox" name="checkbox[]" id="checkbox" value="'.$aux["DTC_ID"].'"></td>';			
			echo '<td>'.$aux["DTC_CGCPAG"].'</td>';
			echo '<td>'.$aux["DTC_DATREC"].'</td>';
			echo '<td>'.$aux["DTC_CGCFOR"].'</td>';
			echo '<td>'.$aux["DTC_TIPDOC"].'</td>';
			echo '<td>'.$aux["DTC_NUMNFC"].'</td>';
			echo '<td>'.$aux["DTC_FORNEC"].'</td>';
			echo '<td>'.$aux["DTC_QTDVOL"].'</td>';
			echo '<td>'.$aux["DTC_PROCES"].'</td>';
			if ($aux["DTC_STATUS"]==0){
				echo '<td>'.'Recebido'.'</td>';
			}
			elseif ($aux["DTC_STATUS"]==1){
				echo '<td>'.'Trânsito'.'</td>';
			}
			else{
				echo '<td>'.'Encerrado'.'</td>';
			}
			echo '<td>'.$aux["DTC_CDRORI"].'</td>';
			echo '<td>'.$aux["DTC_NUMVGA"].'</td>';
			echo '<td>'.$aux["DTC_CDRDES"].'</td>';
			echo '<td>'.$aux["DTC_CODVEI"].'</td>';
			echo '<td>'.$aux["DTC_DATSAI"].'</td>';
			echo '<td>'.$aux["DTC_HORSAI"].'</td>';
			echo '<td>'.$aux["DTC_DATCHE"].'</td>';
			echo '<td>'.$aux["DTC_HORCHE"].'</td>';
			echo '</tr>';
		}
		echo '</tbody></table>';
		
		mysqli_close($cx);
	}
	}	
  ?>
	
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript">
	<!-- Script que marca todos os checkboxes -->
	$("#checkTodos").click(function(){
		$('input:checkbox').not(this).prop('checked', this.checked);
		}
	); 
</script>
</body>
</html>
<!-- SMARV Informática MEI (91)98156-5857-->