<?php
  /**
   * Classe Registry
   *
   * @package Sistemas Folha do Comércio
   * @author Geandro Bessa
   * @copyright 2012
   */

  if (!defined("_VALID_PHP"))
      die('Acesso direto a esta classe não é permitido.');
	  
  abstract class Registry
  {
      static $objects = array();


      /**
       * Registry::get()
       * 
       * @param mixed $name
       * @return
       */
      public static function get($name)
      {
          return isset(self::$objects[$name]) ? self::$objects[$name] : null;
      }

      /**
       * Registry::set()
       * 
       * @param mixed $name
       * @param mixed $object
       * @return
       */
      public static function set($name, $object)
      {
          self::$objects[$name] = $object;
      }
  }
?>