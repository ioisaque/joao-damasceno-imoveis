<?php
  /**
   * Functions
   *
   * @package Sistemas Folha do Comércio
   * @author Geandro Bessa
   * @copyright 2012
   */
  if (!defined("_VALID_PHP"))
      die('Acesso direto a esta classe não é permitido.');
   
   /**
   * percentual()
   * 
   * @param mixed $moeda
   * @return
   */
  function percentual($parte, $total)
  {
    return number_format(($parte/$total)*100);
  }
  
  /**
       * moeda()
       * 
       * @param mixed $amount
       * @return
       */
      function moeda($amount)
      {
          return ($amount > 0) ? "R$ " . number_format($amount, 2, ',', '.') : "Consulte-nos";
      }

   /**
   * converteValor()
   * 
   * @param mixed $valor
   * @return
   */
  function converteValor($valor)
  {
      $valor = str_replace("R$ ","",$valor);
	  $valida = strpos($valor, ",");
	  if ($valida)
	  {
		  $valor = str_replace(".","",$valor);
		  $valor = str_replace(",",".",$valor);
	  }
      return $valor;
  }  
  
  /**
   * convertePercentual()
   * 
   * @param mixed $percentual
   * @return
   */
  function convertePercentual($percentual)
  {
      return str_replace("%","",$percentual);
  }  
  
  /**
   * statusTarefa()
   * 
   * @param mixed $status
   * @return o nome da imagem referente ao status - 0:25:50:75:100
   */
  function statusTarefa($status)
  {
	if($status == 0)
		$imagem = "0";
	elseif($status < 35)
		$imagem = "25";
	elseif($status < 65)
		$imagem = "50";
	elseif($status < 100)
		$imagem = "75";
	else
		$imagem = "100";
		
	  return $imagem;
  }
  
  /**
   * redirect_to()
   * 
   * @param mixed $location
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
   * @param mixed $location
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
   * @param mixed $table
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
   * @param mixed $table
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
   * @param mixed $row
   * @param mixed $status
   * @return
   */
  function getChecked($row, $status)
  {
      if ($row == $status) {
          echo "checked=\"checked\"";
      }
  }
  
  /**
   * post()
   * 
   * @param mixed $var
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
   * @param mixed $var
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
   * @param mixed $string
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
		  
      return $string;
  }

  /**
   * cleanSanitize()
   * 
   * @param mixed $string
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
   * @param mixed $stwhatring
   * @param mixed $table
   * @param mixed $where
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
   * @param mixed $tip
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
  function somarData($data, $dias, $meses, $ano)
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
   * subHora()
   * @param data, dias, meses e ano
   * @return a soma na data
   */
  function subHora($horaini, $horafim)
  {	
	$hora1 = explode(":",$horaini);
	$hora2 = explode(":",$horafim);
	$acumulador1 = ($hora1[0] * 3600) + ($hora1[1] * 60) + $hora1[2];
	$acumulador2 = ($hora2[0] * 3600) + ($hora2[1] * 60) + $hora2[2];
	$resultado = $acumulador2 - $acumulador1;
	$hora_ponto = ($resultado / 3600);
	return $hora_ponto;
  }
  
  /**
   * exibedata()
   * @param data no formato americano $us_data
   * @return data no formato brasileiro
   */
  function exibedata($us_data)
  {
	  if(strlen($us_data) > 11)
	  {
		$retorno = ($us_data == "0000-00-00 00:00:00") ? "-" : date('d/m/Y',strtotime($us_data));
	  } else {
		$retorno = ($us_data == "0000-00-00") ? "" : date('d/m/Y',strtotime($us_data));
	  }
	  return $retorno;
  }
  
  /**
   * exibedataHora()
   * @param data no formato americano $us_data
   * @return data no formato brasileiro
   */
  function exibedataHora($us_data)
  {
	  return ($us_data == "0000-00-00 00:00:00") ? "-" : date('d/m/Y H:i',strtotime($us_data));
  }
  
  /**
   * exibedataHora()
   * @param data no formato americano $us_data
   * @return data no formato brasileiro
   */
  function dataMySQL($us_data)
  {
	  return (strlen($us_data) > 11) ? substr($us_data,6,4)."-".substr($us_data,3,2)."-".substr($us_data,0,2)." ".substr($us_data,11,8) : substr($us_data,6,4)."-".substr($us_data,3,2)."-".substr($us_data,0,2);
  }
  
  /**
   * exibedataHora()
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
   * @param mixed $size
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
   * @param mixed $pos
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
   * @param mixed $start
   * @param mixed $end
   * @param mixed $string
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
   * @param mixed $text
   * @return
   */
  function cleanOut($text) {
	 $text =  strtr($text, array('\r\n' => "", '\r' => "", '\n' => ""));
	 $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
	 $text = str_replace('<br>', '<br />', $text);
	 return stripslashes($text);
  }
    
  /**
   * isActive()
   * 
   * @param mixed $id
   * @return
   */
  function isActive($id)
  {
	  if ($id == 1) {
		  $display = '<img src="images/yes.png" alt="" class="tooltip" title="Published"/>';
	  } else {
		  $display = '<img src="images/no.png" alt="" class="tooltip" title="Unpublished"/>';
	  }

      return $display;;
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
  
  function redimensionar($imagem, $largura, $pasta){
		
		$name = md5(uniqid(rand(),true));
		
		if ($imagem['type']=="image/jpeg"){
			$img = imagecreatefromjpeg($imagem['tmp_name']);
		}else if ($imagem['type']=="image/gif"){
			$img = imagecreatefromgif($imagem['tmp_name']);
		}else if ($imagem['type']=="image/png"){
			$img = imagecreatefrompng($imagem['tmp_name']);
		}else {
			print Filter::msgAlert(lang('MSG_ERRO_IMAGEM'));
			return;
		}
		$x   = imagesx($img);
		$y   = imagesy($img);
		$autura = ($largura * $y)/$x;
		
		$nova = imagecreatetruecolor($largura, $autura);
		imagecopyresampled($nova, $img, 0, 0, 0, 0, $largura, $autura, $x, $y);
		
		if ($imagem['type']=="image/jpeg"){
			$local="$pasta/$name".".jpg";
			imagejpeg($nova, $local, 70);
		}else if ($imagem['type']=="image/gif"){
			$local="$pasta/$name".".gif";
			imagejpeg($nova, $local, 70);
		}else if ($imagem['type']=="image/png"){
			$local="$pasta/$name".".png";
			imagejpeg($nova, $local, 70);
		}		
		
		imagedestroy($img);
		imagedestroy($nova);	
		
		return $local;
	}
  
?>