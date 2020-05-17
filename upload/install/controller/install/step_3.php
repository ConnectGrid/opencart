<?php
class ControllerInstallStep3 extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('install/step_3');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->load->model('install/install');

			$this->model_install_install->database($this->request->post);

            // build config array
            $cfg = [];

            $cfg['HTTP_SERVER']  = "{$_SERVER['DOCUMENT_ROOT']}/store";
            $cfg['HTTPS_SERVER'] = "{$_SERVER['DOCUMENT_ROOT']}/store";
            
            // directories
            foreach (['DIR_APPLICATION', 'DIR_SYSTEM', 'DIR_IMAGE', 'DIR_STORAGE', 'DIR_LANGUAGE',
                      'DIR_TEMPLATE', 'DIR_CONFIG', 'DIR_CACHE', 'DIR_DOWNLOAD', 'DIR_LOGS',
                      'DIR_MODIFICATION', 'DIR_SESSION', 'DIR_UPLOAD'] as $constant) {
                $cfg[$constant] = constant($constant);
            }

            // database
            $cfg['DB_DRIVER']   = $this->request->post['db_driver'];
            $cfg['DB_HOSTNAME'] = $this->request->post['db_hostname'];
            $cfg['DB_USERNAME'] = $this->request->post['db_username'];
            $cfg['DB_PASSWORD'] = html_entity_decode($this->request->post['db_password'], ENT_QUOTES, 'UTF-8');
            $cfg['DB_DATABASE'] = $this->request->post['db_database'];
            $cfg['DB_PORT']     = $this->request->post['db_port'];
            $cfg['DB_PREFIX']   = $this->request->post['db_prefix'];

            $cfg['OPENCART_SERVER'] = 'https://www.opencart.com/';

            $file = '<?php' . PHP_EOL . PHP_EOL;
            foreach ($cfg as $k => $v) {
                 $file .= "const {$k} = '{$v}';" . PHP_EOL;
            }

            // write config file
            file_put_contents(OPENCART_CONFIG_FILE, $file);

            // write admin config
			file_put_contents(OPENCART_ADMIN_CONFIG_FILE, $file);

			$this->response->redirect($this->url->link('install/step_4'));
		}

		$this->document->setTitle($this->language->get('heading_title'));

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_step_3'] = $this->language->get('text_step_3');
		$data['text_db_connection'] = $this->language->get('text_db_connection');
		$data['text_db_administration'] = $this->language->get('text_db_administration');
		$data['text_mysqli'] = $this->language->get('text_mysqli');
		$data['text_mpdo'] = $this->language->get('text_mpdo');
		$data['text_pgsql'] = $this->language->get('text_pgsql');

		$data['entry_db_driver'] = $this->language->get('entry_db_driver');
		$data['entry_db_hostname'] = $this->language->get('entry_db_hostname');
		$data['entry_db_username'] = $this->language->get('entry_db_username');
		$data['entry_db_password'] = $this->language->get('entry_db_password');
		$data['entry_db_database'] = $this->language->get('entry_db_database');
		$data['entry_db_port'] = $this->language->get('entry_db_port');
		$data['entry_db_prefix'] = $this->language->get('entry_db_prefix');
		$data['entry_username'] = $this->language->get('entry_username');
		$data['entry_password'] = $this->language->get('entry_password');
		$data['entry_email'] = $this->language->get('entry_email');

		$data['button_continue'] = $this->language->get('button_continue');
		$data['button_back'] = $this->language->get('button_back');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['db_hostname'])) {
			$data['error_db_hostname'] = $this->error['db_hostname'];
		} else {
			$data['error_db_hostname'] = '';
		}

		if (isset($this->error['db_username'])) {
			$data['error_db_username'] = $this->error['db_username'];
		} else {
			$data['error_db_username'] = '';
		}

		if (isset($this->error['db_database'])) {
			$data['error_db_database'] = $this->error['db_database'];
		} else {
			$data['error_db_database'] = '';
		}

		if (isset($this->error['db_port'])) {
			$data['error_db_port'] = $this->error['db_port'];
		} else {
			$data['error_db_port'] = '';
		}

		if (isset($this->error['db_prefix'])) {
			$data['error_db_prefix'] = $this->error['db_prefix'];
		} else {
			$data['error_db_prefix'] = '';
		}

		if (isset($this->error['username'])) {
			$data['error_username'] = $this->error['username'];
		} else {
			$data['error_username'] = '';
		}

		if (isset($this->error['password'])) {
			$data['error_password'] = $this->error['password'];
		} else {
			$data['error_password'] = '';
		}

		if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}

		$data['action'] = $this->url->link('install/step_3');

		if (isset($this->request->post['db_driver'])) {
			$data['db_driver'] = $this->request->post['db_driver'];
		} else {
			$data['db_driver'] = '';
		}

		if (isset($this->request->post['db_hostname'])) {
			$data['db_hostname'] = $this->request->post['db_hostname'];
		} else {
			$data['db_hostname'] = 'localhost';
		}

		if (isset($this->request->post['db_username'])) {
			$data['db_username'] = $this->request->post['db_username'];
		} else {
			$data['db_username'] = 'root';
		}

		if (isset($this->request->post['db_password'])) {
			$data['db_password'] = $this->request->post['db_password'];
		} else {
			$data['db_password'] = '';
		}

		if (isset($this->request->post['db_database'])) {
			$data['db_database'] = $this->request->post['db_database'];
		} else {
			$data['db_database'] = '';
		}

		if (isset($this->request->post['db_port'])) {
			$data['db_port'] = $this->request->post['db_port'];
		} else {
			$data['db_port'] = 3306;
		}

		if (isset($this->request->post['db_prefix'])) {
			$data['db_prefix'] = $this->request->post['db_prefix'];
		} else {
			$data['db_prefix'] = 'oc_';
		}

		if (isset($this->request->post['username'])) {
			$data['username'] = $this->request->post['username'];
		} else {
			$data['username'] = 'admin';
		}

		if (isset($this->request->post['password'])) {
			$data['password'] = $this->request->post['password'];
		} else {
			$data['password'] = '';
		}

		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} else {
			$data['email'] = '';
		}

		$data['mysqli'] = extension_loaded('mysqli');
		$data['mysql'] = extension_loaded('mysql');
		$data['pdo'] = extension_loaded('pdo');
		$data['pgsql'] = extension_loaded('pgsql');

		$data['back'] = $this->url->link('install/step_2');

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');

		$this->response->setOutput($this->load->view('install/step_3', $data));
	}

	private function validate() {
		if (!$this->request->post['db_hostname']) {
			$this->error['db_hostname'] = $this->language->get('error_db_hostname');
		}

		if (!$this->request->post['db_username']) {
			$this->error['db_username'] = $this->language->get('error_db_username');
		}

		if (!$this->request->post['db_database']) {
			$this->error['db_database'] = $this->language->get('error_db_database');
		}

		if (!$this->request->post['db_port']) {
			$this->error['db_port'] = $this->language->get('error_db_port');
		}

		if ($this->request->post['db_prefix'] && preg_match('/[^a-z0-9_]/', $this->request->post['db_prefix'])) {
			$this->error['db_prefix'] = $this->language->get('error_db_prefix');
		}

		if ($this->request->post['db_driver'] == 'mysqli') {
			try {
				$db = new \DB\MySQLi($this->request->post['db_hostname'], $this->request->post['db_username'], html_entity_decode($this->request->post['db_password'], ENT_QUOTES, 'UTF-8'), $this->request->post['db_database'], $this->request->post['db_port']);

				if (is_resource($db)) {
					$db->close();
				}
			} catch(Exception $e) {
				$this->error['warning'] = $mysql->connect_error;
			}
		} elseif ($this->request->post['db_driver'] == 'mpdo') {
			try {
				$db = new \DB\mPDO($this->request->post['db_hostname'], $this->request->post['db_username'], html_entity_decode($this->request->post['db_password'], ENT_QUOTES, 'UTF-8'), $this->request->post['db_database'], $this->request->post['db_port']);

				if (is_resource($db)) {
					$db->close();
				}
			} catch(Exception $e) {
				$this->error['warning'] = $e->getMessage();
			}
		}

		if (!$this->request->post['username']) {
			$this->error['username'] = $this->language->get('error_username');
		}

		if (!$this->request->post['password']) {
			$this->error['password'] = $this->language->get('error_password');
		}

		if ((utf8_strlen($this->request->post['email']) > 96) || !filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
			$this->error['email'] = $this->language->get('error_email');
		}

		if (!is_writable(OPENCART_CONFIG_FILE)) {
			$this->error['warning'] = $this->language->get('error_config') . OPENCART_CONFIG_FILE . '!';
		}

		if (!is_writable(OPENCART_ADMIN_CONFIG_FILE)) {
			$this->error['warning'] = $this->language->get('error_config') . OPENCART_ADMIN_CONFIG_FILE . '!';
		}

		return !$this->error;
	}
}
