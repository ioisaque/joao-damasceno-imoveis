<?php
  /**
   * Classe Filter
   *
   * @package Sistemas Divulgação Online
   * @author Geandro Bessa
   * @copyright 2013
   * @version 2
   */

  if (!defined("_VALID_PHP"))
      die('Acesso direto a esta classe não é permitido.');

  final class Filter
  {
	  public static $id = null;
	  public static $id_dentista = null;
      public static $get = array();
      public static $post = array();
      public static $cookie = array();
      public static $files = array();
      public static $server = array();
      private static $marker = array();
	  public static $msgs = array();
	  public static $showMsg;
	  public static $acao = null;
	  public static $do = null;

      /**
       * Filter::__construct()
       * 
       * @return
       */
      public function __construct()
      {
		  
          $_GET = self::clean($_GET);
          $_POST = self::clean($_POST);
          $_COOKIE = self::clean($_COOKIE);
          $_FILES = self::clean($_FILES);
          $_SERVER = self::clean($_SERVER);

          self::$get = $_GET;
          self::$post = $_POST;
          self::$cookie = $_COOKIE;
          self::$files = $_FILES;
          self::$server = $_SERVER;

		  self::getAcao();
		  self::getDo();
		  self::$id = self::getId();
      }

	  /**
	   * Filter::getId()
	   * 
	   * @return
	   */
	  private static function getId()
	  {
		  if (isset($_REQUEST['id'])) {
			  self::$id = (is_numeric($_REQUEST['id']) && $_REQUEST['id'] > -1) ? intval($_REQUEST['id']) : false;
			  self::$id = sanitize(self::$id);
			  
			  if (self::$id == false) {
				  DEBUG == true ? self::error("O codigo invalido", "Filter::getId()") : self::ooops("1");
			  } else
				  return self::$id;
		  }
	  }
	  
      /**
       * Filter::clean()
       * 
       * @param mixed $data
       * @return
       */
      public static function clean($data)
      {
          if (is_array($data)) {
              foreach ($data as $key => $value) {
                  unset($data[$key]);

                  $data[self::clean($key)] = self::clean($value);
              }
          } else {
			  if (ini_get('magic_quotes_gpc')) {
				  $data = stripslashes($data);
			  } else {
				  $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
			  }
		  }

          return $data;
      }

      /**
       * Core::msgAlert()
       * 
	   * @param mixed $msg
	   * @param bool $fader
	   * @param bool $altholder
       * @return
       */	  
	  public static function msgAlert($msg, $fader = true, $altholder = false)
	  {
		self::$showMsg = "<div class=\"msgAlert\">" . $msg . "</div>";
		if ($fader == true)
		  self::$showMsg .= "<script type=\"text/javascript\"> 
		  // <![CDATA[
			setTimeout(function() {       
			  $(\".msgAlert\").fadeOut(\"slow\",    
			  function() {       
				$(\".msgAlert\").remove();  
			  });
			},
			4000);
		  // ]]>
		  </script>";	
		  
		  print ($altholder) ? '<div id="alt-msgholder">'.self::$showMsg.'</div>' : self::$showMsg;
	  }

      /**
       * Core::msgOk()
       * 
	   * @param mixed $msg
	   * @param bool $fader
	   * @param bool $altholder
       * @return
       */	  
	  public static function msgOk($msg, $fader = true, $altholder = false)
	  {
		self::$showMsg = "<div class=\"msgOk\">" . $msg . "</div>";
		if ($fader == true)
		  self::$showMsg .= "<script type=\"text/javascript\"> 
		  // <![CDATA[
			setTimeout(function() {       
			  $(\".msgOk\").fadeOut(\"slow\",    
			  function() {       
				$(\".msgOk\").remove();  
			  });
			},
			4000);
		  // ]]>
		  </script>";	
		  
		  print ($altholder) ? '<div id="alt-msgholder">'.self::$showMsg.'</div>' : self::$showMsg;
	  }

      /**
       * Core::msgError()
       * 
	   * @param mixed $msg
	   * @param bool $fader
	   * @param bool $altholder
       * @return
       */	  
	  public static function msgError($msg, $fader = true, $altholder = false)
	  {
		self::$showMsg = "<div class=\"msgError\">" . $msg . "</div>";
		if ($fader == true)
		  self::$showMsg .= "<script type=\"text/javascript\"> 
		  // <![CDATA[
			setTimeout(function() {       
			  $(\".msgError\").fadeOut(\"slow\",    
			  function() {       
				$(\".msgError\").remove();  
			  });
			},
			4000);
		  // ]]>
		  </script>";	
	  
		  print ($altholder) ? '<div id="alt-msgholder">'.self::$showMsg.'</div>' : self::$showMsg;
	  }	


	  /**
	   * msgInfo()
	   * 
	   * @param mixed $msg
	   * @param bool $fader
	   * @param bool $altholder
	   * @return
	   */
	  public static function msgInfo($msg, $fader = true, $altholder = false)
	  {
		self::$showMsg = "<div class=\"msgInfo\">" . $msg . "</div>";
		if ($fader == true)
		  self::$showMsg .= "<script type=\"text/javascript\"> 
		  // <![CDATA[
			setTimeout(function() {       
			  $(\".msgInfo\").fadeOut(\"slow\",    
			  function() {       
				$(\".msgInfo\").remove();  
			  });
			},
			4000);
		  // ]]>
		  </script>";
	  
		  print ($altholder) ? '<div id="alt-msgholder">'.self::$showMsg.'</div>' : self::$showMsg;
	  }
	  
      /**
       * Filter::msgStatus()
       * 
       * @return
       */
	  public static function msgStatus()
	  {
		  self::$showMsg = "<div style='padding: 20px; padding-bottom: 1px;'><strong class='uppercase'>".lang('MSG_ERRO_GENERICO').":</strong><ul>";
		  foreach (self::$msgs as $msg) {
			  self::$showMsg .= "<li>" . $msg . "</li>\n";
		  }
		  self::$showMsg .= "</ul></div>";
		  
		  return self::$showMsg;
	  }	 

      /**
       * Filter::error()
       * 
	   * @param mixed $msg
	   * @param mixed $source
       * @return
       */
      public static function error($msg, $source)
      {
          $the_error = "<div class=\"container-fluid error\" id=\"content\">";
          $the_error .= "<div>";
          $the_error .= "<div class=\"wrapper\">";
          $the_error .= "<div class=\"code\"><i class=\"icon-warning-sign\"></i><span> Oops!</span></div>";
          $the_error .= "<div class=\"desc\">Você tentou acessar uma página que não existe mais.</div>";
          $the_error .= "<div class=\"desc\">Erro: ".$msg."<br/>Objeto: ".$source."</div>";
          $the_error .= "<div class=\"buttons\">";
          $the_error .= "<div class=\"pull-left\"><a href=\"javascript:history.go(-1)\" class=\"btn\"><i class=\"icon-arrow-left\"></i> Voltar</a></div>";
		  $the_error .= "</div>";
          $the_error .= "</div>";
          $the_error .= "</div>";
          $the_error .= "</div>";
          echo $the_error;
          die();
      }

      /**
       * Filter::ooops()
       * 
       * @return
       */
      public static function ooops()
      {
          $the_error .= "<html>";
		  $the_error .= "<head>	<meta charset=\"utf-8\"><meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no\"><meta name=\"apple-mobile-web-app-capable\" content=\"yes\"><meta names=\"apple-mobile-web-app-status-bar-style\" content=\"black-translucent\"><title>Oops!!</title><link rel=\"stylesheet\" href=\"css/bootstrap.min.css\"><link rel=\"stylesheet\" href=\"css/style.css\"><link rel=\"stylesheet\" href=\"css/themes.css\"><link rel=\"shortcut icon\" href=\"favicon.ico\"><link rel=\"apple-touch-icon-precomposed\" href=\"img/apple-touch-icon-precomposed.png\"></head>";
          $the_error .= "<body>";
		  $the_error .= "<div class=\"container-fluid error\" id=\"content\">";
          $the_error .= "<div>";
          $the_error .= "<div class=\"wrapper\">";
          $the_error .= "<div class=\"code\"><i class=\"icon-warning-sign\"></i><span> Oops!</span></div>";
          $the_error .= "<div class=\"desc\">Aconteceu um erro, repita a ação que você tentou executar. Se o erro persistir entre em contato com o administrador do sistema.</div>";
          $the_error .= "<div class=\"buttons\">";
          $the_error .= "<div class=\"pull-left\"><a href=\"index.php\" class=\"btn\"><i class=\"icon-arrow-left\"></i> Voltar</a></div>";
		  $the_error .= "</div>";
          $the_error .= "</div>";
          $the_error .= "</div>";
          $the_error .= "</div>";
          $the_error .= "</body>";
          $the_error .= "</html>";
          echo $the_error;
          die();
		  
      }
	  
      /**
       * Filter::getAcao()
       * 
       * @return
       */
	  private static function getAcao()
	  {
		  if (isset(self::$get['acao'])) {
			  $acao = ((string)self::$get['acao']) ? (string)self::$get['acao'] : false;
			  $acao = sanitize($acao);
			  
			  if ($acao == false) {
				  self::error("A acao escolhida invalida","Filter::getAcao()");
			  } else
				  return self::$acao = $acao;
		  }
	  }
	  	  
      /**
       * Filter::getDo()
       * 
       * @return
       */
	  private static function getDo()
	  {
		  if (isset(self::$get['do'])) {
			  $do = ((string)self::$get['do']) ? (string)self::$get['do'] : false;
			  $do = sanitize($do);
			  
			  if ($do == false) {
				  self::error("Pagina nao encontrada","Filter::getDo()");
			  } else
				  return self::$do = $do;
		  }
	  }

	  /**
	   * Filter::dodate()
	   * 
	   * @param mixed $format
	   * @param mixed $date
	   * @return
	   */  
	  public static function dodate($format, $date) {
		  
		return strftime($format, strtotime($date));
	  } 
  
	  /**
	   * Filter::readFile()
	   * 
	   * @param mixed $filename
	   * @param boll $retbytes
	   * @return
	   */
	  public static function readFile($filename,$retbytes=true) {  
		 $chunksize = 1*(1024*1024);
		 $buffer = '';  
		 $cnt =0;  
	
		 $handle = fopen($filename, 'rb');  
		 if ($handle === false) {  
			 return false;  
		 }  
		 while (!feof($handle)) {  
			 $buffer = fread($handle, $chunksize);  
			 echo $buffer;  
			 ob_flush();  
			 flush();  
			 if ($retbytes) {  
				 $cnt += strlen($buffer);  
			 }  
		 }  
			 $status = fclose($handle);  
		 if ($retbytes && $status) {  
			 return $cnt;
		 }  
		 return $status;  
	   
	  }	  	
	  
	  /**
	   * Filter::fetchFile()
	   * 
	   * @param mixed $dirname
	   * @param mixed $nome
	   * @param mixed $file_path
	   * @return
	   */
	  public function fetchFile($dirname, $nome, &$file_path)
	  {
		  $dir = opendir($dirname);
		  
		  while ($file = readdir($dir)) {
			  if (empty($file_path) && $file != '.' && $file != '..') {
				  if (is_dir($dirname . '/' . $file)) {
					  self::fetchFile($dirname . '/' . $file, $nome, $file_path);
				  } else {
					  if (file_exists($dirname . '/' . $nome)) {
						  $file_path = $dirname . '/' . $nome;
						  return;
					  }
				  }
			  }
		  }
	  }
	  
      /**
       * Filter::mark()
       * 
       * @param mixed $name
       * @return
       */
      public static function mark($name)
      {
          self::$marker[$name] = microtime();
      }


      /**
       * Filter::elapsed()
       * 
       * @param string $point1
       * @param string $point2
       * @param integer $decimals
       * @return
       */
      public static function elapsed($point1 = '', $point2 = '', $decimals = 4)
      {

          if (!isset(self::$marker[$point1])) {
              return '';
          }

          if (!isset(self::$marker[$point2])) {
              self::$marker[$point2] = microtime();
          }

          list($sm, $ss) = explode(' ', self::$marker[$point1]);
          list($em, $es) = explode(' ', self::$marker[$point2]);

          return number_format(($em + $es) - ($sm + $ss), $decimals);
      }
  }
?>