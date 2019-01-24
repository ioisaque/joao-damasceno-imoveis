<?php
	
	// PHP5 Implementation - uses MySQLi.
	// mysqli('localhost', 'yourUsername', 'yourPassword', 'yourDatabase');
	$db = new mysqli('localhost', 'joaodama_sistema' ,'online*1010', 'joaodama_sistema');
	
	if(!$db) {
		echo 'ERRO: Não foi possível conectar no banco de dados.';
	} else {
		if(isset($_POST['cidade'])) {
			$cidade = $db->real_escape_string($_POST['cidade']);
			$query = $db->query("SELECT DISTINCT bairro FROM cad_imoveis WHERE cidade = '$cidade' ORDER BY bairro");
			if($query) {
				while ($result = $query ->fetch_object()) {
					$bairro = utf8_encode($result->bairro);
	         		echo '<option>'.$bairro.'</option>';
	         	}
				} else {
					echo 'ERRO: Existe um problema no select.';
				}
		} else {
			echo 'Não foi possível executar este script!';
		}
	}
?>