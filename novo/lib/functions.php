<?php
  /**
   * Funcoes
   *
   * @package Sistemas Divulgação Online
   * @author Geandro Bessa
   * @copyright 2013
   * @version 2
   */
   
  if (!defined("_VALID_PHP"))
      die('Acesso direto a esta classe não é permitido.');
  
  /**
       * nocaixa()
       * 
       * @param $banco
       * @return
       */
      function nocaixa($banco)
      {
          return ($banco) ? $banco : "NO CAIXA";
      }
	  
   /**
   * percentual()
   * 
   * @param $parte, $total
   * @return
   */
  function percentual($parte, $total)
  {
    return ($parte/$total);
  }
  
  /**
   * percentual()
   * 
   * @param $parte, $total
   * @return
   */
  function fpercentual($parte, $total)
  {
    return number_format(($parte/$total*100), 2, ',', '.')." %";
  }
  
  /**
   * porcentagem()
   * 
   * @param $parte, $total
   * @return
   */
  function porcentagem($percentual)
  {
    return number_format(($percentual*100), 2, ',', '.')." %";
  }
  
  /**
       * moeda()
       * 
       * @param $amount
       * @return
       */
      function moeda($amount)
      {
          return "R$ " . number_format($amount, 2, ',', '.');
      }
  
  /**
       * decimal()
       * 
       * @param $amount
       * @return
       */
      function decimal($amount)
      {
          return number_format($amount, 2, ',', '.');
      }

   /**
   * converteMoeda()
   * 
   * @param $moeda
   * @return
   */
  function converteMoeda($moeda)
  {
	  if (substr_count($moeda, "R$"))
	  {
		  $moeda = str_replace("R$","",$moeda);
		  $moeda = str_replace(".","",$moeda);
		  $moeda = str_replace(",",".",$moeda);
	  } elseif (substr_count($moeda, "$")) {
		  $moeda = str_replace("$","",$moeda);
		  $moeda = str_replace(",","",$moeda);
	  }
      return $moeda;
  } 

	/**
   * limparTelefone()
   * 
   * @param $tel
   * @return
   */
  function telefoneSMS($tel)
  {
      $tel = str_replace("(","",$tel);
      $tel = str_replace(")","",$tel);
      $tel = str_replace("-","",$tel);
      $tel = str_replace(" ","",$tel);
	  $tel = "55".$tel;
      return (strlen($tel) == 12) ? $tel : 0;
  }  
  
  /**
   * diasemana()
   * 
   * @param $data no formata Mysql (DD/MM/YYYY) para true
   * @param $data no formata Mysql (YYYY-MM-DD) para false
   * @return
   */
  function diasemana($data, $format = false) {
	if ($format)	{
		$d = explode("/", $data);
		$ano =  $d[2];
		$mes =  $d[1];
		$dia =  $d[0];
	} else {
		$d = explode("-", $data);
		$ano =  $d[0];
		$mes =  $d[1];
		$dia =  $d[2];
	}
	$diasemana = date("w", mktime(0,0,0,$mes,$dia,$ano) );

	switch($diasemana) {
		case"0": $diasemana = lang('DOMINGOF');  break;
		case"1": $diasemana = lang('SEGUNDAF'); break;
		case"2": $diasemana = lang('TERCAF');   break;
		case"3": $diasemana = lang('QUARTAF');  break;
		case"4": $diasemana = lang('QUINTAF');  break;
		case"5": $diasemana = lang('SEXTAF');   break;
		case"6": $diasemana = lang('SABADOF');   break;
	}

	return $diasemana;
}  
  
  /**
   * redirect_to()
   * 
   * @param $location
   * @return
   */
  function redirect_to($location)
  {
      if (!headers_sent()) {
          header('Location: ' . $location);
		  exit;
	  } else
          echo '<script type="text/javascript">';
          echo 'window.location.href="' . $location . '";';
          echo '</script>';
          echo '<noscript>';
          echo '<meta http-equiv="refresh" content="0;url=' . $location . '" />';
          echo '</noscript>';
  }
  
  /**
   * redirect_to()
   * 
   * @param $location
   * @return
   */
  function redirecionar($location)
  {
    echo '<script type="text/javascript">';
    echo 'window.location.href="' . $location . '";';
    echo '</script>';
  }
  
  /**
   * fecharjanela()
   * 
   * @return
   */
  function fecharjanela()
  {
    echo '<script type="text/javascript">';
    echo 'window.close();';
    echo '</script>';
  }
  
  /**
   * countEntries()
   * 
   * @param $table
   * @param string $where
   * @param string $what
   * @return
   */
  function countEntries($table, $where = '', $what = '')
  {
      if (!empty($where) && isset($what)) {
          $q = "SELECT COUNT(*) FROM " . $table . "  WHERE " . $where . " = '" . $what . "' LIMIT 1";
      } else
          $q = "SELECT COUNT(*) FROM " . $table . " LIMIT 1";
      
      $record = Registry::get("Database")->query($q);
      $total = Registry::get("Database")->fetchrow($record);
      return $total[0];
  }
  
  /**
   * countEntries()
   * 
   * @param $table
   * @param string $where
   * @param string $what
   * @return
   */
  function contarEntradas($table, $where1 = '')
  {
      $q = "SELECT COUNT(*) FROM " . $table . "  WHERE " . $where1 . " LIMIT 1";
      
      $record = Registry::get("Database")->query($q);
      $total = Registry::get("Database")->fetchrow($record);
      return $total[0];
  }
  
  /**
   * getChecked()
   * 
   * @param $row
   * @param $status
   * @return
   */
  function getChecked($row, $status)
  {
      if ($row == $status) {
          echo "checked=\"checked\"";
      }
  }
  
  /**
   * session()
   * 
   * @param $var
   * @return
   */
  function session($var)
  {
      if (isset($_SESSION[$var]))
          return $_SESSION[$var];
  }
  
  /**
   * post()
   * 
   * @param $var
   * @return
   */
  function post($var)
  {
      if (isset($_POST[$var]))
          return $_POST[$var];
  }
  
  /**
   * get()
   * 
   * @param $var
   * @return
   */
  function get($var)
  {
      if (isset($_GET[$var]))
          return $_GET[$var];
  }
  
  /**
   * sanitize()
   * 
   * @param $string
   * @param bool $trim
   * @return
   */
  function sanitize($string, $trim = false, $int = false, $str = false)
  {
      $string = filter_var($string, FILTER_SANITIZE_STRING);
      $string = trim($string);
      $string = stripslashes($string);
      $string = strip_tags($string);
      $string = str_replace(array('‘', '’', '“', '”'), array("'", "'", '"', '"'), $string);
      
	  if ($trim)
          $string = substr($string, 0, $trim);
      if ($int)
		  $string = preg_replace("/[^0-9\s]/", "", $string);
      if ($str)
		  $string = preg_replace("/[^a-zA-Z\s]/", "", $string);
		  
      return retira_acentos($string);
  }

  /**
   * cleanSanitize()
   * 
   * @param $string
   * @param bool $trim
   * @return
   */
  function cleanSanitize($string, $trim = false,  $end_char = '&#8230;')
  {
	  $string = cleanOut($string);
      $string = filter_var($string, FILTER_SANITIZE_STRING);
      $string = trim($string);
      $string = stripslashes($string);
      $string = strip_tags($string);
      $string = str_replace(array('‘', '’', '“', '”'), array("'", "'", '"', '"'), $string);
      
	  if ($trim) {
        if (strlen($string) < $trim)
        {
            return $string;
        }

        $string = preg_replace("/\s+/", ' ', str_replace(array("\r\n", "\r", "\n"), ' ', $string));

        if (strlen($string) <= $trim)
        {
            return $string;
        }

        $out = "";
        foreach (explode(' ', trim($string)) as $val)
        {
            $out .= $val.' ';

            if (strlen($out) >= $trim)
            {
                $out = trim($out);
                return (strlen($out) == strlen($string)) ? $out : $out.$end_char;
            }       
        }
	  }
      return $string;
  }
  
  /**
   * getValue()
   * 
   * @param $stwhatring
   * @param $table
   * @param $where
   * @return
   */
  function getValue($what, $table, $where)
  {
      $sql = "SELECT $what FROM $table WHERE $where";
      $row = Registry::get("Database")->first($sql);
      return ($row) ? $row->$what : '';
  }  
  
  /**
   * tooltip()
   * 
   * @param $tip
   * @return
   */
  function tooltip($tip)
  {
      return '<img src="' . SITEURL . '/images/tip.png" alt="" class="tooltip" title="' . $tip . '" style="margin-left:5px"/>';
  }
  
  /**
   * required()
   * 
   * @return
   */
  function required()
  {
      return '<img src="' . SITEURL . '/images/required.png" alt="Required Field" class="tooltip" title="Required Field" />';
  }
  
   /**
   * somarData()
   * @param data, dias, meses e ano
   * @return a soma na data
   */
  function somarData($data, $dias = 0, $meses = 0, $ano = 0)
  {
	//A data deve estar no formato dd/mm/yyyy
	$data = explode('/', $data);
	$newData = date('d/m/Y', mktime(0, 0, 0, $data[1] + $meses, $data[0] + $dias, $data[2] + $ano) );
	return $newData;
  }
  
  /**
   * somarMinutos()
   * @param data, dias, meses e ano
   * @return a soma na data
   */
  function somarMinutos($data, $minutos)
  {
	//A data deve estar no formato d/m/Y H:i
	
	$hora = substr($data,11,16);
	$hora = explode(":", $hora);
	$data = explode('/', $data);	
	$newData = date("d/m/Y H:i", mktime($hora[0],($hora[1]+$minutos),0, $data[1], $data[0], $data[2]) );
	return $newData;
  }
  
  /**
   * contarDias()
   * @param $us_data - DATA DO BANCO DE DADOS
   * @return verdadeiro para o dia de hoje
   */
  function contarDias($us_data = "-", $us_atual = "-")
  {
	  $data_dias = ($us_data <> "-") ? $us_data : date('d/m/Y');
	  $novadata = ($us_atual <> "-") ? $us_atual : date('d/m/Y');
	  
	  $ini = explode('/', $data_dias);
	  $fim = explode('/', $novadata);
	  $data_ini = mktime(0, 0, 0, $ini[1], $ini[0], $ini[2]);
	  $data_fim = mktime(0, 0, 0, $fim[1], $fim[0], $fim[2]);
	  
	  $diferenca = $data_fim - $data_ini; // 19522800 segundos
	  $dias = (int)floor( $diferenca / (60 * 60 * 24)); // 225 dias
	  return $dias;
  }
  
  /**
   * exibedata()
   * @param data no formato americano $us_data
   * @return data no formato brasileiro
   */
  function exibedata($us_data)
  {
	  $us_data = ($us_data) ? $us_data : "0000-00-00 00:00:00";
	  return (($us_data == "0000-00-00 00:00:00") or ($us_data == "0000-00-00")) ? "-" : date('d/m/Y',strtotime($us_data));
  }
  
  /**
   * hoje()
   * @param $us_data
   * @return verdadeiro para o dia de hoje
   */
  function hoje($us_data)
  {
	  $us_data = ($us_data) ? $us_data : "0000-00-00 00:00:00";
	  return ( date('d/m/Y') == date('d/m/Y',strtotime($us_data)));
  }
  
  /**
   * exibedataHora()
   * @param data no formato americano $us_data
   * @return data no formato brasileiro
   */
  function exibedataHora($us_data)
  {
	  $us_data = ($us_data) ? $us_data : "0000-00-00 00:00:00";
	  return ($us_data == "0000-00-00 00:00:00") ? "-" : date('d/m/Y H:i',strtotime($us_data));
  }
  
  /**
   * exibedataSegundo()
   * @param data no formato americano $us_data
   * @return data no formato brasileiro
   */
  function exibedataSMS($us_data)
  {
	  $us_data = ($us_data) ? $us_data : "0000-00-00 00:00:00";
	  return ($us_data == "0000-00-00 00:00:00") ? "-" : date('d-m-Y H:i:s',strtotime($us_data));
  }
  
  /**
   * exibeHora()
   * @param data no formato americano $us_data
   * @return data no formato brasileiro
   */
  function exibeHora($us_data)
  {
	  return ($us_data == "0000-00-00 00:00:00") ? "-" : date('H:i',strtotime($us_data));
  }
  
  /**
   * dataMySQL()
   * @param data no formato americano $us_data
   * @return data no formato brasileiro
   */
  function dataMySQL($us_data)
  {
	  return (strlen($us_data) > 11) ? substr($us_data,6,4)."-".substr($us_data,3,2)."-".substr($us_data,0,2)." ".substr($us_data,11,8) : substr($us_data,6,4)."-".substr($us_data,3,2)."-".substr($us_data,0,2);
  }
  
  /**
   * datavencimento()
   * @param data no formato americano $us_data
   * @return data no formato brasileiro
   */
  function datavencimento($datavencimento, $meses)
  {
	  $anos = round($meses / 12);
	  $us_data = ($datavencimento) ? $datavencimento : date("d/m/Y");
	  $ano = substr($us_data,6,4);
	  $mes = substr($us_data,3,2);
	  $dia = substr($us_data,0,2);
	  $mes = $mes + $meses;
	  if ($mes > 12)
	  {
		$mes = $mes - 12;
		$ano = $ano + 1;
	  }
	  return $ano."-".$mes."-".$dia;
  }


  /**
   * getSize()
   * 
   * @param $size
   * @param integer $precision
   * @param bool $long_name
   * @param bool $real_size
   * @return
   */
  function getSize($size, $precision = 2, $long_name = false, $real_size = true)
  {
      $base = $real_size ? 1024 : 1000;
      $pos = 0;
      while ($size > $base) {
          $size /= $base;
          $pos++;
      }
      $prefix = _getSizePrefix($pos);
      $size_name = $long_name ? $prefix . "bytes" : $prefix[0] . 'B';
      return round($size, $precision) . ' ' . ucfirst($size_name);
  }

  /**
   * _getSizePrefix()
   * 
   * @param $pos
   * @return
   */  
  function _getSizePrefix($pos)
  {
      switch ($pos) {
          case 00:
              return "";
          case 01:
              return "kilo";
          case 02:
              return "mega";
          case 03:
              return "giga";
          default:
              return "?-";
      }
  }
    
  /**
   * stripTags()
   * 
   * @param $start
   * @param $end
   * @param $string
   * @return
   */
  function stripTags($start, $end, $string)
  {
	  $string = stristr($string, $start);
	  $doend = stristr($string, $end);
	  return substr($string, strlen($start), -strlen($doend));
  }

  /**
   * cleanOut()
   * 
   * @param $text
   * @return
   */
  function cleanOut($text) {
	 $text =  strtr($text, array('\r\n' => "", '\r' => "", '\n' => ""));
	 $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
	 $text = str_replace('<br>', '<br />', $text);
	 return stripslashes($text);
  }

  /**
   * randName()
   * 
   * @return
   */ 
  function randName() {
	  $code = '';
	  for($x = 0; $x<6; $x++) {
		  $code .= '-'.substr(strtoupper(sha1(rand(0,999999999999999))),2,6);
	  }
	  $code = substr($code,1);
	  return $code;
  }
  
  function retira_acentos($texto) { 
	$array1 = array( "á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç" 
	, "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç", "'" ); 
	$array2 = array( "a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c" 
	, "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C", " " ); 
	return str_replace( $array1, $array2, $texto); 
  }

  /**
   * exibeMesAno()
   * @param data no formato false yyyy-mm-dd
   * @return data no formato true mm/yyyy
   */
  function exibeMesAno($mes_ano, $completo = false, $formato = false)
  {
	  if($formato)
	  {
		$d = explode("/", $mes_ano);
		$mes =  $d[0];
		$ano =  $d[1];
	  } else {
		$d = explode("-", $mes_ano);
		$mes =  $d[1];
		$ano =  $d[0];
	  }
	  switch ($mes) {
          case "01":
			  return ($completo) ? "JAN/".$ano : "JAN";
          case "02":
			  return ($completo) ? "FEV/".$ano : "FEV";
          case "03":
			  return ($completo) ? "MAR/".$ano : "MAR";
          case "04":
			  return ($completo) ? "ABR/".$ano : "ABR";
          case "05":
			  return ($completo) ? "MAI/".$ano : "MAI";
          case "06":
			  return ($completo) ? "JUN/".$ano : "JUN";
          case "07":
			  return ($completo) ? "JUL/".$ano : "JUL";
          case "08":
			  return ($completo) ? "AGO/".$ano : "AGO";
          case "09":
			  return ($completo) ? "SET/".$ano : "SET";
          case "10":
			  return ($completo) ? "OUT/".$ano : "OUT";
          case "11":
			  return ($completo) ? "NOV/".$ano : "NOV";
          case "12":
			  return ($completo) ? "DEZ/".$ano : "DEZ";
          default:
              return $mes."/".$ano;
      }
	  return ;
  }

    /**
   * menu()
   * @param pagina
   * @return class='active'
   */
  function menu($ativo)
  {
	  return ($ativo == Filter::$do) ? "class='active'" : "";
  }

    /**
   * menuCadastro()
   * @return class='active'
   */
  function menuCadastro()
  {
	  return ("usuario" == Filter::$do or "conta" == Filter::$do or "fornecedor" == Filter::$do or "banco" == Filter::$do or "empresa" == Filter::$do) ? "class='active'" : "";
  }
  
    /**
   * submenu()
   * @param acao
   * @return class='active'
   */
  function submenu($ativo)
  {
	  return ($ativo == Filter::$acao) ? "class='active'" : "";
  }

  /**
   * getCorDias()
   *
   */  
  function getCorDias($dias)
  {
	if($dias > 90)
		return "e51400";
	elseif($dias > 30)
		return "f8a31f";
	else
		return "393";
  }
  
  /**
   * getCorMes()
   *
   */  
  function getCorMes($dias)
  {
	if($dias > 210)
		return "e51400";
	elseif($dias > 150)
		return "f8a31f";
	else
		return "393";
  }
  
   /**
   * getClasse()
   *
   */  
  function getClasse($status)
  {
      switch ($status) {
          case 10:
              return "orange";
          case 11:
              return "pink";
          default:
              return "lightgrey";
      }
  }
  
   /**
   * getRestricao()
   *
   */  
  function getRestricao($restricao)
  {
      return ($restricao) ? "style='color:#f8a31f';" : "";
  }
  
   /**
   * tipoConta()
   *
   */  
  function tipoConta($tipo)
  {
      switch ($tipo) {
          case "C":
              return lang('CREDITO');
          case "I":
              return lang('INVESTIMENTO');
          case "DV":
              return lang('DESPESA_VARIAVEL');
          case "DF":
              return lang('DESPESA_FIXA');
          default:
              return lang('NAOINFORMADO');
      }
  }
  
   /**
   * mesCompetencia()
   *
   */  
  function mesCompetencia()
  {
      $data_competencia = explode("/",date("m/Y"));
	  $mes = $data_competencia[0];
	  $ano = $data_competencia[1];
	  if($mes == 1)
	  {
		$mes = 12;
		$ano = $data_competencia[1] - 1;
	  } else {
		$mes = $data_competencia[0] - 1;
	  }
	  return $mes."/".$ano;
  } 
  
   /**
   * getMeses()
   *
   */  
  function getMeses($periodo)
  {
      switch ($periodo) {
          case "MENSAL":
              return 1;
          case "TRIMESTRAL":
              return 3;
          case "SEMESTRAL":
              return 6;
          case "ANUAL":
              return 12;
      }
  }

   /**
   * validaTexto()
   * 
   * @param mixed $texto, $palavra
   * @return
   */
  function validaTexto($texto, $palavra)
  {
		$texto = retira_acentos($texto);
		$valida =  substr_count($texto, $palavra);
		return $valida;
  }
  
  /**
   * getCorCurva()
   *
   */  
  function getCorCurva($curva)
  {
	if($curva == "A")
		return "87e769";
	elseif($curva == "B")
		return "f8a31f";
	else
		return "e51400";
  }
  
  /**
   * getCorStatus()
   *
   */  
  function getCorStatus($status)
  {
	if($status == 1)
		return "ffffff";
	elseif($status == 5)
		return "fbbfbf";
	elseif($status == 4)
		return "ffdaa0";
	elseif($status == 2)
		return "badcfd";
	elseif($status == 3)
		return "bbf9bb";
	elseif($status == 6)
		return "fdffc4";
  }
  
  /**
   * getCorStatusProxima()
   *
   */  
  function getCorStatusProxima($status)
  {
	if($status == 1)
		return "bbf9bb";
	elseif($status == 2)
		return "fdffc4";
	elseif($status == 3)
		return "fbbfbf";
	elseif($status == 4)
		return "fbbfbf";
	elseif($status == 5)
		return "fbbfbf";
	elseif($status == 6)
		return "badcfd";
	elseif($status == 7)
		return "badcfd";
	else
		return "ffffff";
		
  }
  
	/**
       * unidades()
       * 
       * @param mixed $amount
       * @return
       */
      function unidades($amount, $un)
      {
          return number_format($amount, 2, ',', '.')." ".$un;
      }
  
   /**
   * nivel()
   *
   */  
  function nivel($nivel)
  {
      switch ($nivel) {
          case 8:
              return lang('MASTER');
          case 7:
              return lang('FINANCEIRO');
          case 5:
              return lang('GERENCIA');
          case 4:
              return lang('ATENDIMENTO');
          case 3:
              return lang('ENTREGADOR');
          default:
              return "-";
      }
  }
  
  /**
   * dataextenso()
   * @return data no formato extenso
   */
  function dataextenso($data = false)
  {
	  $data = ($data) ? $data : date("d/m/Y");
	  $d = explode("/", $data);
	  $dia =  $d[0];
	  $mes =  $d[1];
	  $ano =  $d[2];
	  $diasemana = date("w", mktime(0,0,0,$mes,$dia,$ano) );
	  switch($diasemana) {
		case 0: $semana = "domingo, ";  		break;
		case 1: $semana = "segunda-feira, "; 	break;
		case 2: $semana = "terça-feira, ";   	break;
		case 3: $semana = "quarta-feira, ";  	break;
		case 4: $semana = "quinta-feira, ";  	break;
		case 5: $semana = "sexta-feira, ";   	break;
		case 6: $semana = "sábado, ";   		break;
	  }
	
	  switch ($mes) {
          case 1:  $mes = " de janeiro de ";  	break;
          case 2:  $mes = " de fevereiro de ";  break;
          case 3:  $mes = " de março de ";  	break;
          case 4:  $mes = " de abril de "; 	 	break;
          case 5:  $mes = " de maio de ";  		break;
          case 6:  $mes = " de junho de ";  	break;
          case 7:  $mes = " de julho de ";  	break;
          case 8:  $mes = " de agosto de ";  	break;
          case 9:  $mes = " de setembro de ";  	break;
          case 10: $mes = " de outubro de ";  	break;
          case 11: $mes = " de novembro de ";  	break;
          case 12: $mes = " de dezembro de ";  	break;
      }
	  return $semana.$dia.$mes.$ano;
  }
  
?>