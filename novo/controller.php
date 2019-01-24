<?php
   /**
   * Controller
   *
   * @package Sistemas Divulgação Online
   * @author Geandro Bessa
   * @copyright 2013
   * @version 2
   */
  define("_VALID_PHP", true);
  
  require_once("init.php");
?>
<?php

  /* == Alterar Status == */
  if (isset($_POST['ProcessarPedido'])):
      if (intval($_POST['ProcessarPedido']) == 0 || empty($_POST['ProcessarPedido'])):
          die();
      endif;
	  
	    $site->ProcessarPedido();
  endif;
?>