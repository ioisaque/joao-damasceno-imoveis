<?php
  /**
   * Controller
   *
   * @package Sistemas Folha do Comércio
   * @author Geandro Bessa
   * @copyright 2012
   */
  define("_VALID_PHP", true);
  
  require_once("init.php");
?>
<?php
  /* == Proccess Configuration == */
  if (isset($_POST['processConfig'])):
      $core->processConfig();
  endif;
?>
<?php
  /* == Proccess Email == */
  if (isset($_POST['processEmail']))
      : if (intval($_POST['processEmail']) == 0 || empty($_POST['processEmail']))
      : die();
  endif;
  $content->processEmail();
  endif;
  
  /* == Processar Usuario == */
  if (isset($_POST['processarUsuario'])):
      if (intval($_POST['processarUsuario']) == 0 || empty($_POST['processarUsuario'])):
          die();
      endif;
      Filter::$id = (isset($_POST['id'])) ? $_POST['id'] : 0;
      $user->processarUsuario();
  endif;

  /* == Delete Usuario== */
  if (isset($_POST['apagarUsuario'])):
      if (intval($_POST['apagarUsuario']) == 0 || empty($_POST['apagarUsuario'])):
          die();
      endif;

      $id = intval($_POST['apagarUsuario']);
      if ($id == 1):
          Filter::msgError(lang('DELUSER_ERR1'));
      else:
          $db->delete("usuario", "id='" . $id . "'");
          $usuario = sanitize($_POST['title']);

          print ($db->affected()) ? Filter::msgOk(str_replace("[NOME]", $usuario, lang('USUARIO_APAGAR_OK'))) : Filter::msgAlert(lang('NAOPROCESSADO'));
      endif;
  endif;
?>
<?php  
  /* == Processar Fornecedores == */
  if (isset($_POST['processarFornecedores'])):
      if (intval($_POST['processarFornecedores']) == 0 || empty($_POST['processarFornecedores'])):
          die();
      endif;
      Filter::$id = (isset($_POST['id'])) ? $_POST['id'] : 0;
      $fornecedores->processarFornecedores();
  endif;

  /* == Apagar Fornecedores == */
  if (isset($_POST['apagarFornecedores'])):
      if (intval($_POST['apagarFornecedores']) == 0 || empty($_POST['apagarFornecedores'])):
          die();
      endif;

      $id = intval($_POST['apagarFornecedores']);
      $data = array(
			'inativo' => "1"
	  );
      $db->update("cad_fornecedores", $data, "id='" . $id . "'");
	  $titulo = sanitize($_POST['title']);

      print ($db->affected()) ? Filter::msgOk(str_replace("[NOME]", $titulo, lang('FORNECEDORES_APAGAR_OK'))) : Filter::msgAlert(lang('NAOPROCESSADO'));
  endif;
?>
<?php  
  /* == Processar Clientes == */
  if (isset($_POST['processarClientes'])):
      if (intval($_POST['processarClientes']) == 0 || empty($_POST['processarClientes'])):
          die();
      endif;
      Filter::$id = (isset($_POST['id'])) ? $_POST['id'] : 0;
      $clientes->processarClientes();
  endif;

  /* == Apagar Clientes == */
  if (isset($_POST['apagarClientes'])):
      if (intval($_POST['apagarClientes']) == 0 || empty($_POST['apagarClientes'])):
          die();
      endif;

      $id = intval($_POST['apagarClientes']);
      $data = array(
			'inativo' => "1"
	  );
      $db->update("cad_clientes", $data, "id='" . $id . "'");
	  $titulo = sanitize($_POST['title']);

      print ($db->affected()) ? Filter::msgOk(str_replace("[NOME]", $titulo, lang('CLIENTES_APAGAR_OK'))) : Filter::msgAlert(lang('NAOPROCESSADO'));
  endif;
?>
<?php  
  /* == Processar Despesas == */
  if (isset($_POST['processarDespesa'])):
      if (intval($_POST['processarDespesa']) == 0 || empty($_POST['processarDespesa'])):
          die();
      endif;
      Filter::$id = (isset($_POST['id'])) ? $_POST['id'] : 0;
      $financeiro->processarDespesa();
  endif;
  
  /* == Processar Filtro Despesas == */
  if (isset($_POST['processarFiltroDespesasProg'])):
      if (intval($_POST['processarFiltroDespesasProg']) == 0 || empty($_POST['processarFiltroDespesasProg'])):
          die();
      endif;
      redirecionar("index.php?do=financeiro&acao=despesasprogramadas&data_ini=".$_POST['data_ini']."&data_fim=".$_POST['data_fim']);
  endif;
  
  /* == Pagar Despesas == */
  if (isset($_POST['pagamentoDespesa'])):
      if (intval($_POST['pagamentoDespesa']) == 0 || empty($_POST['pagamentoDespesa'])):
          die();
      endif;

      $id = intval($_POST['pagamentoDespesa']);
      $data = array(
			'pago' => "1",
			'usuario' => $_SESSION['usuario'],
			'data_pagamento' => "NOW()",
			'data' => "NOW()"
	  );
      $db->update("mv_financeiro", $data, "id='" . $id . "'");

      print ($db->affected()) ? Filter::msgOk(lang('DESPESAS_PAG_OK')) : Filter::msgAlert(lang('NAOPROCESSADO'));
	  redirecionar("index.php?do=financeiro&acao=despesasprogramadas");
  endif;

  /* == Apagar Despesas == */
  if (isset($_POST['apagarDespesa'])):
      if (intval($_POST['apagarDespesa']) == 0 || empty($_POST['apagarDespesa'])):
          die();
      endif;

      $id = intval($_POST['apagarDespesa']);
      $data = array(
			'excluir' => "1"
	  );
      $db->update("mv_financeiro", $data, "id='" . $id . "'");
	  $titulo = sanitize($_POST['title']);

      print ($db->affected()) ? Filter::msgOk(str_replace("[DESCRICAO]", $titulo, lang('DESPESAS_APAGAR_OK'))) : Filter::msgAlert(lang('NAOPROCESSADO'));
  endif;
