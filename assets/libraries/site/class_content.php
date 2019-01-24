<?php
  /**
   * Class Content
   *
   * @package Sistemas Folha do Comércio
   * @author Geandro Bessa
   * @copyright 2012
   */
  
  if (!defined("_VALID_PHP"))
      die('Acesso direto a esta classe não é permitido.');

  class Content
  {
      private static $db;


      /**
       * Content::__construct()
       * 
       * @return
       */
      public function __construct()
      {
          self::$db = Registry::get("Database");
      }


      /**
       * Content::getGateways()
       * 
       * @param bool $active
       * @return
       */
      public function getGateways($active = false)
      {
          $where = ($active) ? "WHERE active = '1'" : null;
          $sql = "SELECT * FROM gateways" 
		  . "\n " . $where . "\n ORDER BY name";
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;

      }

      /**
       * Content::processGateway()
       * 
       * @return
       */
      public function processGateway()
      {
          if (empty($_POST['displayname']))
              Filter::$msgs['displayname'] = lang('GATE_NAME_R');

          if (empty(Filter::$msgs)) {
              $data = array(
					'displayname' => sanitize($_POST['displayname']), 
					'extra' => sanitize($_POST['extra']), 
					'extra2' => sanitize($_POST['extra2']), 
					'extra3' => sanitize($_POST['extra3']), 
					'live' => intval($_POST['live']), 
					'active' => intval($_POST['active'])
			  );

              self::$db->update("gateways", $data, "id='" . Filter::$id . "'");
              (self::$db->affected()) ? Filter::msgOk(lang('GATE_UPDATED')) : Filter::msgAlert(lang('NOPROCCESS'));
          } else
              print Filter::msgStatus();
      }

      /**
       * Content::getNews()
       * 
       * @return
       */
      public function getNews()
      {
          $sql = "SELECT *, DATE_FORMAT(created, '" . Registry::get("Core")->long_date . "') as start" 
		  . "\n FROM news" 
		  . "\n ORDER BY created ASC";

          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Content::processNews()
       * 
       * @return
       */
      public function processNews()
      {
          if (empty($_POST['title']))
              Filter::$msgs['title'] = lang('NEWS_NAME_R');

          if (empty($_POST['body']))
              Filter::$msgs['body'] = lang('NEWS_BODY_R');

          if (empty(Filter::$msgs)) {
              $data = array(
					'title' => sanitize($_POST['title']), 
					'body' => sanitize($_POST['body']), 
					'created' => sanitize($_POST['created']), 
					'active' => intval($_POST['active'])
			  );

              (Filter::$id) ? self::$db->update("news", $data, "id='" . Filter::$id . "'") : self::$db->insert("news", $data);
              $message = (Filter::$id) ? lang('NEWS_UPDATED') : lang('NEWS_ADDED');

              (self::$db->affected()) ? Filter::msgOk($message) : Filter::msgAlert(lang('NOPROCCESS'));
          } else
              print Filter::msgStatus();
      }

      /**
       * Content::processEmail()
       * 
       * @return
       */
      public function processEmail()
      {
          if (empty($_POST['subject']))
              Filter::$msgs['subject'] = lang('MAIL_REC_SUJECT_R');

          if (empty($_POST['body']))
              Filter::$msgs['body'] = lang('MAIL_BODY_R');

          if ($_POST['recipient'] == 'multiple') {
			  if (empty($_POST['multilist']) or !is_array($_POST['multilist'])) 
                  Filter::$msgs['multilist'] = lang('MAIL_REC_R');
		  }
			  
          if (empty(Filter::$msgs)) {
              $to = sanitize($_POST['recipient']);
              $subject = sanitize($_POST['subject']);
              $body = cleanOut($_POST['body']);
			  $numSent = '';
			  
			  if(file_exists(UPLOADS.'print_logo.png')) {
				  $logo = '<img src="'.UPLOADURL . 'print_logo.png" alt="'. Registry::get("Core")->empresa.'" />';
			  } elseif(Registry::get("Core")->logo) {
				  $logo = '<img src="'.UPLOADURL . Registry::get("Core")->logo . '" alt="'. Registry::get("Core")->empresa.'" />';
			  } else {
				$logo = Registry::get("Core")->empresa;
			  }

              switch ($to) {
                  case "all":
                      require_once (BASEPATH . "lib/class_mailer.php");
                      $mailer = $mail->sendMail();
                      $mailer->registerPlugin(new Swift_Plugins_AntiFloodPlugin(100));

                      $sql = "SELECT email, CONCAT(nome,' ',lname) as name FROM users WHERE id != 1";
                      $userrow = self::$db->fetch_all($sql);

                      $replacements = array();
                      if ($userrow) {
                          foreach ($userrow as $cols) {
                              $replacements[$cols->email] = array(
									'[COMPANY]' => Registry::get("Core")->empresa, 
									'[LOGO]' => $logo, 
									'[NAME]' => $cols->name, 
									'[URL]' => Registry::get("Core")->site_url, 
									'[YEAR]' => date('Y')
							  );
                          }

                          $decorator = new Swift_Plugins_DecoratorPlugin($replacements);
                          $mailer->registerPlugin($decorator);

                          $message = Swift_Message::newInstance()
								  ->setSubject($subject)
								  ->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->empresa))
								  ->setBody($body, 'text/html');

                          foreach ($userrow as $row)
                              $message->addTo($row->email, $row->name);
                          unset($row);

                          $numSent = $mailer->batchSend($message);
                      }
                      break;

                  case "clients":
                      require_once (BASEPATH . "lib/class_mailer.php");
                      $mailer = $mail->sendMail();
                      $mailer->registerPlugin(new Swift_Plugins_AntiFloodPlugin(100));

                      $sql = "SELECT email, CONCAT(nome,' ',lname) as name FROM users WHERE nivel = 1";
                      $userrow = self::$db->fetch_all($sql);

                      $replacements = array();
                      if ($userrow) {
                          foreach ($userrow as $cols) {
                              $replacements[$cols->email] = array(
									'[COMPANY]' => Registry::get("Core")->empresa, 
									'[LOGO]' => $logo, 
									'[NAME]' => $cols->name, 
									'[URL]' => Registry::get("Core")->site_url, 
									'[YEAR]' => date('Y')
							  );
                          }

                          $decorator = new Swift_Plugins_DecoratorPlugin($replacements);
                          $mailer->registerPlugin($decorator);

                          $message = Swift_Message::newInstance()
								  ->setSubject($subject)
								  ->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->empresa))
								  ->setBody($body, 'text/html');

                          foreach ($userrow as $row)
                              $message->addTo($row->email, $row->name);
                          unset($row);

                          $numSent = $mailer->batchSend($message);
                      }
                      break;

                  case "staff":
                      require_once (BASEPATH . "lib/class_mailer.php");
                      $mailer = $mail->sendMail();
                      $mailer->registerPlugin(new Swift_Plugins_AntiFloodPlugin(100));

                      $sql = "SELECT email, CONCAT(nome,' ',lname) as name FROM users WHERE nivel = 5";
                      $userrow = self::$db->fetch_all($sql);

                      $replacements = array();
                      if ($userrow) {
                          foreach ($userrow as $cols) {
                              $replacements[$cols->email] = array(
									'[COMPANY]' => Registry::get("Core")->empresa, 
									'[LOGO]' => $logo, 
									'[NAME]' => $cols->name, 
									'[URL]' => Registry::get("Core")->site_url, 
									'[YEAR]' => date('Y')
							  );
                          }

                          $decorator = new Swift_Plugins_DecoratorPlugin($replacements);
                          $mailer->registerPlugin($decorator);

                          $message = Swift_Message::newInstance()
								  ->setSubject($subject)
								  ->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->empresa))
								  ->setBody($body, 'text/html');

                          foreach ($userrow as $row)
                              $message->addTo($row->email, $row->name);
                          unset($row);

                          $numSent = $mailer->batchSend($message);
                      }
                      break;

                  case "multiple":
                      require_once (BASEPATH . "lib/class_mailer.php");
                      $mailer = $mail->sendMail();
                      $mailer->registerPlugin(new Swift_Plugins_AntiFloodPlugin(100));
					  $matches = sanitize($_POST['multilist']);
					  $matches = implode(',', $_POST['multilist']);

                      $sql = "SELECT email, CONCAT(nome,' ',lname) as name FROM users WHERE id IN(" . $matches . ")";
                      $userrow = self::$db->fetch_all($sql);

                      $replacements = array();
                      if ($userrow) {
                          foreach ($userrow as $cols) {
                              $replacements[$cols->email] = array(
									'[COMPANY]' => Registry::get("Core")->empresa, 
									'[LOGO]' => $logo, 
									'[NAME]' => $cols->name, 
									'[URL]' => Registry::get("Core")->site_url, 
									'[YEAR]' => date('Y')
							  );
                          }

                          $decorator = new Swift_Plugins_DecoratorPlugin($replacements);
                          $mailer->registerPlugin($decorator);

                          $message = Swift_Message::newInstance()
								  ->setSubject($subject)
								  ->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->empresa))
								  ->setBody($body, 'text/html');

                          foreach ($userrow as $row)
                              $message->addTo($row->email, $row->name);
                          unset($row);

                          $numSent = $mailer->batchSend($message);
                      }
                      break;
					  
                  default:
                      require_once (BASEPATH . "lib/class_mailer.php");
                      $mailer = $mail->sendMail();
                      $row = self::$db->first("SELECT email, CONCAT(nome,' ',lname) as name FROM users WHERE email LIKE '%" . sanitize($to) . "%'");
                      if ($row) {
                          $newbody = str_replace(
						  array('[COMPANY]', '[LOGO]', '[NAME]', '[URL]', '[YEAR]'), 
						  array(Registry::get("Core")->empresa, $logo, $row->name, Registry::get("Core")->site_url, date('Y')), $body);

                          $message = Swift_Message::newInstance()
								  ->setSubject($subject)
								  ->setTo(array($to => $row->name))
								  ->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->empresa))
								  ->setBody($newbody, 'text/html');

                          $numSent = $mailer->send($message);
                      }
                      break;
              }

              ($numSent) ? Filter::msgOk(lang('MAIL_SENT')) : Filter::msgAlert(lang('MAIL_ALERT'));

          } else
              print Filter::msgStatus();
      }

      /**
       * Content::getProjects()
       * 
       * @return
       */
      public function getProjects()
      {
          $sort = sanitize(get('sort'));
          $access = '';
          $order = '';
          if (Registry::get("Users")->nivel == 5) {
              $extra = ($sort) ? "AND" : "WHERE";
              $access = "$extra pp.staff_id='" . Registry::get("Users")->uid . "'";
              $counter = countEntries("permissions", "staff_id", Registry::get("Users")->uid);
          } else {
              $counter = countEntries("projects");
          }

          $pager = Paginator::instance();
          $pager->items_total = $counter;
          $pager->default_ipp = Registry::get("Core")->perpage;
          $pager->paginate();

          ($sort) ? $order = "WHERE client_id = '" . (int)$sort . "'" : null;

          $sql = "SELECT p.id as pid, p.title, p.p_status, p.b_status, p.cost, p.start_date, u.id as uid," 
		  . "\n CONCAT(u.nome,' ',u.lname) as clientname," 
		  . "\n DATE_FORMAT(p.start_date, '" . Registry::get("Core")->short_date . "') as start," 
		  . "\n (SELECT CONCAT(nome,' ',lname) FROM users WHERE id = p.staff_id) as stafnome" 
		  . "\n FROM projects as p" 
		  . "\n LEFT JOIN users as u ON u.id = p.client_id" 
		  . "\n LEFT JOIN permissions as pp ON pp.project_id = p.id" 
		  . "\n $order $access" 
		  . "\n ORDER BY p.start_date DESC " . $pager->limit;
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Content::processProject()
       * 
       * @return
       */
      public function processProject()
      {
          if (empty($_POST['title']))
              Filter::$msgs['title'] = lang('PROJ_NAME_R');

          if (empty($_POST['project_type']))
              Filter::$msgs['project_type'] = lang('PROJ_TYPE_R');

          if (empty($_POST['client_id']))
              Filter::$msgs['client_id'] = lang('INVC_CLIENTSELECT_R');

		  if (empty($_POST['cost']) or $_POST['cost'] == 0 or !is_numeric($_POST['cost']))
              Filter::$msgs['cost'] = lang('PROJ_PRICE_R');

          if (empty(Filter::$msgs)) {
              $progress = str_replace("%", "", $_POST['p_status']);

              $data = array(
					'title' => sanitize($_POST['title']), 
					'client_id' => intval($_POST['client_id']), 
					'staff_id' => intval($_POST['staff_id']), 
					'project_type' => intval($_POST['project_type']), 
					'body' => $_POST['body'], 
					'start_date' => sanitize($_POST['start_date']) . ' ' . date('H:i:s'), 
					'end_date' => sanitize($_POST['end_date']) . ' ' . date('H:i:s'), 
					'cost' => (float)$_POST['cost'], 
					'p_status' => intval($progress)
			  );

              $pdata['staff_id'] = $data['staff_id'];

              if (Filter::$id) {
                  $res = self::$db->update("projects", $data, "id='" . Filter::$id . "'");
                  self::$db->update("permissions", $pdata, "project_id='" . Filter::$id . "'");
              } else {
                  $res = self::$db->insert("projects", $data);
                  $lastid = self::$db->insertid();
                  $pdata['project_id'] = (int)$lastid;
                  self::$db->insert("permissions", $pdata);
              }

              $message = (Filter::$id) ? lang('PROJ_UPDATED') : lang('PROJ_ADDED');

              ($res) ? Filter::msgOk($message) : Filter::msgAlert(lang('NOPROCCESS'));
			  
              if (isset($_POST['notify_staff']) && $_POST['notify_staff'] == 1) {
				  $user = self::$db->first("SELECT email, CONCAT(nome,' ',lname) as stafnome FROM users WHERE id = " . $data['staff_id']);
                  require_once (BASEPATH . "lib/class_mailer.php");
                  $mailer = $mail->sendMail();
                  $row = $this->getAllInfo($lastid);
                  $subject = lang('PROJ_ESUBJECT') . $data['title'];

                  ob_start();
                  require_once (BASEPATH . 'mailer/Project_From_Admin.tpl.php');
                  $html_message = ob_get_contents();
                  ob_end_clean();

                  $msg = Swift_Message::newInstance()
						  ->setSubject($subject)
						  ->setTo(array($user->email => $user->stafnome))
						  ->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->empresa))
						  ->setBody($html_message, 'text/html');

                  $numSent = $mailer->send($msg);
              }
			  
          } else
              print Filter::msgStatus();
      }

      /**
       * Content::getProjectList()
       * 
       * @return
       */
      public function getProjectList()
      {
          $sql = "SELECT * FROM projects";
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Content::getProjectTypes()
       * 
       * @return
       */
      public function getProjectTypes()
      {
          $sql = "SELECT * FROM project_types";
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Content::processProjectType()
       * 
       * @return
       */
      public function processProjectType()
      {

          if (empty($_POST['title']))
              Filter::$msgs['title'] = lang('TYPE_NAME_R');

          if (empty(Filter::$msgs)) {
              $data = array('title' => sanitize($_POST['title']), 'description' => sanitize($_POST['description']));

              (Filter::$id) ? self::$db->update("project_types", $data, "id='" . Filter::$id . "'") : self::$db->insert("project_types", $data);
              $message = (Filter::$id) ? lang('TYPE_UPDATED') : lang('TYPE_ADDED');

              (self::$db->affected()) ? Filter::msgOk($message) : Filter::msgAlert(lang('NOPROCCESS'));
          } else
              print Filter::msgStatus();
      }

      /**
       * Content::getProjectFiles()
       * 
       * @return
       */
      public function getProjectFiles()
      {
          $sql = "SELECT f.*, p.title as ptitle, p.id as pid" 
		  . "\n FROM project_files as f" 
		  . "\n LEFT JOIN projects as p ON p.id = f.project_id" 
		  . "\n ORDER BY p.title";
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Content::getFilesByProject()
       * 
       * @param bool $project_id
       * @return
       */
      public function getFilesByProject($project_id = false)
      {
          $id = ($project_id) ? $project_id : Filter::$id;
          $sql = "SELECT * FROM project_files " 
		  . "\n WHERE project_id = " . $id 
		  . "\n ORDER BY title";
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Content::processProjectFile()
       * 
       * @return
       */
      public function processProjectFile()
      {

          if (empty($_POST['title']))
              Filter::$msgs['title'] = lang('FILE_NAME_R');

          if (empty($_POST['project_id']))
              Filter::$msgs['project_id'] = lang('FILE_SELPROJ_R');

          if (!Filter::$id and empty($_FILES['filename']['name']))
              Filter::$msgs['filename'] = lang('FILE_ATTACH_R');

          $upl = Uploader::instance(Registry::get("Core")->file_max, Registry::get("Core")->file_types);
          if (!empty($_FILES['filename']['name']) and empty(Filter::$msgs)) {
              $dir = UPLOADS . 'data/';
              $upl->upload('filename', $dir);
          }

          if (empty(Filter::$msgs)) {
              $data = array(
					'title' => sanitize($_POST['title']), 
					'filedesc' => $_POST['filedesc'], 
					'created' => "NOW()", 
					'project_id' => intval($_POST['project_id']), 
					'staff_id' => Registry::get("Users")->uid, 
					'version' => sanitize($_POST['version'])
			  );

              $file = getValue("filename", "project_files", "id = '" . Filter::$id . "'");
              if (!empty($_FILES['filename']['name'])) {
                  if ($file and is_file(UPLOADS . 'data/' . $file)) {
                      unlink(UPLOADS . 'data/' . $file);
                  }
                  $data['filename'] = $upl->fileInfo['nome'];
                  $data['filesize'] = $upl->fileInfo['size'];
              } else {
                  $data['filename'] = $file;
              }

              (Filter::$id) ? self::$db->update("project_files", $data, "id='" . Filter::$id . "'") : self::$db->insert("project_files", $data);
              $message = (Filter::$id) ? lang('FILE_UPDATED') : lang('FILE_ADDED');

              (self::$db->affected()) ? Filter::msgOk($message) : Filter::msgAlert(lang('NOPROCCESS'));
          } else
              print Filter::msgStatus();
      }

      /**
       * Content::getProjectTasks()
       * 
       * @return
       */
      public function getProjectTasks()
      {
          if (Registry::get("Users")->nivel == 5) {
			  if (isset($_GET['sort'])) {
				  if ($_GET['sort'] == 'completed') {
					  $q = "SELECT COUNT(*) FROM tasks WHERE progress = 100 AND staff_id = '" . Registry::get("Users")->uid . "' LIMIT 1";
					  $access = "WHERE t.staff_id='" . Registry::get("Users")->uid . "' AND progress = 100";
				  } elseif($_GET['sort'] == 'pending') {
					  $q = "SELECT COUNT(*) FROM tasks WHERE progress <> 100 AND staff_id = '" . Registry::get("Users")->uid . "' LIMIT 1";
					  $access = "WHERE t.staff_id='" . Registry::get("Users")->uid . "' AND progress <> 100";
				  }
			  } else {
				  $q = "SELECT COUNT(*) FROM tasks WHERE staff_id = '" . Registry::get("Users")->uid . "' LIMIT 1";
				  $access = "WHERE t.staff_id='" . Registry::get("Users")->uid . "'";
			  }

          } else {
			  if (isset($_GET['sort'])) {
				  if ($_GET['sort'] == 'completed') {
					  $q = "SELECT COUNT(*) FROM tasks WHERE progress = 100 LIMIT 1";
					  $access = "WHERE progress = 100";
				  } elseif($_GET['sort'] == 'pending') {
					  $q = "SELECT COUNT(*) FROM tasks WHERE progress <>100 LIMIT 1";
					  $access = "WHERE progress <> 100";
				  }
			  } else {
				  $q = "SELECT COUNT(*) FROM tasks LIMIT 1";
				  $access = null;
			  }
				  
          }

		  $record = Registry::get("Database")->query($q);
		  $total = Registry::get("Database")->fetchrow($record);
		  $counter = $total[0];
			  
          $pager = Paginator::instance();
          $pager->items_total = $counter;
          $pager->default_ipp = Registry::get("Core")->perpage;
          $pager->paginate();

          $sql = "SELECT t.*, p.title as ptitle, p.id as pid," 
		  . "\n DATE_FORMAT(t.created, '" . Registry::get("Core")->short_date . "') as start" 
		  . "\n FROM tasks as t" 
		  . "\n LEFT JOIN projects as p ON p.id = t.project_id" 
		  . "\n $access" 
		  . "\n ORDER BY p.title, t.created DESC" . $pager->limit;
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Content::getTasksByProject()
       * 
       * @return
       */
      public function getTasksByProject()
      {
          $access = (Registry::get("Users")->nivel == 5) ? "AND pp.staff_id='" . Registry::get("Users")->uid . "'" : null;

          $sql = "SELECT t.*," 
		  . "\n DATE_FORMAT(t.created, '" . Registry::get("Core")->short_date . "') as start" 
		  . "\n FROM tasks as t" 
		  . "\n LEFT JOIN permissions as pp ON pp.project_id = t.project_id" 
		  . "\n WHERE t.project_id = '" . Filter::$id . "'" 
		  . "\n $access" 
		  . "\n ORDER BY t.title";
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Content::processProjectTask()
       * 
       * @return
       */
      public function processProjectTask()
      {
          if (empty($_POST['title']))
              Filter::$msgs['title'] = lang('TASK_NAME_R');

          if (empty($_POST['project_id']))
              Filter::$msgs['project_id'] = lang('TASK_SELPROJ_R');

          if (empty(Filter::$msgs)) {
              $progress = str_replace("%", "", $_POST['progress']);
              $data = array(
					'project_id' => intval($_POST['project_id']), 
					'staff_id' => intval($_POST['staff_id']), 
					'client_access' => intval($_POST['client_access']), 
					'author_id' => Registry::get("Users")->uid, 
					'title' => sanitize($_POST['title']), 
					'details' => $_POST['details'], 
					'duedate' => sanitize($_POST['duedate']) . ' ' . date('H:i:s'), 
					'created' => sanitize($_POST['created']) . ' ' . date('H:i:s'), 
					'progress' => intval($progress)
			  );

              (Filter::$id) ? self::$db->update("tasks", $data, "id='" . Filter::$id . "'") : self::$db->insert("tasks", $data);
              $message = (Filter::$id) ? lang('TASK_UPDATED') : lang('TASK_ADDED');

              (self::$db->affected()) ? Filter::msgOk($message) : Filter::msgAlert(lang('NOPROCCESS'));
			  
              if (isset($_POST['notify_staff']) && $_POST['notify_staff'] == 1) {
				  $user = self::$db->first("SELECT email, CONCAT(nome,' ',lname) as stafnome FROM users WHERE id = " . $data['staff_id']);
                  require_once (BASEPATH . "lib/class_mailer.php");
                  $mailer = $mail->sendMail();
                  $row = $this->getAllInfo($data['project_id']);
                  $subject = lang('TASK_ESUBJECT') . $data['title'];

                  ob_start();
                  require_once (BASEPATH . 'mailer/Task_From_Admin.tpl.php');
                  $html_message = ob_get_contents();
                  ob_end_clean();

                  $msg = Swift_Message::newInstance()
						  ->setSubject($subject)
						  ->setTo(array($user->email => $user->stafnome))
						  ->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->empresa))
						  ->setBody($html_message, 'text/html');

                  $numSent = $mailer->send($msg);
              }
			  
          } else
              print Filter::msgStatus();
      }

      /**
       * Content::getTaskTemplates()
       * 
       * @return
       */
      public function getTaskTemplates()
      {

          $sql = "SELECT * FROM task_templates ORDER BY title";
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Content::processTaskTemplate()
       * 
       * @return
       */
      public function processTaskTemplate()
      {
          if (empty($_POST['title']))
              Filter::$msgs['title'] = lang('TTASK_NAME_R');

          if (empty(Filter::$msgs)) {
              $data = array(
					'title' => sanitize($_POST['title']), 
					'details' => $_POST['details']
			  );

              (Filter::$id) ? self::$db->update("task_templates", $data, "id='" . Filter::$id . "'") : self::$db->insert("task_templates", $data);
              $message = (Filter::$id) ? lang('TTASK_UPDATED') : lang('TTASK_ADDED');

              (self::$db->affected()) ? Filter::msgOk($message) : Filter::msgAlert(lang('NOPROCCESS'));
			  
          } else
              print Filter::msgStatus();
      }
	  
      /**
       * Content::getProjectSubmissions()
       * 
       * @param bool $all
       * @return
       */
      public function getProjectSubmissions($all = true)
      {
          $where = ($all) ? "project_id = '" . Filter::$id . "'" : "id = '" . Filter::$id . "'";

          $sql = "SELECT *, DATE_FORMAT(created, '" . Registry::get("Core")->long_date . "') as sdate," 
		  . "\n DATE_FORMAT(review_date, '" . Registry::get("Core")->long_date . "') as rdate" 
		  . "\n FROM submissions" 
		  . "\n WHERE $where" 
		  . "\n ORDER BY created";

          $row = ($all) ? self::$db->fetch_all($sql) : self::$db->first($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Content::processProjectSubmission()
       * 
       * @return
       */
      public function processProjectSubmission()
      {
          if (empty($_POST['title']))
              Filter::$msgs['title'] = lang('SUBS_NAME_R');

          if (empty($_POST['project_id']))
              Filter::$msgs['project_id'] = lang('INVC_PROJCSELETC_R');

          if (empty($_POST['description']))
              Filter::$msgs['description'] = lang('SUBS_NOTE_R');

          if (!empty($_FILES['filename']['name'])) {
              $upl = Uploader::instance(Registry::get("Core")->file_max, Registry::get("Core")->file_types);
              $dir = UPLOADS . 'data/';
              $upl->upload('filename', $dir);
          }

          if (empty(Filter::$msgs)) {
              $data = array(
					'project_id' => intval($_POST['project_id']), 
					'staff_id' => intval($_POST['staff_id']), 
					'title' => sanitize($_POST['title']), 
					'description' => $_POST['description'], 
					's_type' => sanitize($_POST['s_type']), 
					'status' => (isset($_POST['revsend']) && $_POST['revsend'] == 1) ? 1 : 0
			  );
              if (!Filter::$id) {
                  $data['created'] = "NOW()";
              }

              (Filter::$id) ? self::$db->update("submissions", $data, "id='" . Filter::$id . "'") : $lastid = self::$db->insert("submissions", $data);
              $message = (Filter::$id) ? lang('SUBS_UPDATED') : lang('SUBS_ADDED');

              if (!empty($_FILES['filename']['name'])) {
                  $fdata = array(
						'title' => (empty($_POST['filetitle'])) ? sanitize($_POST['title']) : sanitize($_POST['filetitle']), 
						'created' => "NOW()", 
						'project_id' => intval($_POST['project_id']), 
						'staff_id' => intval($_POST['staff_id']), 
						'filename' => $upl->fileInfo['nome'], 
						'filesize' => $upl->fileInfo['size']
				  );
                  self::$db->insert("project_files", $fdata);
              }

              if (isset($_POST['revsend']) && $_POST['revsend'] == 1) {
                  require_once (BASEPATH . "lib/class_mailer.php");
                  $mailer = $mail->sendMail();
                  $row = $this->getAllInfo($data['project_id']);
                  $subject = lang('SUBS_SUBJECT') . $data['title'];

                  ob_start();
                  require_once (BASEPATH . 'mailer/Submission_From_Admin.tpl.php');
                  $html_message = ob_get_contents();
                  ob_end_clean();

                  $msg = Swift_Message::newInstance()
						  ->setSubject($subject)
						  ->setTo(array($row->email => $row->clientname))
						  ->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->empresa))
						  ->setBody($html_message, 'text/html');

                  $numSent = $mailer->send($msg);
              }


              (self::$db->affected()) ? Filter::msgOk($message) : Filter::msgAlert(lang('NOPROCCESS'));
          } else
              print Filter::msgStatus();
      }

      /**
       * Content::getProjectInvoices()
       * 
       * @return
       */
      public function getProjectInvoices()
      {
          $where = (Filter::$id) ? "WHERE project_id = '" . Filter::$id . "'" : null;

          $sql = "SELECT i.*," 
		  . "\n DATE_FORMAT(i.created, '" . Registry::get("Core")->short_date . "') as cdate," 
		  . "\n DATE_FORMAT(i.duedate, '" . Registry::get("Core")->short_date . "') as ddate," 
		  . "\n p.title as ptitle, CONCAT(u.nome,' ',u.lname) as name" 
		  . "\n FROM invoices as i" 
		  . "\n LEFT JOIN projects as p ON p.id = i.project_id" 
		  . "\n LEFT JOIN users as u ON u.id = i.client_id" 
		  . "\n $where" 
		  . "\n ORDER BY i.created";

          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Content::getProjectInvoiceById()
       * 
       * @return
       */
      public function getProjectInvoiceById()
      {
          $sql = "SELECT i.*," 
		  . "\n DATE_FORMAT(i.created, '" . Registry::get("Core")->short_date . "') as cdate," 
		  . "\n DATE_FORMAT(i.duedate, '" . Registry::get("Core")->short_date . "') as ddate," 
		  . "\n p.title as ptitle, CONCAT(u.nome,' ',u.lname) as name, u.email, u.address, u.city, u.zip, u.state, u.telefone, u.empresa" 
		  . "\n FROM invoices as i" 
		  . "\n LEFT JOIN projects as p ON p.id = i.project_id" 
		  . "\n LEFT JOIN users as u ON u.id = i.client_id" 
		  . "\n WHERE i.id = '" . Filter::$id . "'";

          $row = self::$db->first($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Content::getProjectInvoiceData()
       * 
       * @param bool $invid
       * @return
       */
      public function getProjectInvoiceData($invid = false)
      {
          $id = ($invid) ? intval($invid) : Filter::$id;

          $sql = "SELECT * FROM invoice_data WHERE invoice_id = '" . (int)$id . "'";

          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Content::getProjectInvoicePayments()
       * 
       * @param bool $invid
       * @return
       */
      public function getProjectInvoicePayments($invid = false)
      {
          $id = ($invid) ? intval($invid) : Filter::$id;

          $sql = "SELECT *," 
		  . "\n DATE_FORMAT(created, '" . Registry::get("Core")->short_date . "') as cdate" 
		  . "\n FROM invoice_payments" 
		  . "\n WHERE invoice_id = '" . (int)$id . "'";

          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Content::updateInvoice()
       * 
       * @return
       */
      public function updateInvoice()
      {
          if (empty($_POST['title']))
              Filter::$msgs['title'] = 'Please Enter Invoice Title';

          if (empty(Filter::$msgs)) {
              $data = array(
					'title' => sanitize($_POST['title']), 
					'duedate' => sanitize($_POST['duedate']), 
					'method' => sanitize($_POST['method']), 
					'status' => sanitize($_POST['status'])
			  );
			  
			  if($_POST['status'] == 'Paid') {
				  $data['amount_paid'] = floatval($_POST['amount_total']);
				  $row = self::$db->first("SELECT SUM(amount_total-tax) as total, project_id FROM invoices WHERE id = '" . Filter::$id . "' GROUP BY id");
				  
				  $edata = array(
						'invoice_id' => Filter::$id, 
						'project_id' => intval($row->project_id), 
						'method' => $data['method'], 
						'amount' => floatval($row->total),
						'created' => "NOW()",
						'description' => "Payment added by admin"
				  );
				  $pdata['b_status'] = $data['amount_paid'];
				  self::$db->insert("invoice_payments", $edata);
				  self::$db->update("projects", $pdata, "id='" . $edata['project_id'] . "'");
				  
			  }
			  
              self::$db->update("invoices", $data, "id='" . Filter::$id . "'");
              (self::$db->affected()) ? Filter::msgOk(lang('INVC_UPDATED')) : Filter::msgAlert(lang('NOPROCCESS'));
			  

          } else
              print Filter::msgStatus();
      }

      /**
       * Content::addInvoice()
       * 
       * @return
       */
      public function addInvoice()
      {
          if (empty($_POST['title']))
              Filter::$msgs['title'] = lang('INVC_NAME_R');

          if (empty($_POST['project_id']))
              Filter::$msgs['project_id'] = lang('INVC_PROJCSELETC_R');

          if (empty($_POST['client_id']))
              Filter::$msgs['client_id'] = lang('INVC_CLIENTSELECT_R');

          if (empty($_POST['duedate']))
              Filter::$msgs['duedate'] = lang('INVC_DUEDATE_R');
          
		  $dtitle = array_filter($_POST['dtitle'], 'strlen');
          if (empty($dtitle))
              Filter::$msgs['dtitle'] = lang('INVC_ENTRYTITLE_R');
			  
          $amount = array_filter($_POST['amount'], 'is_numeric');
          if (!$amount or array_sum($_POST['amount']) == 0)
              Filter::$msgs['amount'] = lang('INVC_ENTRYAMOUNT_R');

          if (empty(Filter::$msgs)) {
			  
              $amount_total = array_sum($_POST['amount']);
              if (intval($_POST['tax']) == 1 and Registry::get("Core")->enable_tax) {
                  $tax = (floatval($amount_total) * Registry::get("Core")->tax_rate);
                  $amount_total = ($amount_total + $tax);
              } else {
                  $tax = 0;
              }
              $data = array(
					'title' => sanitize($_POST['title']), 
					'project_id' => intval($_POST['project_id']), 
					'client_id' => intval($_POST['client_id']), 
					'created' => (empty($_POST['created'])) ? "NOW()" : sanitize($_POST['created']), 
					'duedate' => sanitize($_POST['duedate']), 
					'amount_total' => $amount_total,
					'amount_paid' => 0, 
					'method' => sanitize($_POST['method']), 
					'tax' => $tax, 
					'status' => 'Unpaid'
			  );

              $lastid = self::$db->insert("invoices", $data);
              (self::$db->affected()) ? Filter::msgOk(lang('INVC_ADDED')) : Filter::msgAlert(lang('NOPROCCESS'));
			  
			  foreach ($_POST['amount'] as $key => $val) {
				  $edata = array(
						'title' => sanitize($_POST['dtitle'][$key]), 
						'invoice_id' => $lastid, 
						'description' => sanitize($_POST['description'][$key]), 
						'amount' => floatval($_POST['amount'][$key]), 
						'tax' => (intval($_POST['tax']) == 1 and Registry::get("Core")->enable_tax) ? (floatval($_POST['amount'][$key]) * Registry::get("Core")->tax_rate) : 0
				  );
				  self::$db->insert("invoice_data", $edata);
			  }
			  
			  $row = self::$db->first("SELECT SUM(amount) as amtotal, SUM(tax) as itax FROM invoice_data WHERE invoice_id = '" . $edata['invoice_id'] . "' GROUP BY invoice_id");
			  $idata = array('amount_total' => $row->amtotal + $row->itax, 'tax' => $row->itax);
			  $pdata['cost'] = $idata['amount_total'];
			  $pdata['b_status'] = -1.00;

			  self::$db->update("invoices", $idata, "id='" . $edata['invoice_id'] . "'");
			  self::$db->update("projects", $pdata, "id='" . $data['project_id'] . "'");

          } else
              print Filter::msgStatus();
      }

      /**
       * Content::sendInvoice()
       * 
       * @param mixed $id
       * @return
       */
      public function sendInvoice($id)
      {
          $row = self::$db->first("SELECT i.*," 
		  . "\n DATE_FORMAT(i.created, '" . Registry::get("Core")->short_date . "') as cdate," 
		  . "\n DATE_FORMAT(i.duedate, '" . Registry::get("Core")->short_date . "') as ddate," 
		  . "\n p.title as ptitle, CONCAT(u.nome,' ',u.lname) as name, u.email, u.address, u.city, u.empresa, u.zip, u.state, u.telefone" 
		  . "\n FROM invoices as i" 
		  . "\n LEFT JOIN projects as p ON p.id = i.project_id" 
		  . "\n LEFT JOIN users as u ON u.id = i.client_id" 
		  . "\n WHERE i.id = '" . (int)$id . "'");
		  
          if ($row) {
              $invdata = self::$db->fetch_all("SELECT i.*," 
			  . "\n DATE_FORMAT(i.created, '" . Registry::get("Core")->short_date . "') as cdate," 
			  . "\n DATE_FORMAT(i.duedate, '" . Registry::get("Core")->short_date . "') as ddate," 
			  . "\n id.title as idtitle, id.description, id.amount,id.tax" 
			  . "\n FROM invoices as i" 
			  . "\n LEFT JOIN invoice_data as id ON id.invoice_id = i.id" 
			  . "\n WHERE i.id = '" . (int)$id . "'");

              $paydata = self::$db->fetch_all("SELECT *," 
			  . "\n DATE_FORMAT(created, '" . Registry::get("Core")->short_date . "') as cdate" 
			  . "\n FROM invoice_payments" 
			  . "\n WHERE invoice_id = '" . (int)$id . "'");
              
			  Filter::$id = $id;
			  ob_start();
			  require_once(BASEPATH . 'admin/print_pdf.php');
			  $pdf_html = ob_get_contents();
			  ob_end_clean();

			  require_once(BASEPATH . 'lib/dompdf/dompdf_config.inc.php');
			  $dompdf = new DOMPDF();
			  $dompdf->load_html($pdf_html);
			  $dompdf->render();
			  $pdf_content = $dompdf->output();
	  
              require_once (BASEPATH . "lib/class_mailer.php");
              $mailer = $mail->sendMail();
              $subject = lang('INVC_SUBJECT') . $row->ptitle;

              ob_start();
              require_once (BASEPATH . 'mailer/Email_Invoice.tpl.php');
              $html_message = ob_get_contents();
              ob_end_clean();

              $msg = Swift_Message::newInstance()
					  ->setSubject($subject)
					  ->setTo(array($row->email => $row->name))
					  ->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->empresa))
					  ->setBody($html_message, 'text/html');
					  
              $msg->attach(Swift_Attachment::newInstance($pdf_content, $row->title . '.pdf', 'application/pdf'));

              ($mailer->send($msg)) ? Filter::msgOk(lang('INVC_SENT_OK')) : Filter::msgError(lang('INVC_SENT_ERR'));
          }
      }

      /**
       * Content::loadInvoiceEntries()
       * 
       * @param mixed $invid
       * @return
       */
	  public function loadInvoiceEntries($invid)
	  {
		  $invdata = $this->getProjectInvoiceData($invid);
		  print '
			<table cellpadding="0" cellspacing="0" class="display">
			  <thead>
				<tr>
				  <th width="20">#</th>
				  <th width="20%" nowrap="nowrap" class="left">' .lang('INVC_ENTRYTITLE') . '</th>
				  <th width="40%" class="left">' . lang('DESC') . '</th>
				  <th class="left">' . lang('AMOUNT') . '</th>
				  <th>' . lang('EDIT') . '</th>
				  <th>' . lang('DELETE') . '</th>
				</tr>
			  </thead>';
		  if (!$invdata) {
			  print '
				<tr>
				  <td colspan="6">' . Filter::msgInfo(lang('INVC_NOENTRY'), false) . '</td>
				</tr>';
		  } else {
			  foreach ($invdata as $irow) {
				  print '
					<tr>
					  <th align="center">' . $irow->id . '.</th>
					  <td>' . $irow->title . '</td>
					  <td>' . $irow->description . '</td>
					  <td>' . $irow->amount . '</td>
					  <td align="center"><a href="index.php?do=invoices&amp;action=editentry&amp;id=' . $irow->id . '">'
					  . '<img src="../images/edit.png" alt="" class="tooltip img-wrap2" title="' . lang('EDIT').': '.$irow->title . '"/></a></td>
					  <td align="center"><a href="javascript:void(0);" class="delete" id="item_' . $irow->id.':'.$irow->project_id.':'.$irow->invoice_id . '" rel="' . $irow->title . '">'
					  . '<img src="../images/delete.png" alt="" class="tooltip img-wrap2" title="' . lang('DELETE').': '.$irow->title . '" /></a></td>
					</tr>';
			  }
			  unset($irow);
		  }
		  print '
			</table>';
	  }

	  /**
	   * Content::processInvoiceEntry()
	   * 
	   * @return
	   */
	  public function processInvoiceEntry()
	  {
		  if (empty($_POST['etitle']))
			  Filter::$msgs['etitle'] = lang('INVC_ENTRYTITLE_R');

		  if (empty($_POST['eamount']) or !is_numeric($_POST['eamount']))
			  Filter::$msgs['eamount'] = lang('INVC_ENTRYAMOUNT_R');

		  if (empty(Filter::$msgs)) {
			  $edata = array(
					'title' => sanitize($_POST['etitle']), 
					'project_id' => intval($_POST['project_id']), 
					'invoice_id' => intval($_POST['invoice_id']), 
					'description' => sanitize($_POST['edesc']), 
					'amount' => floatval($_POST['eamount']), 
					'tax' => (intval($_POST['etax']) == 1 and Registry::get("Core")->enable_tax) ? floatval($_POST['eamount']) * Registry::get("Core")->tax_rate : 0.00
			  );

			  (Filter::$id) ? self::$db->update("invoice_data", $edata, "id='" . Filter::$id . "'") : self::$db->insert("invoice_data", $edata);
			  $message = (Filter::$id) ? lang('INVC_ENTRY_UPDATED') : lang('INVC_ENTRY_ADDED');
			  (self::$db->affected()) ? Filter::msgOk($message) : Filter::msgAlert(lang('NOPROCCESS'));

			  $row = self::$db->first("SELECT SUM(amount) as amtotal, SUM(tax) as itax FROM invoice_data WHERE invoice_id = '" . $edata['invoice_id'] . "' GROUP BY invoice_id");
			  $data = array('amount_total' => $row->amtotal + $row->itax, 'tax' => $row->itax);
			  $pdata['cost'] = $data['amount_total'];

			  self::$db->update("invoices", $data, "id='" . $edata['invoice_id'] . "'");
			  self::$db->update("projects", $pdata, "id='" . $edata['project_id'] . "'");

		  } else
			  print Filter::msgStatus();
	  }

	  /**
	   * Content::deleteInvoiceEntry()
	   * 
	   * @param mixed $data
	   * @return
	   */
	  public function deleteInvoiceEntry($data)
	  {
		  list($id, $project_id, $invoice_id) = explode(':', $data);

		  $res = self::$db->delete("invoice_data", "id='" . (int)$id . "'");
		  $row = self::$db->first("SELECT SUM(amount) as amtotal, SUM(tax) as itax FROM invoice_data WHERE invoice_id = '" . (int)$invoice_id . "' GROUP BY invoice_id");

		  $data = array(
				'amount_total' => ($row) ? $row->amtotal + $row->itax : 0.00, 
				'tax' => ($row) ? $row->itax : 0.00
		  );
		  $pdata['cost'] = $data['amount_total'];
		  $title = sanitize($_POST['title']);

		  self::$db->update("invoices", $data, "id='" . (int)$invoice_id . "'");
		  self::$db->update("projects", $pdata, "id='" . (int)$project_id . "'");

		  print ($res) ? Filter::msgOk(str_replace("[ENTRY]", $title, lang('INVC_DELENTRY_OK'))) : Filter::msgAlert(lang('NOPROCCESS'));

	  }

	  /**
	   * Content::loadInvoiceRecords()
	   * 
	   * @param mixed $invid
	   * @return
	   */
	  public function loadInvoiceRecords($invid)
	  {
		  $paydata = $this->getProjectInvoicePayments($invid);
		  print '
			<table cellpadding="0" cellspacing="0" class="display">
			  <thead>
				<tr>
				  <th width="20">#</th>
				  <th width="20%" nowrap="nowrap" class="left">' . lang('INVC_RECPAID') . '</th>
				  <th width="40%" class="left">' . lang('DESC') . '</th>
				  <th class="left">' . lang('AMOUNT') . '</th>
				  <th>' . lang('EDIT') . '</th>
				  <th>' . lang('DELETE') . '</th>
				</tr>
			  </thead>';
		  if (!$paydata) {
			  print '
				<tr>
				  <td colspan="6">' . Filter::msgInfo(lang('INVC_NORECORD'), false) . '</td>
				</tr>';
		  } else {
			  foreach ($paydata as $prow) {
				  print '
					<tr>
					  <th align="center">' . $prow->id . '.</th>
					  <td>' . $prow->cdate . '</td>
					  <td>' . $prow->description . '</td>
					  <td>' . $prow->amount . '</td>
					  <td align="center"><a href="index.php?do=invoices&amp;action=editentry&amp;id=' . $prow->id . '">'
					  . '<img src="../images/edit.png" alt="" class="tooltip img-wrap2" title="' . lang('EDIT') . '"/></a></td>
					  <td align="center"><a href="javascript:void(0);" class="delete" rel="' . $prow->cdate . '" id="item_' . $prow->id . ':' . $prow->project_id . ':' . $prow->invoice_id . '">'
					  . '<img src="../images/delete.png" alt="" class="tooltip img-wrap2" title="' . lang('DELETE') . '" /></a></td>
					</tr>';
			  }
			  unset($prow);
		  }
		  print '
			</table>';
	  }

	  /**
	   * Content::processInvoiceRecord()
	   * 
	   * @return
	   */
	  public function processInvoiceRecord()
	  {
		  if (empty($_POST['ramount']) or !is_numeric($_POST['ramount']))
			  Filter::$msgs['ramount'] = lang('INVC_RECAMOUNT_R');

		  if (empty(Filter::$msgs)) {
			  $edata = array(
					'project_id' => intval($_POST['project_id']), 
					'invoice_id' => intval($_POST['invoice_id']), 
					'description' => sanitize($_POST['rdesc']), 
					'amount' => floatval($_POST['ramount']), 
					'created' => sanitize($_POST['rcreated']), 
					'method' => sanitize($_POST['method'])
			  );

			  (Filter::$id) ? self::$db->update("invoice_payments", $edata, "id='" . Filter::$id . "'") : self::$db->insert("invoice_payments", $edata);
			  
			  $message = (Filter::$id) ? lang('INVC_REC_UPDATED') : lang('INVC_REC_ADDED');
			  (self::$db->affected()) ? Filter::msgOk($message) : Filter::msgAlert(lang('NOPROCCESS'));

			  $row = self::$db->first("SELECT SUM(amount) as amtotal FROM invoice_payments WHERE invoice_id = '" . $edata['invoice_id'] . "' GROUP BY invoice_id");
			  $data['amount_paid'] = $row->amtotal;
			  $pdata['b_status'] = $data['amount_paid'];

			  self::$db->update("invoices", $data, "id='" . $edata['invoice_id'] . "'");
			  self::$db->update("projects", $pdata, "id='" . $edata['project_id'] . "'");

			  $row2 = self::$db->first("SELECT amount_total, amount_paid FROM invoices WHERE id = '" . $edata['invoice_id'] . "'");
			  $idata['status'] = ($row2->amount_total == $row2->amount_paid) ? 'Paid' : 'Unpaid';
			  self::$db->update("invoices", $idata, "id='" . $edata['invoice_id'] . "'");
			  
		  } else
			  print Filter::msgStatus();
	  }

	  /**
	   * Content::deleteInvoiceRecord()
	   * 
	   * @param mixed $data
	   * @return
	   */
	  public function deleteInvoiceRecord($data)
	  {
		  list($id, $project_id, $invoice_id) = explode(':', $data);

		  $res = self::$db->delete("invoice_payments", "id='" . (int)$id . "'");
		  $row = self::$db->first("SELECT SUM(amount) as amtotal FROM invoice_payments WHERE invoice_id = '" . (int)$invoice_id . "' GROUP BY invoice_id");

		  $idata['amount_paid'] = ($row) ? $row->amtotal : 0.00;
		  $idata['status'] = 'Unpaid';
		  $pdata['b_status'] = ($row) ? $row->amtotal : 0.00;
		  $title = sanitize($_POST['title']);

		  self::$db->update("invoices", $idata, "id='" . (int)$invoice_id . "'");
		  self::$db->update("projects", $pdata, "id='" . (int)$project_id . "'");

		  print ($res) ? Filter::msgOk(str_replace("[RECORD]", $title, lang('INVC_DELRECORD_OK'))) : Filter::msgAlert(lang('NOPROCCESS'));

	  }

	  /**
	   * Content::getInvoicesByStatus()
	   * 
	   * @return
	   */
	  public function getInvoicesByStatus()
	  {
          $pager = Paginator::instance();
          $pager->items_total = countEntries("invoices");
          $pager->default_ipp = Registry::get("Core")->perpage;
          $pager->paginate();

          if (isset($_GET['sort'])) {
			  $sort = sanitize($_GET['sort']);
			  if (in_array($sort, array("Paid", "Unpaid", "Overdue"))) {
				  $where = " WHERE i.status = '" . $sort . "'";
			  }
          } 

          if (isset($_POST['fromdate']) && $_POST['fromdate'] <> "" || isset($from) && $from != '') {
              $enddate = date("Y-m-d");
              $fromdate = (empty($from)) ? $_POST['fromdate'] : $from;
              if (isset($_POST['enddate']) && $_POST['enddate'] <> "") {
                  $enddate = $_POST['enddate'];
              }
              $clause = (isset($where)) ? " AND i.duedate BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59'" : " WHERE i.duedate BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59'";
          }

          $where = (isset($where)) ? $where : null;
		  $clause = (isset($clause)) ? $clause : null;
		  
		  $sql = "SELECT i.*, CONCAT(u.nome,' ',u.lname) as name," 
		  . "\n DATE_FORMAT(i.created, '" . Registry::get("Core")->short_date . "') as cdate," 
		  . "\n DATE_FORMAT(i.duedate, '" . Registry::get("Core")->short_date . "') as ddate" 
		  . "\n FROM invoices as i" 
		  . "\n LEFT JOIN users as u ON u.id = i.client_id" 
		  . "\n $where $clause" 
		  . "\n ORDER BY i.duedate";
		  $row = self::$db->fetch_all($sql);

		  return ($row) ? $row : 0;
	  }
	  
	  /**
	   * Content::getTimeBilling()
	   * 
	   * @return
	   */
	  public function getTimeBilling()
	  {
		  if (Registry::get("Users")->nivel == 5) {
			  $q = "SELECT COUNT(*) FROM time_billing  WHERE staff_id = " . Registry::get("Users")->uid . " GROUP BY project_id LIMIT 1";
			  $access = "WHERE pp.staff_id='" . Registry::get("Users")->uid . "'";
		  } else {
			  $q = "SELECT COUNT(*) FROM time_billing GROUP BY project_id LIMIT 1";
			  $access = null;
		  }
		  $record = Registry::get("Database")->query($q);
		  $total = Registry::get("Database")->fetchrow($record);
		  $counter = $total[0];

		  $pager = Paginator::instance();
		  $pager->items_total = $counter;
		  $pager->default_ipp = Registry::get("Core")->perpage;
		  $pager->paginate();


		  $sql = "SELECT t.*, CONCAT(u.nome,' ',u.lname) as fullname, p.title as ptitle, p.id as pid," 
		  . "\n COUNT(t.project_id) as totalprojects," 
		  . "\n SUM(t.hours) as totalhours" 
		  . "\n FROM time_billing as t" 
		  . "\n LEFT JOIN users as u ON u.id = t.client_id" 
		  . "\n LEFT JOIN projects as p ON p.id = t.project_id" 
		  . "\n LEFT JOIN permissions as pp ON pp.project_id = t.project_id" 
		  . "\n $access" 
		  . "\n GROUP BY t.project_id" . $pager->limit;
		  $row = self::$db->fetch_all($sql);

		  return ($row) ? $row : 0;
	  }

	  /**
	   * Content::getTimeBillingByProjectId()
	   * 
	   * @param bool $project_id
	   * @return
	   */
	  public function getTimeBillingByProjectId($project_id = false)
	  {
		  $id = ($project_id) ? $project_id : Filter::$id;

		  $sql = "SELECT tb.*, t.title as taskname, t.id as tid," 
		  . "\n DATE_FORMAT(tb.created, '" . Registry::get("Core")->short_date . "') as cdate" 
		  . "\n FROM time_billing as tb" 
		  . "\n LEFT JOIN tasks as t ON t.id = tb.task_id" 
		  . "\n WHERE tb.project_id = " . (int)$id . "" 
		  . "\n ORDER BY tb.created DESC";
		  $row = self::$db->fetch_all($sql);

		  return ($row) ? $row : 0;
	  }

	  /**
	   * Content::getTimeBillingById()
	   * 
	   * @param bool $billing_id
	   * @return
	   */
	  public function getTimeBillingById($billing_id = false)
	  {
		  $id = ($billing_id) ? $billing_id : Filter::$id;

		  $sql = "SELECT tb.*, t.title as taskname, t.id as tid, p.title as ptitle, p.id as pid, " 
		  . "\n CONCAT(uc.nome,' ',uc.lname) as cfullname, CONCAT(us.nome,' ',us.lname) as sfullname," 
		  . "\n DATE_FORMAT(tb.created, '" . Registry::get("Core")->short_date . "') as cdate" 
		  . "\n FROM time_billing as tb" 
		  .  "\n LEFT JOIN tasks as t ON t.id = tb.task_id" 
		  . "\n LEFT JOIN projects as p ON p.id = tb.project_id" 
		  . "\n LEFT JOIN users as uc ON uc.id = tb.client_id" 
		  . "\n LEFT JOIN users as us ON us.id = tb.staff_id" 
		  . "\n WHERE tb.id = '" . $id . "'";
		  $row = self::$db->first($sql);

		  return ($row) ? $row : 0;
	  }

	  /**
	   * Content::processTimeRecord()
	   * 
	   * @return
	   */
	  public function processTimeRecord()
	  {
		  if (empty($_POST['title']))
			  Filter::$msgs['title'] = lang('INVC_ENTRYTITLE_R');

		  if (empty($_POST['client_id']))
			  Filter::$msgs['client_id'] = lang('INVC_CLIENTSELECT_R');

		  if (empty($_POST['project_id']))
			  Filter::$msgs['project_id'] = lang('INVC_PROJCSELETC_R');

		  if (empty(Filter::$msgs)) {
			  $data = array(
					'staff_id' => intval($_POST['staff_id']), 
					'client_id' => intval($_POST['client_id']), 
					'project_id' => intval($_POST['project_id']), 
					'task_id' => intval($_POST['task_id']), 
					'title' => sanitize($_POST['title']), 
					'description' => $_POST['description'], 
					'hours' => intval($_POST['hours']), 
					'created' => sanitize($_POST['created']) . ' ' . date('H:i:s')
			  );

			  (Filter::$id) ? self::$db->update("time_billing", $data, "id='" . Filter::$id . "'") : self::$db->insert("time_billing", $data);
			  $message = (Filter::$id) ? lang('BILL_UPDATED') : lang('BILL_ADDED');

			  (self::$db->affected()) ? Filter::msgOk($message) : Filter::msgAlert(lang('NOPROCCESS'));
		  } else
			  print Filter::msgStatus();
	  }

	  /**
	   * Content::getPaymentTransactions()
	   * 
	   * @param bool $from
	   * @return
	   */
	  public function getPaymentTransactions($from = false)
	  {
		  $pager = Paginator::instance();
		  $pager->items_total = countEntries('invoice_payments');
		  $pager->default_ipp = Registry::get("Core")->perpage;
		  $pager->paginate();

		  if (isset($_GET['sort'])) {
			  $data = explode("-", $_GET['sort']);
			  if (count($data) > 1) {
				  $sort = sanitize($data[0]);
				  $order = sanitize($data[1]);
				  if (in_array($sort, array("project_id", "invoice_id", "method", "amount", "created"))) {
					  $ord = ($order == 'DESC') ? " DESC" : " ASC";
					  $sorting = " ip." . $sort . $ord;
				  } else
					  $sorting = " ip.created DESC";
			  } else
				  $sorting = " ip.created DESC";
		  } else
			  $sorting = " ip.created DESC";

		  $clause = (isset($clause)) ? $clause : null;

		  if (isset($_POST['fromdate']) && $_POST['fromdate'] <> "" || isset($from) && $from != '') {
			  $enddate = date("Y-m-d");
			  $fromdate = (empty($from)) ? $_POST['fromdate'] : $from;
			  if (isset($_POST['enddate']) && $_POST['enddate'] <> "") {
				  $enddate = $_POST['enddate'];
			  }
			  $clause .= " WHERE ip.created BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59'";
		  }
		  $where = (isset($where)) ? $where : null;
		  $sql = "SELECT ip.*," 
		  . "\n DATE_FORMAT(ip.created, '" . Registry::get("Core")->short_date . "') as cdate," 
		  . "\n p.title as ptitle, i.title as ititle" 
		  . "\n FROM invoice_payments as ip" 
		  . "\n LEFT JOIN projects as p ON p.id = ip.project_id" 
		  . "\n LEFT JOIN invoices as i ON i.id = ip.invoice_id" 
		  . "\n " . $clause 
		  . "\n ORDER BY " . $sorting . $pager->limit;

		  $row = self::$db->fetch_all($sql);

		  return ($row) ? $row : 0;
	  }

      /**
       * Content::getSupportTickets()
       * 
       * @return
       */
      public function getSupportTickets()
      {
          if (Registry::get("Users")->nivel == 5) {
              $access = "WHERE t.staff_id='" . Registry::get("Users")->uid . "'";
              $counter = countEntries("support_tickets", "staff_id", Registry::get("Users")->uid);
          } else {
              $counter = countEntries("support_tickets");
			  $access = null;
          }

          $pager = Paginator::instance();
          $pager->items_total = $counter;
          $pager->default_ipp = Registry::get("Core")->perpage;
          $pager->paginate();

		  if (isset($_GET['sort'])) {
			  $data = explode("-", $_GET['sort']);
			  if (count($data) > 1) {
				  $sort = sanitize($data[0]);
				  $order = sanitize($data[1]);
				  if (in_array($sort, array("staff_id", "client_id", "priority", "status", "created"))) {
					  $ord = ($order == 'DESC') ? " DESC" : " ASC";
					  $sorting = " t." . $sort . $ord;
				  } else
					  $sorting = " t.created DESC";
			  } else
				  $sorting = " t.created DESC";
		  } else
			  $sorting = " t.created DESC";
			  
          $sql = "SELECT t.*, CONCAT(us.nome,' ',us.lname) as stafnome, CONCAT(uc.nome,' ',uc.lname) as clientname," 
		  . "\n DATE_FORMAT(t.created, '" . Registry::get("Core")->long_date . "') as cdate" 
		  . "\n FROM support_tickets as t" 
		  . "\n LEFT JOIN users as uc ON uc.id = t.client_id" 
		  . "\n LEFT JOIN users as us ON us.id = t.staff_id"
		  . "\n $access" 
		  . "\n ORDER BY " . $sorting . $pager->limit;
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Content::getSupportTicketById()
       * 
       * @return
       */
      public function getSupportTicketById()
      {
          $sql = "SELECT t.*, CONCAT(uc.nome,' ',uc.lname) as clientname," 
		  . "\n DATE_FORMAT(t.created, '" . Registry::get("Core")->long_date . "') as cdate" 
		  . "\n FROM support_tickets as t" 
		  . "\n LEFT JOIN users as uc ON uc.id = t.client_id" 
		  . "\n WHERE t.id = " . Filter::$id;
          $row = self::$db->first($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Content::getResponseByTicketId()
       * 
       * @return
       */
      public function getResponseByTicketId()
      {
          $sql = "SELECT r.*, CONCAT(u.nome,' ',u.lname) as name," 
		  . "\n DATE_FORMAT(r.created, '" . Registry::get("Core")->long_date . "') as cdate" 
		  . "\n FROM support_responses as r" 
		  . "\n LEFT JOIN users as u ON u.id = r.author_id" 
		  . "\n WHERE r.ticket_id = " . Filter::$id
		  . "\n ORDER BY r.created DESC";
          
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

	  /**
	   * Content::processSupportTicket()
	   * 
	   * @return
	   */
	  public function processSupportTicket()
	  {
		  $data = array(
				'priority' => sanitize($_POST['priority']), 
				'staff_id' => intval($_POST['staff_id']), 
				'status' => sanitize($_POST['status'])
		  );

		  self::$db->update("support_tickets", $data, "id='" . Filter::$id . "'");

		  (self::$db->affected()) ? Filter::msgOk(lang('SUP_UPDATED')) : Filter::msgAlert(lang('NOPROCCESS'));

	  }

	  /**
	   * Content::replySupportTicket()
	   * 
	   * @return
	   */
	  public function replySupportTicket()
	  {
		  if (empty($_POST['body']))
			  Filter::$msgs['body'] = lang('SUP_DETAIL_R');

		  if (empty(Filter::$msgs)) {
		  
			  $sql = "SELECT t.*, CONCAT(uc.nome,' ',uc.lname) as clientname, uc.email" 
			  . "\n FROM support_tickets as t" 
			  . "\n LEFT JOIN users as uc ON uc.id = t.client_id" 
			  . "\n WHERE t.id = " . Filter::$id;
			  $row = self::$db->first($sql);
			  
			  $data = array(
					'ticket_id' => $row->id, 
					'author_id' => Registry::get("Users")->uid, 
					'user_type' => 'staff',
					'created' => "NOW()",
					'body' => $_POST['body']
			  );
	
			  self::$db->insert("support_responses", $data);
	
			  require_once (BASEPATH . "lib/class_mailer.php");
			  $mailer = $mail->sendMail();
			  $subject = lang('SUP_ESUBJECT') . $row->subject;
	
			  ob_start();
			  require_once (BASEPATH . 'mailer/Reply_Ticket_From_Admin.tpl.php');
			  $html_message = ob_get_contents();
			  ob_end_clean();
	
			  $msg = Swift_Message::newInstance()
					  ->setSubject($subject)
					  ->setTo(array($row->email => $row->clientname))
					  ->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->empresa))
					  ->setBody($html_message, 'text/html');
	
			  $numSent = $mailer->send($msg);
			  
			  (self::$db->affected()) ? Filter::msgOk(lang('SUP_SENTOK')) : Filter::msgAlert(lang('NOPROCCESS'));

		  } else
			  print Filter::msgStatus();
	  }

	  /**
	   * Content::getMessages()
	   * 
	   * @return
	   */
	  public function getMessages()
	  {
          if (Registry::get("Users")->nivel == 5) {
              $access = "WHERE m.recipient='" . Registry::get("Users")->uid . "' or m.sender='" . Registry::get("Users")->uid . "'";
			  $q = "SELECT COUNT(*) FROM messages  WHERE recipient='" . Registry::get("Users")->uid . "' or sender='" . Registry::get("Users")->uid . "' LIMIT 1";
			  $record = self::$db->query($q);
			  $total = self::$db->fetchrow($record);
			  $counter = $total[0];
          } else {
              $counter = countEntries("messages");
			  $access = null;
          }

		  $pager = Paginator::instance();
		  $pager->items_total = $counter;
		  $pager->default_ipp = Registry::get("Core")->perpage;
		  $pager->paginate();

		  if (isset($_GET['sort'])) {
			  $data = explode("-", $_GET['sort']);
			  if (count($data) > 1) {
				  $sort = sanitize($data[0]);
				  $order = sanitize($data[1]);
				  if (in_array($sort, array("sender", "created", "status_r"))) {
					  $ord = ($order == 'DESC') ? " DESC" : " ASC";
					  $sorting = " m." . $sort . $ord;
				  } else
					  $sorting = " m.created DESC";
			  } else
				  $sorting = " m.created DESC";
		  } else
			  $sorting = " m.created DESC";
			  
		  $sql = "SELECT m.*, CONCAT(u.nome,' ',u.lname) as name," 
		  . "\n DATE_FORMAT(m.created, '" . Registry::get("Core")->long_date . "') as start" 
		  . "\n FROM messages as m" 
		  . "\n LEFT JOIN users as u ON u.id = m.sender" 
		  . "\n $access"
		  . "\n ORDER BY " . $sorting . $pager->limit;
		  $row = self::$db->fetch_all($sql);

		  return ($row) ? $row : 0;
	  }

      /**
       * Content::getMessageById()
       * 
       * @return
       */
      public function getMessageById()
      {
          if (Registry::get("Users")->nivel == 5) {
              $access = "WHERE m.id = " . Filter::$id . " AND m.recipient='" . Registry::get("Users")->uid . "'";
          } else {
			  $access = "WHERE m.id = " . Filter::$id;
          }
		  
		  $sql = "SELECT m.*, CONCAT(u.nome,' ',u.lname) as name," 
		  . "\n DATE_FORMAT(m.created, '" . Registry::get("Core")->long_date . "') as start" 
		  . "\n FROM messages as m" 
		  . "\n LEFT JOIN users as u ON u.id = m.sender" 
		  . "\n $access";
          
          $row = self::$db->first($sql);

          return ($row) ? $row : Filter::error("You have selected an Invalid Id","Content::getMessageById()");
      }

	  /**
	   * Content::processMessage()
	   * 
	   * @return
	   */
	  public function processMessage()
	  {

      if (empty($_POST['recipient']))
          Filter::$msgs['recipient'] = lang('MSG_RECEPIENT_R');
		  
      if (empty($_POST['msgsubject']))
          Filter::$msgs['msgsubject'] = lang('FSG_MSGERR1');
		   
      if (empty($_POST['body']))
          Filter::$msgs['body'] = lang('MSG_MSGERR2');

		  if (empty(Filter::$msgs)) {
			  $newmsgstart = '&lt;li class=&quot;row-staff&quot;&gt;&lt;strong&gt;' . Filter::doDate(Registry::get("Core")->long_date, date('c')) . ' - ' . Registry::get("Users")->usuario . '&lt;/strong&gt;&lt;br /&gt;';              $newmsgend = '&lt;/li&gt;';
              if (Filter::$id) {
				  $subect = str_replace('Re: ','',sanitize($_POST['msgsubject']));
				  $oldmsgsbody = $_POST['oldmsg'];
				  $data = array(
						'created' => 'NOW()', 
						'msgsubject' => 'Re: ' . $subect, 
						'body' => $newmsgstart . $_POST['body'] . $newmsgend . $oldmsgsbody,
						'status_s' => 1, 
						'status_r' => 0
				  );
			  } else {
				  $data = array(
						'created' => 'NOW()', 
						'msgsubject' => sanitize($_POST['msgsubject']), 
						'body' => $newmsgstart . $_POST['body'] . $newmsgend,
						'recipient' => intval($_POST['recipient']),
						'sender' => Registry::get("Users")->uid, 
						'status_s' => 1, 
						'status_r' => 0
				  );
			  }
				  
			  (Filter::$id) ? self::$db->update("messages", $data, "id='" . Filter::$id . "'") : self::$db->insert("messages", $data);
			  
			  (self::$db->affected()) ? Filter::msgOk(lang('MSG_SENTOK')) : Filter::msgAlert(lang('NOPROCCESS'));

			  $sql = "SELECT email, CONCAT(nome,' ',lname) as clientname FROM users WHERE id = " . (int)$_POST['recipient'];
			  $row = self::$db->first($sql);
			  
			  require_once (BASEPATH . "lib/class_mailer.php");
			  $mailer = $mail->sendMail();
			  $subject = lang('MSG_ESUBJECT') . $data['msgsubject'];
	
			  ob_start();
			  require_once (BASEPATH . 'mailer/Reply_Message_From_Admin.tpl.php');
			  $html_message = ob_get_contents();
			  ob_end_clean();
	
			  $msg = Swift_Message::newInstance()
					  ->setSubject($subject)
					  ->setTo(array($row->email => $row->clientname))
					  ->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->empresa))
					  ->setBody($html_message, 'text/html');
	
			  $numSent = $mailer->send($msg);

		  } else
			  print Filter::msgStatus();
	  }
	  
	  /**
	   * Content::progressBarStatus()
	   * 
	   * @param mixed $number
	   * @return
	   */
	  public function progressBarStatus($number)
	  {
		  return ($number == 0) ? lang('NOTSTARTED') : '<div class="progress-bar"><div style="width:' . $number . '%">' . $number . '%&nbsp;&nbsp;</div></div>';
	  }

	  /**
	   * Content::progressBarBilling()
	   * 
	   * @param mixed $paid
	   * @param mixed $total
	   * @return
	   */
	  public function progressBarBilling($paid, $total)
	  {
		  if($paid == -1) {
			  return lang('UNPAID');
		  } else {
			  $percent = number_format(($paid * 100) / $total);
			  return ($paid == 0) ? lang('NOTBILLED') : '<div class="progress-bar"><div style="width:' . $percent . '%" class="green">' . $percent . '%&nbsp;&nbsp;</div></div>';
		  }
	  }

	  /**
	   * Content::invoiceStatusList()
	   * 
	   * @param string $selected
	   * @return
	   */
	  public function invoiceStatusList($selected = '')
	  {
		  $arr = array('Paid' => lang('PAID'), 'Unpaid' => lang('UNPAID'), 'Overdue' => lang('OVERDUE'));

		  $list = '';
		  foreach ($arr as $key => $val) {
			  $sel = ($key == $selected) ? ' selected="selected"' : '';
			  $list .= "<option value=\"" . $key . "\"" . $sel . ">" . $val . "</option>\n";
		  }
		  unset($val);
		  return $list;
	  }

	  /**
	   * Content::billingStatusList()
	   * 
	   * @param string $selected
	   * @return
	   */
	  public function billingStatusList($selected = '')
	  {
		  $arr = array('Not Yet Billed' => lang('NOTBILLED'), 'Paid' => lang('PAID'), 'Unpaid' => lang('UNPAID'), 'Overdue' => lang('OVERDUE'));

		  $list = '';
		  foreach ($arr as $key => $val) {
			  $sel = ($key == $selected) ? ' selected="selected"' : '';
			  $list .= "<option value=\"" . $key . "\"" . $sel . ">" . $val . "</option>\n";
		  }
		  unset($val);
		  return $list;
	  }

	  /**
	   * Content::projectStatusList()
	   * 
	   * @param string $selected
	   * @return
	   */
	  public function projectStatusList($selected = '')
	  {
		  $arr = array('Not Yet Started' => lang('NOTSTARTED'), 'In Progress' => lang('INPROGRESS'), 'Completed' => lang('COMPLETED'));

		  $list = '';
		  foreach ($arr as $key => $val) {
			  $sel = ($key == $selected) ? ' selected="selected"' : '';
			  $list .= "<option value=\"" . $key . "\"" . $sel . ">" . $val . "</option>\n";
		  }
		  unset($val);
		  return $list;
	  }

	  /**
	   * Content::projectSubmissionList()
	   * 
	   * @param string $selected
	   * @return
	   */
	  public function projectSubmissionList($selected = '')
	  {
		  $arr = array('New Concept' => lang('NEW_CONCEPT'), 'Revision' => lang('REVISION'), 'Draft' => lang('DRAFT'), 'Final' => lang('FINAL'));

		  $list = '';
		  foreach ($arr as $key => $val) {
			  $sel = ($key == $selected) ? ' selected="selected"' : '';
			  $list .= "<option value=\"" . $key . "\"" . $sel . ">" . $val . "</option>\n";
		  }
		  unset($val);
		  return $list;
	  }

	  /**
	   * Content::ticketPriorityList()
	   * 
	   * @param string $selected
	   * @return
	   */
	  public function ticketPriorityList($selected = '')
	  {
		  $arr = array('High' => lang('HIGH'), 'Medium' => lang('MEDIUM'), 'Low' => lang('LOW'));

		  $list = '';
		  foreach ($arr as $key => $val) {
			  $sel = ($key == $selected) ? ' selected="selected"' : '';
			  $list .= "<option value=\"" . $key . "\"" . $sel . ">" . $val . "</option>\n";
		  }
		  unset($val);
		  return $list;
	  }

	  /**
	   * Content::ticketStatusList()
	   * 
	   * @param string $selected
	   * @return
	   */
	  public function ticketStatusList($selected = '')
	  {
		  $arr = array('Open' => lang('OPEN'), 'Closed' => lang('CLOSED'));

		  $list = '';
		  foreach ($arr as $key => $val) {
			  $sel = ($key == $selected) ? ' selected="selected"' : '';
			  $list .= "<option value=\"" . $key . "\"" . $sel . ">" . $val . "</option>\n";
		  }
		  unset($val);
		  return $list;
	  }
	  
	  /**
	   * Content::getAllInfo()
	   * 
	   * @param mixed $project_id
	   * @return
	   */
	  public function getAllInfo($project_id)
	  {
		  $sql = "SELECT p.id as pid, p.title, p.p_status, p.b_status, p.cost, u.id as uid, u.email," 
		  . "\n CONCAT(u.nome,' ',u.lname) as clientname," 
		  . "\n DATE_FORMAT(p.start_date, '" . Registry::get("Core")->short_date . "') as start," 
		  . "\n DATE_FORMAT(p.end_date, '" . Registry::get("Core")->short_date . "') as enddate," 
		  . "\n (SELECT CONCAT(nome,' ',lname) FROM users WHERE id = p.staff_id) as stafnome" 
		  . "\n FROM projects as p" 
		  . "\n LEFT JOIN users as u ON u.id = p.client_id" 
		  . "\n WHERE p.id = '" . (int)$project_id . "'";
		  $row = self::$db->first($sql);

		  return ($row) ? $row : 0;
	  }

	  /**
	   * Content::getProjectsForClient()
	   * 
	   * @param mixed $user_id
	   * @return
	   */
	  public function getProjectsForClient($user_id)
	  {
		  $sql = "SELECT p.id as pid, p.title, p.p_status, p.b_status, p.cost, p.start_date as start," 
		  . "\n (SELECT CONCAT(nome,' ',lname) FROM users WHERE id = p.staff_id) as stafnome" 
		  . "\n FROM projects as p" 
		  . "\n LEFT JOIN users as u ON u.id = p.client_id" 
		  . "\n WHERE p.client_id = '" . (int)$user_id . "'";
		  $row = self::$db->fetch_all($sql);

		  return ($row) ? $row : 0;
	  }

	  /**
	   * Content::getInvoiceForClient()
	   * 
	   * @param mixed $user_id
	   * @return
	   */
	  public function getInvoiceForClient($user_id)
	  {
		  $sql = "SELECT *," 
		  . "\n DATE_FORMAT(created, '" . Registry::get("Core")->short_date . "') as start" 
		  . "\n FROM invoices" 
		  . "\n WHERE client_id = '" . (int)$user_id . "'";
		  $row = self::$db->fetch_all($sql);

		  return ($row) ? $row : 0;
	  }

	  /**
	   * Content::getFormsList()
	   * 
	   * @return
	   */
	  public function getFormsList()
	  {
		  $sql = "SELECT id, title" 
		  . "\n FROM forms" 
		  . "\n WHERE active = 1";
		  $row = self::$db->fetch_all($sql);

		  return ($row) ? $row : 0;
	  }

	  /**
	   * Content::getEstimatorList()
	   * 
	   * @return
	   */
	  public function getEstimatorList()
	  {
		  $sql = "SELECT id, title" 
		  . "\n FROM estimator" 
		  . "\n WHERE active = 1";
		  $row = self::$db->fetch_all($sql);

		  return ($row) ? $row : 0;
	  }
	  
	  /**
	   * Content::getPaymentFilter()
	   * 
	   * @return
	   */
	  public function getPaymentFilter()
	  {
		  $arr = array(
				'project_id-ASC' => lang('PROJ_NAME') . ' &uarr;', 
				'project_id-DESC' => lang('PROJ_NAME') . ' &darr;', 
				'invoice_id-ASC' => lang('INVC_NAME') . ' &uarr;', 
				'invoice_id-DESC' => lang('INVC_NAME') . ' &darr;', 
				'method-ASC' => lang('PAYMETHOD') . ' &uarr;', 
				'method-DESC' => lang('PAYMETHOD') . ' &darr;', 
				'amount-ASC' => lang('TRANS_PAYAMOUNT') . ' &uarr;', 
				'amount-DESC' => lang('TRANS_PAYAMOUNT') . ' &darr;', 
				'created-ASC' => lang('TRANS_PAYDATE') . ' &uarr;', 
				'created-DESC' => lang('TRANS_PAYDATE') . ' &darr;'
		  );

		  $filter = '';
		  foreach ($arr as $key => $val) {
			  if ($key == get('sort')) {
				  $filter .= "<option selected=\"selected\" value=\"$key\">$val</option>\n";
			  } else
				  $filter .= "<option value=\"$key\">$val</option>\n";
		  }
		  unset($val);
		  return $filter;
	  }

	  /**
	   * Content::getTicketFilter()
	   * 
	   * @return
	   */
	  public function getTicketFilter()
	  {
		  $arr = array(
				'staff_id-ASC' => lang('SUP_STAFF') . ' &uarr;', 
				'staff_id-DESC' => lang('SUP_STAFF') . ' &darr;', 
				'client_id-ASC' => lang('INVC_CNAME') . ' &uarr;', 
				'client_id-DESC' => lang('INVC_CNAME') . ' &darr;', 
				'priority-ASC' => lang('SUP_PRIORITY1') . ' &uarr;', 
				'priority-DESC' => lang('SUP_PRIORITY1') . ' &darr;', 
				'status-ASC' => lang('SUP_STATUS') . ' &uarr;', 
				'status-DESC' => lang('SUP_STATUS') . ' &darr;', 
				'created-ASC' => lang('SUP_CREATED') . ' &uarr;', 
				'created-DESC' => lang('SUP_CREATED') . ' &darr;'
		  );

		  $filter = '';
		  foreach ($arr as $key => $val) {
			  if ($key == get('sort')) {
				  $filter .= "<option selected=\"selected\" value=\"$key\">$val</option>\n";
			  } else
				  $filter .= "<option value=\"$key\">$val</option>\n";
		  }
		  unset($val);
		  return $filter;
	  }

	  /**
	   * Content::getMessageFilter()
	   * 
	   * @return
	   */
	  public function getMessageFilter()
	  {
		  $arr = array(
				'sender-ASC' => lang('MSG_SENDER').' &uarr;', 
				'sender-DESC' => lang('MSG_SENDER').' &darr;', 
				'status_r-ASC' => lang('MSG_STATUS').' &uarr;', 
				'status_r-DESC' => lang('MSG_STATUS').' &darr;', 
				'created-ASC' => lang('MSG_DATESENT').' &uarr;', 
				'created-DESC' => lang('MSG_DATESENT').' &darr;'
		  );

		  $filter = '';
		  foreach ($arr as $key => $val) {
			  if ($key == get('sort')) {
				  $filter .= "<option selected=\"selected\" value=\"$key\">$val</option>\n";
			  } else
				  $filter .= "<option value=\"$key\">$val</option>\n";
		  }
		  unset($val);
		  return $filter;
	  }
	  
	  /**
	   * Content::projectSubmissionStatus()
	   * 
	   * @param mixed $status
	   * @return
	   */
	  public function projectSubmissionStatus($status)
	  {
		  switch ($status) {
			  case 0:
				  return lang('SUBS_STATUS1');
				  break;

			  case 1:
				  return lang('SUBS_STATUS2');
				  break;

			  case 2:
				  return lang('SUBS_STATUS3');
				  break;
				  
			  case 3:
				  return lang('SUBS_STATUS4');
				  break;
		  }

	  }
	  
  }
?>