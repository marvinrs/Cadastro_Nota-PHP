<?php
$CNPJ = $_POST["CNPJ"];
$STATUS = $_POST["status"];
$VIAGEM = $_POST["VIAGEM"];

Function PesquisaDoc($CNPJ,$STATUS,$VIAGEM) {
		include("conexao.php");
		//Faz a consulta de acordo com o CNPJ, o status	e a viagem
		$query = "SELECT * FROM DTC WHERE ";
		if ($CNPJ != null){
			$query = $query."DTC_CGCPAG='$CNPJ' ";
		}
		if ($STATUS != null){
			if ($CNPJ != null){
				
				$query = $query."AND ";
			}
			$query = $query."DTC_STATUS='$STATUS' ";
		}
		if ($VIAGEM != null){
			if ($CNPJ != null OR $STATUS != null){
				$query = $query."AND ";
			}
			$query = $query."DTC_NUMVGA='$VIAGEM' ";
		}
		if ($query == "SELECT * FROM DTC WHERE "){
			$query = "SELECT * FROM DTC";
		}	
	
		$sql_dtc = mysqli_query($cx, $query) or die(mysqli_error($cx));	
	
		echo '<tbody>';
		while($aux = mysqli_fetch_assoc($sql_dtc)) { 
			echo '<tr>';
			echo '<td><input type="checkbox" name="" id=""></td>';
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
				echo '<td>'.'Em trânsito'.'</td>';
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
		header("Location: /rastreamento.php");
	//return true;	
	}
?>