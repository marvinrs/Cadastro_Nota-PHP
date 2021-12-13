<?php   
        //Pega campos do FOrmulário de Alteração
		$VIAGEM = $_POST ["VIAGEM"];	
		$STATUS = $_POST ["status"];	
		$EMBARC	= $_POST ["EMBARC"];	
		$DATSAI = $_POST ["DATSAI"];	
		$HORSAI	= $_POST ["HORSAI"];	
		$DATCHE	= $_POST ["DATCHE"];	
		$HORCHE	= $_POST ["HORCHE"];	
		$ORIGEM	= $_POST ["ORIG"];	
		$DESTINO = $_POST ["DEST"];
	
	/*if (isset($_POST["1"])){
		echo $_POST ["1"];		
	}*/
		
		
		include("conexao.php");
		
		$atualizar="UPDATE DTC SET DTC_NUMVGA='$VIAGEM',DTC_STATUS='$STATUS',DTC_CODVEI='$EMBARC',DTC_DATSAI='$DATSAI',DTC_HORSAI='$HORSAI',DTC_DATCHE='$DATCHE',DTC_HORCHE='$HORCHE',DTC_CDRORI='$ORIGEM',DTC_CDRDES='$DESTINO' WHERE DTC_CGCPAG='$CNPJ_temp' AND DTC_TIPDOC='$TipDoc_temp' AND DTC_NUMNFC='$NumNFC_temp'" ;
		
		$sucesso=mysqli_query($cx,$atualizar) or die (mysqli_error($cx));
			
 
		
		
		mysqli_close($cx);
?>