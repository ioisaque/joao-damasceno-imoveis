<?php
  /**
   * Classe Filter
   *
   * @package Sistemas Folha do Com�rcio
   * @author Geandro Bessa
   * @copyright 2012
   */

  if (!defined("_VALID_PHP"))
      die('Acesso direto a esta classe n�o � permitido.');

  final class Filter
  {
	  public static $id = null;
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
				  DEBUG == true ? self::error("You have selected an Invalid Id", "Filter::getId()") : self::ooops("1");
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
		self::$showMsg = "<div class=\"nNote nWarning hideit\"><p>" . $msg . "</p></div>";
		if ($fader == true)
		  self::$showMsg .= "<script type=\"text/javascript\"> 
		  // <![CDATA[
			setTimeout(function() {       
			  $(\".nWarning\").fadeOut(\"slow\",    
			  function() {       
				$(\".nWarning\").remove();  
			  });
			},
			4000);
		  // ]]>
		  </script>";	
		  
		  print ($altholder) ? '<div id="alt-msgholder"><p>'.self::$showMsg.'</p></div>' : self::$showMsg;
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
		self::$showMsg = "<div class=\"nNote nSuccess hideit\"><p>" . $msg . "</p></div>";
		if ($fader == true)
		  self::$showMsg .= "<script type=\"text/javascript\"> 
		  // <![CDATA[
			setTimeout(function() {       
			  $(\".nSuccess\").fadeOut(\"slow\",    
			  function() {       
				$(\".nSuccess\").remove();  
			  });
			},
			4000);
		  // ]]>
		  </script>";	
		  
		  print ($altholder) ? '<div id="alt-msgholder"><p>'.self::$showMsg.'</p></div>' : self::$showMsg;
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
		self::$showMsg = "<div class=\"nNote nFailure hideit\"><p>" . $msg . "</p></div>";
		if ($fader == true)
		  self::$showMsg .= "<script type=\"text/javascript\"> 
		  // <![CDATA[
			setTimeout(function() {       
			  $(\".nFailure\").fadeOut(\"slow\",    
			  function() {       
				$(\".nFailure\").remove();  
			  });
			},
			4000);
		  // ]]>
		  </script>";	
	  
		  print ($altholder) ? '<div id="alt-msgholder"><p>'.self::$showMsg.'</p></div>' : self::$showMsg;
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
		self::$showMsg = "<div class=\"nNote nInformation hideit\"><p>" . $msg . "</p></div>";
		if ($fader == true)
		  self::$showMsg .= "<script type=\"text/javascript\"> 
		  // <![CDATA[
			setTimeout(function() {       
			  $(\".nInformation\").fadeOut(\"slow\",    
			  function() {       
				$(\".nInformation\").remove();  
			  });
			},
			4000);
		  // ]]>
		  </script>";
	  
		  print ($altholder) ? '<div id="alt-msgholder"><p>'.self::$showMsg.'</p></div>' : self::$showMsg;
	  }
	  
      /**
       * Filter::msgStatus()
       * 
       * @return
       */
	  public static function msgStatus()
	  {
		  self::$showMsg = "<div class=\"nNote nFailure hideit\"><p><strong>Erro!</strong>Ocorreu um erro ao processar a solicitação.</p>";
		  foreach (self::$msgs as $msg) {
			  self::$showMsg .= "<p>" . $msg . "</p>\n";
		  }
		  self::$showMsg .= "</div>";
		  
		  self::$showMsg .= "<script type=\"text/javascript\"> 
		  // <![CDATA[
			setTimeout(function() {       
			  $(\".nFailure\").fadeOut(\"slow\",    
			  function() {       
				$(\".nFailure\").remove();  
			  });
			},
			2000);
		  // ]]>
		  </script>";
		  
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

          $the_error = "<div class=\"nNote nFailure hideit\"><p>";
          $the_error .= "<strong>System ERROR!</strong><br />";
          $the_error .= "DB Error: ".$msg." <br /> More Information: </p>";
          $the_error .= "<p> Date : " . date("F j, Y, g:i a") . "</p>";
		  $the_error .= "<p> Function: " . $source . "</p>";
          $the_error .= "<p> Script: " . $_SERVER['REQUEST_URI'] . "</p>";
		  $the_error .= "<p>&lsaquo; <a href=\"javascript:history.go(-1)\"><strong>Go Back to previous page</strong></a></p>";
          $the_error .= '</div>';
          print $the_error;
          die();
      }

      /**
       * Filter::ooops()
       * 
       * @return
       */
      public static function ooops($teste = false)
      {
          $the_error = "<div style=\"color:#444;width:400px;margin-left:auto;margin-right:auto;border:1px solid #C3C3C3;font-family:Arial, Helvetica, sans-serif;font-size:13px;padding:10px;background:#f2f2f2;border-radius:5px;text-shadow:1px 1px 0 #fff\">";
          $the_error .= "<h4 style=\"font-size:18px;margin:10px 0px 0px 10px;padding:0\">Oops!!!</h4>";
          $the_error .= "<p>".$teste." - Aconteceu um erro, repita a ação que você está executando. Se o erro persistir entre em contato com o administrador do sistema.</p>";
          $the_error .= '</div>';
          print $the_error;
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
				  self::error("You have selected an Invalid Action Method","Filter::getAcao()");
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
				  self::error("You have selected an Invalid Do Method","Filter::getDo()");
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