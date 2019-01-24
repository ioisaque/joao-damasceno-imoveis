<?php
  /**
   * Classe imoveis
   *
   * @package Sistemas Divulgação Online
   * @author Geandro Bessa
   * @copyright 2013
   * @version 2
   */
  
  if (!defined("_VALID_PHP"))
      die('Acesso direto a esta classe não é permitido.');

  class imoveis
  {
      private static $db;

      /**
       * imoveis::__construct()
       * 
       * @return
       */
      function __construct()
      {
          self::$db = Registry::get("Database");
      }

     /*################################################
					GENERIC::getItemByID()
      ################################################*/
      public function getItemByID($table, $ID)
      {
		  $sql = "SELECT p.* " 
		  . "\n FROM $table as p "
		  . "\n WHERE p.id = $ID";
		  //echo $sql;
		  
          $row = self::$db->first($sql);

          return ($row) ? $row : 0;
      }	  

      /**
       * imoveis::getImovelByID()
       * 
       * @return
       */
      public function getImovelByID($ID)
      {
		  return self::getItemByID('cad_imoveis', $ID);
      } 	  
	  
	  /**
       * imoveis::getImoveisCount()
       * 
       * @return number of items in the database table
       */
      public function getImoveisCount()
      {
		$inputLocalizacao = (empty($_GET['inputLocalizacao'])) ? "" : "AND (i.bairro LIKE '%".$_GET['inputLocalizacao']."%'
																	   OR i.cidade LIKE '%".$_GET['inputLocalizacao']."%')";		  
		  
		  $inputTipo = 			(empty($_GET['inputTipo'])) 		? "" : " AND i.id_tipo 		= 	'".$_GET['inputTipo']."'";
		  $inputOperacao = 		(empty($_GET['inputOperacao'])) 	? "" : " AND i.operacao 	= 	'".$_GET['inputOperacao']."'";
		  
		  $inputGaragem = 		(empty($_GET['inputGaragem'])) 		? "" : " AND i.garagem 		 	".$_GET['inputGaragem']."";
		  $inputQuartos = 		(empty($_GET['inputQuartos'])) 		? "" : " AND i.quartos 		 	".$_GET['inputQuartos']."";
		  $inputBanheiros = 	(empty($_GET['inputBanheiros'])) 	? "" : " AND i.banheiros 	 	".$_GET['inputBanheiros']."";
		  
		  $inputPrecoMinimo = 	(empty($_GET['inputPrecoMinimo'])) 	? "" : " AND i.valor 		> 	'".$_GET['inputPrecoMinimo']."'";
		  $inputPrecoMaximo = 	(empty($_GET['inputPrecoMaximo'])) 	? "" : " AND i.valor 		< 	'".$_GET['inputPrecoMaximo']."'";
		  
		  $inputOrderBy = 		(empty($_GET['inputOrderBy'])) 		? "" : " ORDER BY				'".$_GET['inputOrderBy']."'";		  
		  
		  $sql = "SELECT COUNT(1) AS quant " 
		  . "\n FROM cad_imoveis as i "
		  . "\n WHERE i.id_status > 0 "		  
		  . "\n $inputLocalizacao "
		  . "\n $inputTipo "
		  . "\n $inputOperacao "
		  . "\n $inputGaragem "
		  . "\n $inputQuartos "
		  . "\n $inputBanheiros "
		  . "\n $inputPrecoMinimo "
		  . "\n $inputPrecoMaximo "
		  . "\n $inputOrderBy";
		  
		  $row = self::$db->fetch_all($sql);
		  
		  $Count = $row[0]->quant;
		  
          return ($Count) ? $Count : 0;
      }	  
	  
      /**
       * imoveis::getImoveisTipos()
       * 
       * @return
       */	  
	  public function getImoveisTipos()
	  {
		  $sql = "SELECT i.* "
		  . "\n FROM cad_tipo as i ";
		  
		  $row = self::$db->fetch_all($sql);
		  
        return ($row) ? $row : 0;		  
	  }	

	  /**
       * imoveis::getImoveisPagination()
       * 
       * @return
       */	  
      public function getImoveisPagination($PAGE = 1,	$ITEMS_PP = 9)
      {	
		if (!empty(get('nItems')))
		  if (get('nItems') <= $this->getImoveisCount())
		    $ITEMS_PP	= get('nItems');
		  else
			$ITEMS_PP	= $this->getImoveisCount();
		  
		$numberOfPages = $this->getImoveisCount() / $ITEMS_PP;	

		if (!empty(get('page')))
		  if (get('page') <= $numberOfPages)
			$PAGE = get('page');
		  else
			$PAGE = 1;
		  
		  $PAGE = ($PAGE-1)*$ITEMS_PP;
		  
          return array('PAGE' => $PAGE, 'ITEMS_PP' => $ITEMS_PP);
      }
	  
      /**
       * imoveis::getImoveis()
       * 
       * @return
       */
	  public function getImoveis($PAGE = 1,	$ITEMS_PP = 9)
	  {
		$inputLocalizacao = (empty($_GET['inputLocalizacao'])) ? "" : "AND (i.bairro LIKE '%".$_GET['inputLocalizacao']."%'
																	   OR i.cidade LIKE '%".$_GET['inputLocalizacao']."%')";		  
		  
		  $inputTipo = 			(empty($_GET['inputTipo'])) 		? "" : " AND i.id_tipo 		= 	'".$_GET['inputTipo']."'";
		  $inputOperacao = 		(empty($_GET['inputOperacao'])) 	? "" : " AND i.operacao 	= 	'".$_GET['inputOperacao']."'";
		  
		  $inputGaragem = 		(empty($_GET['inputGaragem'])) 		? "" : " AND i.garagem 		 	".$_GET['inputGaragem']."";
		  $inputQuartos = 		(empty($_GET['inputQuartos'])) 		? "" : " AND i.quartos 		 	".$_GET['inputQuartos']."";
		  $inputBanheiros = 	(empty($_GET['inputBanheiros'])) 	? "" : " AND i.banheiros 	 	".$_GET['inputBanheiros']."";
		  
		  $inputPrecoMinimo = 	(empty($_GET['inputPrecoMinimo'])) 	? "" : " AND i.valor 		> 	'".$_GET['inputPrecoMinimo']."'";
		  $inputPrecoMaximo = 	(empty($_GET['inputPrecoMaximo'])) 	? "" : " AND i.valor 		< 	'".$_GET['inputPrecoMaximo']."'";
		  
		  // $inputOrderBy = 		(empty($_GET['inputOrderBy'])) 		? "" : " ORDER BY i.destaque	'".$_GET['inputOrderBy']."'";
		  $inputOrderBy = 		" ORDER BY i.id DESC ";
		  
		  
			$p = self::getImoveisPagination($PAGE, $ITEMS_PP);
		
			$inputPagination = " LIMIT " .intval($p['PAGE']).','.intval($p['ITEMS_PP']);
	  	  
		  
		  $sql = "SELECT i.* "
		  . "\n FROM cad_imoveis as i "
		  . "\n WHERE i.id_status > 0 "
		  . "\n $inputLocalizacao "
		  . "\n $inputTipo "
		  . "\n $inputOperacao "
		  . "\n $inputGaragem "
		  . "\n $inputQuartos "
		  . "\n $inputBanheiros "
		  . "\n $inputPrecoMinimo "
		  . "\n $inputPrecoMaximo "
		  . "\n $inputOrderBy"
		  . "\n $inputPagination";
		  //echo $sql;
		  	  
		  $row = self::$db->fetch_all($sql);
		  
        return ($row) ? $row : 0;
	  }
	  
      /**
       * imoveis::getSimilarImoveis()
       * 
       * @return
       */
	  public function getSimilarImoveis($id, $bairro)
	  {
		  $sql = "SELECT i.* "
		  . "\n FROM cad_imoveis as i "
		  . "\n WHERE i.id_status > 0 "		  
		  . "\n AND i.id != '$id' "	  
		  . "\n AND i.bairro = '$bairro' "	  
		  . "\n ORDER BY i.id "		  
		  . "\n LIMIT 6";
		  
		  $row = self::$db->fetch_all($sql);
		  
        return ($row) ? $row : 0;
	  }	  
	  
	   /**
       * imoveis::getImovelIMGs()
       * 
       * @return
       */
      public function getImovelIMGs($ID)
      {
		  $sql = "SELECT i.nome " 
		  . "\n FROM imv_imagens as i "
		  . "\n WHERE i.id_imoveis = $ID ";
		  //echo $sql;
		  
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }	
	  
	   /**
       * imoveis::getImovelFeaturedIMG()
       * 
       * @return
       */
      public function getImovelFeaturedIMG($ID)
      {
		  $sql = "SELECT i.nome " 
		  . "\n FROM imv_imagens as i "
		  . "\n WHERE i.id_imoveis = $ID "
		  . "\n AND i.destaque = 1 ";
		  //echo $sql;
		  
          $row = self::$db->first($sql);

          return ($row) ? '/uploads/data/'.$row->nome : '/uploads/placeholder.jpg';
      }	  

      /**
       * imoveis::getIndexGridImoveis()
       * 
       * @return
       */
	  public function getIndexGridImoveis()
	  {
		  $sql = "SELECT i.* "
		  . "\n FROM cad_imoveis as i "
		  . "\n WHERE i.id_status > 0 "		  
		  . "\n ORDER BY i.id "		  
		  . "\n LIMIT 12";
		  
		  $row = self::$db->fetch_all($sql);
		  
        return ($row) ? $row : 0;
	  }	

      /**
       * imoveis::getDestaqueImoveis()
       * 
       * @return
       */
	  public function getDestaqueImoveis()
	  {
		  $sql = "SELECT i.* "
		  . "\n FROM cad_imoveis as i "
		  . "\n WHERE i.id_status > 0 "		  
		  . "\n AND i.destaque = 1 "		  
		  . "\n ORDER BY i.id DESC "		  
		  . "\n LIMIT 12";
		  
		  $row = self::$db->fetch_all($sql);
		  
        return ($row) ? $row : 0;
	  }	 	

	        /**
       * imoveis::setImoveisFilter()
       * 
       * @return
       */
	  public function setImoveisFilter($nome, $value)
	  {
		  $url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
			$url .= (parse_url($url, PHP_URL_QUERY) ? '&' : '?') . "$nome=$value";   
		
		  return $url;
	  }	 
  }
?>