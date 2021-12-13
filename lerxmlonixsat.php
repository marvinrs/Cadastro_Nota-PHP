<!DOCTYPE html>
<html>
  <head>
    <title>Rastreamento Linave</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      html, body {
        margin: 0;
        padding: 0;
        height: 100%;
        width: 100%;
      }
      #map {
        height: 100%;
        width: 100%;
      }
      #legend {
        font-family: Arial, sans-serif;
        background: #fff;
        padding: 10px;
        margin: 10px;
        border: 3px solid #000;
      }
      #legend h3 {
        margin-top: 0;
      }
      #legend img {
        vertical-align: middle;
      }
    </style>
  </head>
  <body>
	<?php
		// Acesso ao webservice via CURL
		define('XML_PAYLOAD', '<RequestMensagemCB><login>84156249000180</login><senha>290000</senha><mId>100000000</mId></RequestMensagemCB>');
//		define('XML_PAYLOAD', '<RequestReferenciaEntrega><login>84156249000180</login><senha>290000</senha></RequestReferenciaEntrega>');
		define('XML_POST_URL', 'http://webservice.onixsat.com.br');

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, XML_POST_URL);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_POST, True);
		curl_setopt($ch, CURLOPT_POSTFIELDS, XML_PAYLOAD);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml','Connection: close'));

		$result = curl_exec($ch);

		if ( curl_errno($ch) ) {
		  $result = 'cURL ERROR -> ' . curl_errno($ch) . ': ' . curl_error($ch);
		  log_cron('ERRO', $result, $mid, 'ACESSO AO WEBSERVICE');
		} else {
		   $returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
		  switch($returnCode) {
			case 200:
			  break;
			default:
			  $result = 'HTTP ERROR -> ' . $returnCode;
			  log_cron('ERRO', $result, $mid, 'ACESSO AO WEBSERVICE');
			  break;
		  }
		}

		curl_close($ch);

		$arquivo = getZip($result);
		
//		gravar($arquivo);
	
//		print_r ($arquivo); //Imprime conteudo xml
//		echo "<br> ############# FIM XML ################ <br>";

		// Recebe o o xml após descompactado
		try {
		  $xml = new SimpleXMLElement($arquivo);
		} catch (Exception $e) {
		  echo "Erro no xml: ".$e->getMessage();
		}

		
		// Conexao com banco de dados MySql
		$host = '186.202.152.33'; // endereço do seu mysql	
		$user = 'datalin'; // usuário
		$pass = 'NortiLog1979'; // senha
		$con = mysql_connect($host,$user,$pass); // função de conexão
		$db = 'datalin'; // nome do banco de dados
		mysql_select_db($db,$con) or print mysql_error(); // seleção do banco de dados		
		
		// Loop de Pesquisa da Tag especificada do XML
		foreach($xml->xpath('//MensagemCB') as $MensagemCB)
		{
			# armazena na var $registro o conteudo de uma tag MensagemCB
			$registro = simplexml_load_string($MensagemCB->asXML());
			# executa uma consulta XPath e armazena em $busca
		// $busca = $registro->xpath('//veiID[.="65046"]');
		// # verificando se houve alguma busca com sucesso
		//	if($busca){
			$sql ="SELECT * FROM PRV WHERE PRV_VEIID = '$MensagemCB->veiID'";
			$mun = retiraAcentos($MensagemCB->mun);
			$lat = str_replace(",",".",$MensagemCB->lat);
			$lon = str_replace(",",".",$MensagemCB->lon);
			# exibindo os resultados encontrados
			echo "--------------------------------------------- <br>";
			echo "Id Veiculo.:" .$MensagemCB->veiID."<br>";
			echo "Latitudade.:" .$lat . "<br>";
			echo "Longitude..:" .$lon . "<br>";
			echo "Municipio..:" .$mun . "-" . $MensagemCB->uf . "<br>";
		//	}
			$query = mysql_query ($sql) or print mysql_error();
			$count = mysql_num_rows($query);
			if ($count == 0) {
				$sql = "INSERT INTO PRV (PRV_VEIID, PRV_DATPOS, PRV_LAT, PRV_LON, PRV_MUNPOS, PRV_UF) VALUES ('$MensagemCB->veiID', '$MensagemCB->dt', '$lat', '$lon', '$mun', '$MensagemCB->uf')";
				echo "Insere Veiculo:" .$resultado[PRV_DESCR]. "<br>";
				mysql_query($sql) or print mysql_error();
			} 
			else {
				while ($resultado=mysql_fetch_array($query)) {
					If ($resultado[PRV_DATPOS] < $MensagemCB->dt) {
						echo "Atualiza Veiculo: ".$resultado[PRV_DESCR]."<BR>";
						echo "Data Anterior:".$resultado[PRV_DATPOS]."<BR>";
						echo "Data Atual....:".$MensagemCB->dt . "<br>";
						mysql_query("UPDATE PRV SET PRV_DATPOS='$MensagemCB->dt', PRV_LAT='$lat', PRV_LON= '$lon', PRV_MUNPOS='$mun', PRV_UF='$MensagemCB->uf' WHERE PRV_VEIID = '$MensagemCB->veiID' ") or print mysql_error();
					}
				}
			}		
		
		}
		//fecha conexao banco de dados MySql
		mysql_close($con);

		#################### grava arquivo gz e descompacta #####################
		/**
		 * function getZip
		 * que pega a arquivo gzip e descompacta
		 */
		function getZip($stream) {
			// Diretorio onde esta o arquivo compactado
			$DIR = "/home/linave4/tmp/";
			$fp = fopen($DIR."arquivo.gz", "wrb");
			fwrite($fp, $stream, 16384);
			fclose($fp);
			sleep(2);
			$zp = gzopen($DIR."arquivo.gz", "r");
			$contents = gzread($zp, 400000);
			gzclose($zp);
			//  retorna o xml já descompactado em forma de texto
			return $contents;
		}
		###################### gravar XML em arquivo #####################
		function gravar($texto){
			$DIR = "/home/linave4/tmp/";
			$fp = fopen($DIR."posicao.xml", "wrb");
			fwrite($fp, $texto);
			fclose($fp);
		}		
		###################### Function retira acentos #######################
		function retiraAcentos($string){
			return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
		}
	?>
  </body>
</html>