<?php
  /**
   * Index
   *
   * @package Sistemas Folha do Comércio
   * @author Geandro Bessa
   * @copyright 2013
   */
  define("_VALID_PHP", true);
  
  require_once("init.php");
?>
<?php include("header.php");?>
	  <!-- Start Content-->
		  <?php (Filter::$do && file_exists(Filter::$do.".php")) ? include(Filter::$do.".php") : include("home.php");?>
	  <!-- End Content/-->
<?php include("footer.php");?>