<?php
  /**
   * Init
   *
   * @package Sistemas Folha do Comércio
   * @author Geandro Bessa
   * @copyright 2012
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
  
  $configFile = BASEPATH . "assets/libraries/site/config.ini.php";
  if (file_exists($configFile)) {
      require_once($configFile);
  } else {
      header("Location: setup/");
  }
  
  //include_once(BASEPATH . "language.php");
  require_once(BASEPATH . "assets/libraries/site/class_db.php");
  
  require_once(BASEPATH . "assets/libraries/site/class_registry.php");
  Registry::set('Database',new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE));
  $db = Registry::get("Database");
  $db->connect();

  //Include Functions
  require_once(BASEPATH . "assets/libraries/site/functions.php");
  include(BASEPATH . "assets/libraries/site/headerRefresh.php");
  
  require_once(BASEPATH . "assets/libraries/site/class_filter.php");
  $request = new Filter();  
  
  //Start Core Class 
  require_once(BASEPATH . "assets/libraries/site/class_core.php");
  Registry::set('Core',new Core());
  $core = Registry::get("Core");

  //Load Content Class
  require_once(BASEPATH . "assets/libraries/site/class_content.php");
  Registry::set('Content',new Content());
  $content = Registry::get("Content");

  //Start Paginator Class 
  require_once(BASEPATH . "assets/libraries/site/class_paginate.php");
  $pager = Paginator::instance();
  
  //Classe Imoveis 
  require_once(BASEPATH . "assets/libraries/site/class_imoveis.php");
  Registry::set('Imoveis',new Imoveis());
  $imoveis = Registry::get("Imoveis");
  
  //Start Uploader Class 
  require_once(BASEPATH . "assets/libraries/site/class_upload.php");

  define("SITEURL", $core->site_url);
  define("ADMINURL", $core->site_url);
  define("UPLOADS", BASEPATH."uploads/");
  define("UPLOADURL", SITEURL."/uploads/");
?>