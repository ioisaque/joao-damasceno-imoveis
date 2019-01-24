<?php
  /**
   * Classe Core
   *
   * @package Sistemas Folha do Comércio
   * @author Geandro Bessa
   * @copyright 2012
   */
  
  if (!defined("_VALID_PHP"))
      die('Acesso direto a esta classe não é permitido.');

  class Core
  {

      const sTable = "configuracoes";
      public $ano = null;
      public $mes = null;
      public $dia = null;
	  public $empresa = null;
	  public $telefone = null;
	  public $site_url = null;
	  public $site_email = null;
	  public $site_sistema = null;
	  public $logo = null;
	  public $file_types = null;
	  public $file_max = null;
	  public $mailer = null;
	  public $smtp_host = null;
	  public $smtp_user = null;
	  public $smtp_pass = null;
	  public $smtp_port = null;
	  public $language;


      /**
       * Core::__construct()
       * 
       * @return
       */
      function __construct()
      {
          $this->getSettings();
		  $this->getLanguage();

          $this->ano = (get('ano')) ? get('ano') : strftime('%Y');
          $this->mes = (get('mes')) ? get('mes') : strftime('%m');
          $this->dia = (get('dia')) ? get('dia') : strftime('%d');

          return mktime(0, 0, 0, $this->mes, $this->dia, $this->ano);
      }


      /**
       * Core::getSettings()
       * 
       * @return
       */
      private function getSettings()
      {
          $sql = "SELECT * FROM " . self::sTable;
          $row = Registry::get("Database")->first($sql);

		  if($row)
		  {
			  $this->empresa = $row->empresa;
			  $this->telefone = $row->telefone;
			  $this->site_url = $row->site_url;
			  $this->site_sistema = $row->site_sistema;
			  $this->site_email = $row->site_email;
			  $this->logo = $row->logo;
			  $this->file_types = $row->file_types;
			  $this->file_max = $row->file_max;
			  $this->mailer = $row->mailer;
			  $this->smtp_host = $row->smtp_host;
			  $this->smtp_user = $row->smtp_user;
			  $this->smtp_pass = $row->smtp_pass;
			  $this->smtp_port = $row->smtp_port;
		  }
      }

      /**
       * Core::processConfig()
       * 
       * @return
       */
      public function processConfig()
      {
          if (empty($_POST['empresa']))
              Filter::$msgs['empresa'] = lang('CONF_COMPANY_R');

          if (empty($_POST['site_url']))
              Filter::$msgs['site_url'] = lang('CONF_URL_R');

          if (empty($_POST['site_email']))
              Filter::$msgs['site_email'] = lang('CONF_EMAIL_R');

          if (isset($_POST['mailer']) && $_POST['mailer'] == "SMTP") {
              if (empty($_POST['smtp_host']))
                  Filter::$msgs['smtp_host'] = lang('CONF_SMTP_HOST_R');
              if (empty($_POST['smtp_user']))
                  Filter::$msgs['smtp_user'] = lang('CONF_SMTP_USER_R');
              if (empty($_POST['smtp_pass']))
                  Filter::$msgs['smtp_pass'] = lang('CONF_SMTP_PASS_R');
              if (empty($_POST['smtp_port']))
                  Filter::$msgs['smtp_port'] = lang('CONF_SMTP_PORT_R');
          }

          if (!empty($_FILES['logo']['name'])) {
              $file_info = getimagesize($_FILES['logo']['tmp_name']);
              if (empty($file_info))
                  Filter::$msgs['logo'] = lang('CONF_LOGO_R');
          }

          if (empty(Filter::$msgs)) {
              $data = array(
					  'empresa' => sanitize($_POST['empresa']),
					  'site_url' => sanitize($_POST['site_url']),
					  'file_types' => trim($_POST['file_types']),
					  'file_max' => intval($_POST['file_max']*1048576),		  
					  'mailer' => sanitize($_POST['mailer']),
					  'smtp_host' => sanitize($_POST['smtp_host']),
					  'smtp_user' => sanitize($_POST['smtp_user']),
					  'smtp_pass' => sanitize($_POST['smtp_pass']),
					  'smtp_port' => intval($_POST['smtp_port'])
				  );
			  
              Registry::get("Database")->update(self::sTable, $data);
              (Registry::get("Database")->affected()) ? Filter::msgOk(lang('CONF_UPDATED')) : Filter::msgAlert(lang('NOPROCCESS'));
          } else
              print Filter::msgStatus();
      }

	  /**
	   * Core:::getLanguage()
	   * 
	   * @return
	   */
	  private function getLanguage()
	  {
		  $this->langdir = BASEPATH . "lang/";		  
		  include($this->langdir . "pt-br.lang.php");
	  }
	  
	  /**
       * Core::moeda()
       * 
       * @param mixed $amount
       * @return
       */
      function moeda($amount)
      {
          return "R$ " . number_format($amount, 2, ',', '.');
      }

      /**
       * Core::getRowById()
       * 
       * @param mixed $table
       * @param mixed $id
       * @param bool $and
       * @param bool $is_admin
       * @return
       */
      public static function getRowById($table, $id, $and = false, $is_admin = true)
      {
          $id = sanitize($id, 8, true);
          if ($and) {
              $sql = "SELECT * FROM " . (string )$table . " WHERE id = '" . Registry::get("Database")->escape((int)$id) . "' AND " . Registry::get("Database")->escape($and) . "";
          } else
              $sql = "SELECT * FROM " . (string )$table . " WHERE id = '" . Registry::get("Database")->escape((int)$id) . "'";

          $row = Registry::get("Database")->first($sql);

          if ($row) {
              return $row;
          } else {
              if ($is_admin)
                  Filter::error("You have selected an Invalid Id - #" . $id, "Core::getRowById()");
          }
      }
	  	  
      /**
       * Core::doForm()
       * 
       * @param mixed $data
       * @param string $url
       * @param integer $reset
       * @param integer $clear
       * @param string $form_id
       * @param string $msgholder
       * @return
       */
      public static function doForm($data, $url = "controller.php", $reset = 0, $clear = 0, $form_id = "admin_form", $msgholder = "msgholder")
      {
          $display = '
		  <script type="text/javascript">
		  // <![CDATA[
			  $(document).ready(function () {
				  var options = {
					  target: "#' . $msgholder . '",
					  beforeSubmit:  showLoader,
					  success: showResponse,
					  url: "' . $url . '",
					  resetForm : ' . $reset . ',
					  clearForm : ' . $clear . ',
					  data: {
						  ' . $data . ': 1
					  }
				  };
				  $("#' . $form_id . '").ajaxForm(options);
			  });
			  
			  function showLoader() {
				  $("#loader").fadeIn(200);
			  }
		  
			  function hideLoader() {
				  $("#loader").fadeOut(200);
			  };	
			  		  
			  function showResponse(msg) {
				  hideLoader();
				  $(this).html(msg);
				  $("html, body").animate({
					  scrollTop: 0
				  }, 600);
			  }
			  ';
          $display .= '
		  // ]]>
		  </script>';

          print $display;
      }


      /**
       * Core::doDelete()
       * 
       * @param mixed $title
       * @param mixed $varpost
       * @param string $attr
       * @param string $id
       * @param string $dialog
       * @param string $url
       * @return
       */
      public static function doDelete($title, $varpost, $attr = 'item_', $id = 'a.delete', $dialog = 'dialog-confirm', $url = "controller.php")
      {
          $display = "
		  <div id=\"" . $dialog . "\" style=\"display:none;background-color: #f01414;\" title=\"" . $title . "\">
			<p>" . lang('CONFIRMAR_APAGAR') ."</p>
		  </div>
		  <script type=\"text/javascript\"> 
		  // <![CDATA[
		  $(document).ready(function () {
			  $('" . $id . "').live('click', function () {
				  var id = $(this).attr('id').replace('" . $attr . "', '')
				  var parent = $(this).parent().parent();
				  var title = $(this).attr('rel');
				  $(\"#" . $dialog . "\").data({
					  'delid': id,
					  'parent': parent,
					  'title': title
				  }).dialog('open');
				  return false;
			  });
		  
			  $(\"#" . $dialog . "\").dialog({
				  resizable: false,
				  bgiframe: true,
				  autoOpen: false,
				  width: 400,
				  height: 'auto',
				  zindex: 9998,
				  modal: true,
				  show: 'fadeIn',
				  buttons: {
					  '" . lang('APAGAR') . "': function () {
						  var parent = $(this).data('parent');
						  var id = $(this).data('delid');
						  var title = $(this).data('title');
						  $.ajax({
							  type: 'post',
							  url: '" . $url . "',
							  data: '" . $varpost . "=' + id + '&title=' + encodeURIComponent(title),
							  success: function (msg) {
								  parent.fadeOut(400, function () {
									  parent.remove();
								  });
								  $('html, body').animate({scrollTop:0}, 600);
								  $(\"#msgholder\").html(msg);
							  }
						  });
		  
						  $(this).dialog('close');
					  },
					  '" . lang('VOLTAR') . "': function () {
						  $(this).dialog('close');
					  }
				  }
			  });
		  });
		  // ]]>
		  </script>";

          print $display;
      }

  }
?>