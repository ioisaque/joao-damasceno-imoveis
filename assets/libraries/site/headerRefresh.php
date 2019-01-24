<?php
  /**
   * Header Refresh
   *
   * @package Sistemas Folha do Comércio
   * @author Geandro Bessa
   * @copyright 2012
   */
  // Date in the past
  header("Expires: Thu, 17 May 2001 10:17:17 GMT");
  // always modified
  header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
  // HTTP/1.1
  header("Cache-Control: no-cache, must-revalidate");
  header("Pragma: no-cache");
  ob_start();
?>