?>
<?php  
  /* == Processar Conta == */
  if (isset($_POST['processarConta'])):
      if (intval($_POST['processarConta']) == 0 || empty($_POST['processarConta'])):
          die();
      endif;
      Filter::$id = (isset($_POST['id'])) ? $_POST['id'] : 0;
      $financeiro->processarConta();
  endif;

  /* == Apagar Conta == */
  if (isset($_POST['apagarConta'])):
      if (intval($_POST['apagarConta']) == 0 || empty($_POST['apagarConta'])):
          die();
      endif;

      $id = intval($_POST['apagarConta']);
      $data = array(
			'excluir' => "1"
	  );
      $db->update("cad_conta", $data, "id='" . $id . "'");
	  $titulo = sanitize($_POST['title']);

      print ($db->affected()) ? Filter::msgOk(str_replace("[DESCRICAO]", $titulo, lang('CONTA_APAGAR_OK'))) : Filter::msgAlert(lang('NAOPROCESSADO'));
  endif;
?>
<?php  
  /* == Processar Imoveis == */
  if (isset($_POST['processarImoveis'])):
      if (intval($_POST['processarImoveis']) == 0 || empty($_POST['processarImoveis'])):
          die();
      endif;
      Filter::$id = (isset($_POST['id'])) ? $_POST['id'] : 0;
      $imoveis->processarImoveis();
  endif;

  /* == Apagar Imoveis == */
  if (isset($_POST['apagarImoveis'])):
      if (intval($_POST['apagarImoveis']) == 0 || empty($_POST['apagarImoveis'])):
          die();
      endif;

      $id = intval($_POST['apagarImoveis']);
      $data = array(
			'id_status' => "0"
	  );
      $db->update("cad_imoveis", $data, "id='" . $id . "'");
	  $titulo = sanitize($_POST['title']);

      print ($db->affected()) ? Filter::msgOk(str_replace("[TITULO]", $titulo, lang('IMOVEIS_APAGAR_OK'))) : Filter::msgAlert(lang('NAOPROCESSADO'));
	  redirecionar("index.php?do=imoveis");
  endif;
  
  /* == Processar Imagem == */
  if (isset($_POST['processarImagens'])):
      if (intval($_POST['processarImagens']) == 0 || empty($_POST['processarImagens'])):
          die();
      endif;
	  Filter::$id = $_POST['processarImagens'];
	  foreach($_POST as $nome_campo => $valor){
		$valida = strpos($nome_campo, "tmpname");
		if($valida) {
			$data = array(
				'id_imoveis' => Filter::$id, 
				'nome' => $valor,
				'usuario' => $user->usuario,
				'data' => "NOW()"
			);
			$db->insert("imv_imagens", $data);
		}
	  }	 
      print ($db->affected()) ? Filter::msgOk(lang('IMOVEIS_IMAGENS_OK')) : Filter::msgAlert(lang('NAOPROCESSADO'));	  
	  redirecionar("index.php?do=imoveis&acao=imagem&id=".Filter::$id);
  endif;
  
  /* == Apagar Imagem == */
  if (isset($_POST['apagarImagem'])):
      if (intval($_POST['apagarImagem']) == 0 || empty($_POST['apagarImagem'])):
          die();
      endif;

      $id = intval($_POST['apagarImagem']);
	  $id_imoveis = getValue("id_imoveis","imv_imagens","id = '".$id."'");
	  $nome = sanitize($_POST['title']);
	  if ($nome and is_file(UPLOADS . 'data/' . $nome)) {
		unlink(UPLOADS . 'data/' . $nome);
      }
      $db->delete("imv_imagens", "id='" . $id . "'");

      print ($db->affected()) ? Filter::msgOk(str_replace("[IMAGEM]", $nome, lang('IMOVEIS_IMAGEM_APAGAR_OK'))) : Filter::msgAlert(lang('NAOPROCESSADO'));
	  redirecionar("index.php?do=imoveis&acao=imagem&id=".$id_imoveis);
  endif;
?>
<?php
  /* == Make Pdf == */
  if (isset($_GET['dopdf'])):
      if (intval($_GET['dopdf']) == 0 || empty($_GET['dopdf'])):
          redirect_to("index.php");
      endif;
	  
	  Filter::$id = intval($_GET['dopdf']);
	  $title = cleanOut(preg_replace("/[^a-zA-Z0-9\s]/", "", $_GET['title']));
	  ob_start();
	  require_once(BASEPATH . 'pdf_projeto.php');
	  $pdf_html = ob_get_contents();
	  ob_end_clean();

	  require_once(BASEPATH . 'lib/dompdf/dompdf_config.inc.php');
	  $dompdf = new DOMPDF();
	  $dompdf->load_html($pdf_html);
	  $dompdf->render();
	  $dompdf->stream($title . ".pdf");
  endif;
?>