<?php
  /**
   * Init
   *
   * @package Sistemas Divulgação Online
   * @author Geandro Bessa
   * @copyright 2013
   * @version 2
   */
  if (!defined("_VALID_PHP"))
      die('Acesso direto a esta classe não é permitido.');
?>
<?php //error_reporting(E_ALL);
  
  if (substr(PHP_OS, 0, 3) == "WIN") {
      $BASEPATH = str_replace("init.php", "", realpath(__FILE__));
  } else {
      $BASEPATH = str_replace("init.php", "", realpath(__FILE__));
  }
  define("BASEPATH", $BASEPATH);
  
  $configFile = BASEPATH . "lib/config.ini.php";
  if (file_exists($configFile)) {
      require_once($configFile);
  } else {
      header("Location: setup/");
  }
  
  //include_once(BASEPATH . "language.php");
  require_once(BASEPATH . "lib/class_db.php");
  
  require_once(BASEPATH . "lib/class_registry.php");
  Registry::set('Database',new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE));
  $db = Registry::get("Database");
  $db->connect();

  //Include Functions
  require_once(BASEPATH . "lib/functions.php");
  include(BASEPATH . "lib/headerRefresh.php");
  
  require_once(BASEPATH . "lib/class_filter.php");
  $request = new Filter();  
  
  //Start Core Class 
  require_once(BASEPATH . "lib/class_core.php");
  Registry::set('Core',new Core());
  $core = Registry::get("Core");
  
  //Start imoveis Class
  require_once(BASEPATH . "lib/class_imoveis.php");
  Registry::set('imoveis',new imoveis());
  $imoveis = Registry::get("imoveis");

  define("SITEURL", $core->site_url);
  define("ADMINURL", $core->site_sistema);
?>