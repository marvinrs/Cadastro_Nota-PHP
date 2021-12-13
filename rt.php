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
		define('XML_POST_URL', 'https://webservice.newrastreamentoonline.com.br');

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

//		print_r ($arquivo);
		// Recebe o o xml após descompactado
		try {
		  $xml = new SimpleXMLElement($arquivo);
		} catch (Exception $e) {
		  echo "Erro no xml: ".$e->getMessage();
		}
		// Conexao com banco de dados MySql
		$host = '186.202.152.33'; // endereço do seu mysql	
		$user = 'datalin'; // usuário
		$pass = 'NortiLog1998d#'; // senha
		$con = mysql_connect($host,$user,$pass); // função de conexão
		$db = 'datalin'; // nome do banco de dados
		mysql_select_db($db,$con) or print mysql_error(); // seleção do banco de dados		

		// Loop de Pesquisa da Tag especificada do XML
		foreach($xml->xpath('//MensagemCB') as $MensagemCB)
		{
			# armazena na variavel $registro o conteudo da tag MensagemCB
			$registro = simplexml_load_string($MensagemCB->asXML());
			# executa uma consulta XPath e armazena em $busca
		// $busca = $registro->xpath('//veiID[.=54541]');
		// # verificando se houve alguma busca com sucesso
		//	if($busca){
			$sql ="SELECT * FROM PRV WHERE PRV_VEIID = '$MensagemCB->veiID'";
			$mun = retiraAcentos($MensagemCB->mun);
			$lat = str_replace(",",".",$MensagemCB->lat);
			$lon = str_replace(",",".",$MensagemCB->lon);
		//	}
			$query = mysql_query ($sql) or print mysql_error();
			$count = mysql_num_rows($query);
			if ($count == 0) {
				$sql = "INSERT INTO PRV (PRV_VEIID, PRV_DATPOS, PRV_LAT, PRV_LON, PRV_MUNPOS, PRV_UF) VALUES ('$MensagemCB->veiID', '$MensagemCB->dt', '$lat', '$lon', '$mun', '$MensagemCB->uf')";
				mysql_query($sql) or print mysql_error();
			} 
			else {
				while ($resultado=mysql_fetch_array($query)) {
					If ($resultado[PRV_DATPOS] < $MensagemCB->dt) {
						mysql_query("UPDATE PRV SET PRV_DATPOS='$MensagemCB->dt', PRV_LAT='$lat', PRV_LON= '$lon', PRV_MUNPOS='$mun', PRV_UF='$MensagemCB->uf' WHERE PRV_VEIID = '$MensagemCB->veiID' ") or print mysql_error();
					}
				}
			}		
		
		}

		// Separacao da variavel de entrada chave em varias variaveis 
		$temp = $_GET["chave"]; 
		$ini = 0; // inico do substring 
		$fim = 0; // final do substring
		$cont= 1;
		for ($i = 0; $i <= strlen($temp); $i++) {
			if (substr($temp, $i, 1) == "|") {
				if ($cont == 1) {
					$status=substr($temp, $ini, $fim);	//Status da carga
				}
				elseif ($cont == 2) {
					$ori=substr($temp, $ini, $fim);	//Regiao de origem
				}
				elseif ($cont == 3) {
					$des=substr($temp, $ini, $fim);	//Regiao de destino
				}
				elseif ($cont == 4) {
					$emb=substr($temp, $ini, $fim);	//Embarcacao
				}
				elseif ($cont == 5) {
					$vg=substr($temp, $ini, $fim);	//Numero da viagem
				}
				$ini = $i+1;
				$fim = -1;
				$cont++;
			}
			$fim++;
		}
		$pr=substr($temp, $ini, $fim);	//Processo/pedido do cliente

		// Ocorrencias da Viagem
		$chave=$vg;
		$sql ="SELECT DISTINCT(VGE_VIAGEM), VGE_CDRORI, VGE_CDRDES, VGE_DESCORI, VGE_DESCDES, VGE_DATSAIDA, VGE_HORSAIDA, VGE_DATCHEGADA, VGE_HORCHEGADA, VGE_CODVEI FROM VGE WHERE VGE_VIAGEM = '$chave'";
		$query = mysql_query ($sql) or print mysql_error();
		$count = mysql_num_rows($query);
		if ($count == 1) {     
			while ($resultado=mysql_fetch_array($query))       {
				$vge_viagem =$resultado[VGE_VIAGEM];
				$hor_saida  =$resultado[VGE_HORSAIDA];
				$hor_chegada=$resultado[VGE_HORCHEGADA];
				$vei_viagem =$resultado[VGE_CODVEI];
				$dat_saida  =$resultado[VGE_DATSAIDA];
				$dat_chegada=$resultado[VGE_DATCHEGADA];

				}
			if ($dat_saida != null) {
				if ($dat_chegada != null) {
					echo "<strong>Viagem ENCERRADA em ".substr($dat_chegada,6,2)."-".substr($dat_chegada,4,2)."-".substr($dat_chegada,2,2)." as ".$hor_chegada."</strong><BR>";
				}
				else {
					echo "Viagem em TRANSITO iniciada em ".substr($dat_saida,6,2)."-".substr($dat_saida,4,2)."-".substr($dat_saida,2,2)." as ".$hor_saida."<BR>";
				}
					
			}
		}
		
		// Latitude e longitude de Origem
		$chave=$ori;
		$sql ="SELECT DISTINCT(LOC_COD), LOC_DESCR, LOC_LAT, LOC_LON FROM LOC WHERE LOC_COD = '$chave'";
		$query = mysql_query ($sql) or print mysql_error();
		$count = mysql_num_rows($query);
		if ($count == 1) {     
			while ($resultado=mysql_fetch_array($query))       {
				echo "Origem: ".$resultado[LOC_DESCR]."<BR>";
				$ori_lat=$resultado[LOC_LAT];
				$ori_lon=$resultado[LOC_LON];
				$ori_descr=$resultado[LOC_DESCR];
			}
		}

		// Latitude e longitude de Destino
		$chave=$des;
		$sql ="SELECT DISTINCT(LOC_COD), LOC_DESCR, LOC_LAT, LOC_LON FROM LOC WHERE LOC_COD = '$chave'";
		$query = mysql_query ($sql) or print mysql_error();
		$count = mysql_num_rows($query);
		if ($count == 1) {     
			while ($resultado=mysql_fetch_array($query))       {
				echo "Destino: ".$resultado[LOC_DESCR]."<BR>";
				$des_lat=$resultado[LOC_LAT];
				$des_lon=$resultado[LOC_LON];
				$des_descr=$resultado[LOC_DESCR];
			}
		}

		// Latitude e longitude do veiculo
		$chave=$emb;
		$sql ="SELECT DISTINCT(PRV_VEICOD), PRV_DESCR, PRV_LAT, PRV_LON, PRV_DATPOS, PRV_MUNPOS, PRV_UF FROM PRV WHERE PRV_VEICOD = '$chave'";
		$query = mysql_query ($sql) or print mysql_error();
		$count = mysql_num_rows($query);
		if ($count == 1) {     
			while ($resultado=mysql_fetch_array($query))       {
				$emb_descr=$resultado[PRV_DESCR];
				if ($dat_chegada != null) { //se viagem encerrada mostra coordenadas do veiculo no destino
					$emb_lat=$des_lat;
					$emb_lon=$des_lat;
					echo "Embarcacao: ".$emb_descr."<BR>";
				}
				else {
				 	$emb_lat=$resultado[PRV_LAT];
					$emb_lon=$resultado[PRV_LON];
					$emb_mun=$resultado[PRV_MUNPOS]."-".$resultado[PRV_UF];
					$emb_dat=substr($resultado[PRV_DATPOS],8,2)."-".substr($resultado[PRV_DATPOS],5,2)."-".substr($resultado[PRV_DATPOS],2,2)." as ".substr($resultado[PRV_DATPOS],11,5);
					echo "Embarcacao: ".$emb_descr." em ".$emb_mun." em ".$emb_dat.", lat:".$emb_lat.", long:".$emb_lon."<BR>";
				}

			}
		}
		
		// calcula ponto medio entre a longit ude origem e longitude destino
		$centraliza = ((float) $ori_lon + (float) $des_lon) / 2;
		$central_lon = (string) $centraliza;

		//fecha conexao banco de dados MySql
		mysql_close($con);
		
		//***** Processo ou Pedido do cliente*****
		$processo = $pr;
		If ($processo != null) {
			echo "Indent. Carga (Pedido/Processo): ".$processo."<BR>";
		}
		
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
		###################### Function retira acentos #######################
		function retiraAcentos($string){
			return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
		}
	?>
   <div id="map"></div>
    <div id="legend"><h3>Legenda</h3></div>
    <script>
	if(<?php echo $status ?> == 0){
		window.location='https://www.google.com/maps/place/<?php print $ori_lat.' , '.$ori_lon ?>';
	}
	else if(<?php echo $status ?> == 2){
		window.location='https://www.google.com/maps/place/<?php print $des_lat.' , '.$des_lon ?>';
	}
	else{
      var map;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 7,
          center: new google.maps.LatLng(-1.5885, "<?php print $central_lon ; ?>"),
          mapTypeId: 'roadmap'
        });

        var iconBase = 'https://maps.google.com/mapfiles/kml/shapes/';
        var icons = {
          origem: {
            name: "<?php print $ori_descr ; ?>",
            icon: 'belem.png'
          },
          destino: {
            name: "<?php print $des_descr ; ?>",
            icon: 'portotrombetas.png'
          },
          empurrador: {
            name: "<?php print $emb_descr ; ?>",
            icon: 'empurrador.png'
          }
        };

        var features = [
          {
            position: new google.maps.LatLng("<?php print $ori_lat ; ?>","<?php print $ori_lon ; ?>"),
            type: 'origem'
		  }, {		
            position: new google.maps.LatLng("<?php print $des_lat ; ?>","<?php print $des_lon ; ?>"),
            type: 'destino'
          }, {
            position: new google.maps.LatLng("<?php print $emb_lat ; ?>","<?php print $emb_lon ; ?>"),
            type: 'empurrador'
          }
        ];

        // Create markers.
        features.forEach(function(feature) {
          var marker = new google.maps.Marker({
            position: feature.position,
            icon: icons[feature.type].icon,
            map: map
          });
        });

        var legend = document.getElementById('legend');
        for (var key in icons) {
          var type = icons[key];
          var name = type.name;
          var icon = type.icon;
          var div = document.createElement('div');
          div.innerHTML = '<img src="' + icon + '"> ' + name;
          legend.appendChild(div);
        }

        map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend);
      }
	}
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD7u0NnHbPwL5vOjrfX8-cL_aiioPftVLc&callback=initMap">
    </script>
  </body>
</html>