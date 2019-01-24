<?php
  /**
   * Classe Imoveis
   *
   * @package Sistemas Folha do Comércio
   * @author Geandro Bessa
   * @copyright 2012
   */
  
  if (!defined("_VALID_PHP"))
      die('Acesso direto a esta classe não é permitido.');

  class Imoveis
  {
      public $did = 0;
      private static $db;

      /**
       * Imoveis::__construct()
       * 
       * @return
       */
      function __construct()
      {
          self::$db = Registry::get("Database");
      }
	  
	  public function getImoveis($modificados = false, $quant = false, $pags = false)
      {		  
		  $limite = ($quant) ? "LIMIT ".$quant : "";
		  if($pags)
		  {
			  $counter = contarEntradas("cad_imoveis", "id_status > 0");
			  
			  $pager = Paginator::instance();
			  $pager->items_total = $counter;
			  $pager->default_ipp = $quant;
			  $pager->paginate();
			  $limite = $pager->limit;
		  }
		  
		  $inputCidade = (empty($_GET['inputCidade'])) ? "" : " AND i.cidade = '".$_GET['inputCidade']."'";
		  $inputBairro = (empty($_GET['inputBairro'])) ? "" : " AND i.bairro = '".$_GET['inputBairro']."'";
		  $inputTipo = (empty($_GET['inputTipo'])) ? "" : " AND i.id_tipo = '".$_GET['inputTipo']."'";
		  $inputAluguel = (empty($_GET['inputAluguel'])) ? "" : " AND i.operacao = 'ALUGUEL'";
		  $inputVenda = (empty($_GET['inputVenda'])) ? "" : " AND i.operacao = 'VENDA'";
		  $inputPrecoMinimo = (empty($_GET['inputPrecoMinimo'])) ? "" : " AND i.valor > '".$_GET['inputPrecoMinimo']."'";
		  $inputPrecoMaximo = (empty($_GET['inputPrecoMaximo'])) ? "" : " AND i.valor < '".$_GET['inputPrecoMaximo']."'";
		  
		  $orderby = ($modificados) ? "ORDER BY i.data DESC" : "ORDER BY i.data_criacao DESC";
		  $sql = "SELECT i.id, i.titulo, i.descricao, p.nome as proprietario, c.nome as comprador, u.nome as corretor, i.valor, t.tipo, i.operacao, i.area, i.quartos, i.suites, i.banheiros, i.garagem, i.endereco, i.numero, i.complemento, i.bairro, i.cidade, i.uf, i.cep, s.status, i.chaves, i.vervalor, i.verendereco, i.piscina, i.churrasqueira, i.elevador, i.portao, i.armario, i.guardaroupa, i.data_criacao, i.data " 
		  . "\n FROM cad_imoveis AS i"
		  . "\n LEFT JOIN cad_clientes AS c on c.id = i.id_comprador "
		  . "\n LEFT JOIN cad_clientes AS p on p.id = i.id_proprietario "
		  . "\n LEFT JOIN cad_status AS s on s.id = i.id_status "
		  . "\n LEFT JOIN cad_tipo AS t on t.id = i.id_tipo "	
		  . "\n LEFT JOIN usuario AS u on u.id = i.id_corretor "	  
		  . "\n WHERE i.id_status > 0"
		  . "\n $inputCidade "
		  . "\n $inputBairro "
		  . "\n $inputTipo "
		  . "\n $inputAluguel "
		  . "\n $inputVenda "
		  . "\n $inputPrecoMinimo "
		  . "\n $inputPrecoMaximo "
		  . "\n $orderby $limite"; 
          //echo $sql;
		  $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }
	  
	  
	  
	  public function getImoveisDestaque($modificados = false, $quant = false, $slide = false)
      {		  
		  $destaque = ($slide) ? " AND i.destaque = 1 " : "";
		  $limite = ($quant) ? "LIMIT ".$quant : "";
		  $orderby = ($modificados) ? "ORDER BY i.data DESC" : "ORDER BY i.data_criacao DESC";
		  $sql = "SELECT i.id, i.titulo, i.descricao, p.nome as proprietario, c.nome as comprador, u.nome as corretor, i.valor, t.tipo, i.operacao, i.area, i.quartos, i.suites, i.banheiros, i.garagem, i.endereco, i.numero, i.complemento, i.bairro, i.cidade, i.uf, i.cep, s.status, i.chaves, i.vervalor, i.verendereco, i.piscina, i.churrasqueira, i.elevador, i.portao, i.armario, i.guardaroupa, i.data_criacao, i.data " 
		  . "\n FROM cad_imoveis AS i"
		  . "\n LEFT JOIN cad_clientes AS c on c.id = i.id_comprador "
		  . "\n LEFT JOIN cad_clientes AS p on p.id = i.id_proprietario "
		  . "\n LEFT JOIN cad_status AS s on s.id = i.id_status "
		  . "\n LEFT JOIN cad_tipo AS t on t.id = i.id_tipo "	
		  . "\n LEFT JOIN usuario AS u on u.id = i.id_corretor "	 
		  . "\n LEFT JOIN imv_imagens AS m on m.id_imoveis = i.id "			  
		  . "\n WHERE i.id_status > 0 AND m.destaque = '1' "
		  . "\n $destaque $orderby $limite";
          //echo $sql;
		  $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }
	  
	  /**
       * Imoveis::getImoveis()
	   *
       * @return
       */
	  public function getImovel($id)
      {
          $sql = "SELECT i.id, i.titulo, i.descricao, p.nome as proprietario, c.nome as comprador, u.nome as corretor, i.valor, t.tipo, i.operacao, i.area, i.quartos, i.suites, i.banheiros, i.garagem, i.endereco, i.numero, i.complemento, i.bairro, i.cidade, i.uf, i.cep, s.status, i.chaves, i.vervalor, i.verendereco, i.piscina, i.churrasqueira, i.elevador, i.portao, i.armario, i.guardaroupa, i.data_criacao, i.data " 
		  . "\n FROM cad_imoveis AS i"
		  . "\n LEFT JOIN cad_clientes AS c on c.id = i.id_comprador "
		  . "\n LEFT JOIN cad_clientes AS p on p.id = i.id_proprietario "
		  . "\n LEFT JOIN cad_status AS s on s.id = i.id_status "
		  . "\n LEFT JOIN cad_tipo AS t on t.id = i.id_tipo "	
		  . "\n LEFT JOIN usuario AS u on u.id = i.id_corretor "	  
		  . "\n WHERE i.id = $id";
          $row = self::$db->first($sql);

          return ($row) ? $row : 0;
      }
	  
	  /**
       * Imoveis::getTipo()
	   *
       * @return
       */
	  public function getTipo()
      {
          $sql = "SELECT id, tipo" 
		  . "\n FROM cad_tipo";
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }
	  
	  /**
       * Imoveis::getCidades()
	   *
       * @return
       */
	  public function getCidades()
      {
          $sql = "SELECT DISTINCT cidade" 
		  . "\n FROM cad_imoveis"
		  . "\n ORDER BY cidade";
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }
	  
	  /**
       * Imoveis::getStatus()
	   *
       * @return
       */
	  public function getStatus()
      {
          $sql = "SELECT id, status" 
		  . "\n FROM cad_status";
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }
	  
	  /**
       * Imoveis::getImagens()
	   *
       * @return
       */
	  public function getImagens($id)
      {
          $sql = "SELECT id, id_imoveis, nome, destaque" 
		  . "\n FROM imv_imagens"
		  . "\n WHERE id_imoveis = $id"
		  . "\n ORDER BY destaque DESC";
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }
	  
	  /**
       * Imoveis::getDestaque()
	   *
       * @return
       */
	  public function getDestaque($id)
      {
          return Registry::get("Core")->site_sistema."/uploads/data/".$id."-destaque.jpg";
      }
	  
	  /**
       * Imoveis::getSlide()
	   *
       * @return
       */
	  public function getSlide($id)
      {
          return Registry::get("Core")->site_sistema."/uploads/data/".$id."-slide.jpg";
      }
	  
  }
  
?>