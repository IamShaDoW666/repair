<?php

/**
 * Base controllers for different purposes
 * 	- MY_Controller: for Frontend Website
 * 	- Admin_Controller: for Admin Panel (require login), extends from MY_Controller
 * 	- API_Controller: for API Site, extends from REST_Controller
 */
class MY_Controller extends MX_Controller {
	
	public $mModule = '';			
	public $mCtrler = 'home';		
	public $mAction = 'index';		
	public $mMethod = 'GET';			

	
	protected $mConfig = array();
	protected $mBaseUrl = array();
	protected $mSiteName = '';
	protected $mMetaData = array();
	protected $mScripts = array();
	public 	  $mSettings = NULL;
	protected $mStylesheets = array();

	
	protected $mPageTitlePrefix = '';
	protected $mPageTitle = '';
	protected $mBodyClass = '';
	protected $mMenu = array();
	protected $mBreadcrumb = array();

	
	protected $mMultilingual = FALSE;
	protected $mLanguage = 'en';
	protected $mAvailableLanguages = array();

	
	protected $data = array();

	
	public $mPageAuth = array();
	public $mUser = NULL;
	public $mUserGroups = array();
	public $mUserMainGroup;
	public $Admin = FALSE;

	
	public function __construct()
	{
		parent::__construct();

		
		$this->mCtrler = $this->router->fetch_class();
		$this->mAction = $this->router->fetch_method();
		$this->mMethod = $this->input->server('REQUEST_METHOD');
		$this->load->model('main_model');
		$this->load->model('settings_model');
		$this->load->model('reparation_model');
		$this->mSettings = $this->settings_model->getSettings();
		$this->lang->load('main_lang', $this->mSettings->language);
		$this->lang->load('auth', $this->mSettings->language);
		$this->lang->load('ion_auth', $this->mSettings->language);
		$this->main_model->gen_token();

		
		if(file_exists(APPPATH.'modules'.DIRECTORY_SEPARATOR.'panel'.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.'Pos.php')) {
            define("POS", 1);
        } else {
            define("POS", 0);
        }
		
		$this->_setup();
	}

	
	private function _setup()
	{
		

		$config = $this->config->item('my_config');
		
		$this->mBaseUrl = empty($this->mModule) ? base_url() : base_url($this->mModule).'/';
		$this->mSiteName = empty($config['site_name']) ? '' : $config['site_name'];
		$this->mPageTitlePrefix = empty($config['page_title_prefix']) ? '' : $config['page_title_prefix'];
		$this->mPageTitle = empty($config['page_title']) ? '' : $config['page_title'];
		$this->mBodyClass = empty($config['body_class']) ? '' : $config['body_class'];
		$this->mMenu = empty($config['menu']) ? array() : $config['menu'];

		if (!$this->mSettings->show_settings_menu) {
			unset($this->mMenu['settings']);
		}

        $this->data['users'] = $this->ion_auth->users()->result();
		
		if (POS) {
        	$this->lang->load('pos', $this->mSettings->language);
		}else{
			unset($this->mMenu['pos']);
		}

		$this->mMetaData = empty($config['meta_data']) ? array() : $config['meta_data'];
		$this->mScripts = empty($config['scripts']) ? array() : $config['scripts'];
		$this->mStylesheets = empty($config['stylesheets']) ? array() : $config['stylesheets'];
		$this->mPageAuth = empty($config['page_auth']) ? array() : $config['page_auth'];
		$this->mTRates = $this->settings_model->getTaxRates();
		$this->theme = $this->mSettings->theme.'/views/';
        if(is_dir(VIEWPATH.$this->mSettings->theme.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR)) {
            $this->assets = base_url() . 'themes/' . $this->mSettings->theme . '/assets/';
        } else {
            $this->assets = base_url() . 'themes/adminlte/assets/';
        }

        $this->data['assets'] = $this->assets;

		$this->data['settings'] = $this->mSettings;
        
		
		$uri = ($this->mAction=='index') ? $this->mCtrler : $this->mCtrler.'/'.$this->mAction;
		if ( !empty($this->mPageAuth[$uri]) && !$this->ion_auth->in_group($this->mPageAuth[$uri]) )
		{
			$page_404 = $this->router->routes['404_override'];
			$redirect_url = empty($this->mModule) ? $page_404 : $this->mModule.'/'.$page_404;
			redirect($redirect_url);
		}

		
		if ($this->mCtrler!='home')
		{
			$page = $this->mMultilingual ? lang('home') : 'Home';
			$this->push_breadcrumb($page, '');
		}


        $this->data['dateFormats'] = null;

        if($sd = $this->settings_model->getDateFormat($this->mSettings->dateformat)) {
            $dateFormats = array(
                'js_sdate' => $sd->js,
                'php_sdate' => $sd->php,
                'mysq_sdate' => $sd->sql,
                'js_ldate' => $sd->js . ' HH:mm',
                'php_ldate' => $sd->php . ' H:i',
                'mysql_ldate' => $sd->sql . ' %H:%i'
                );
        } else {
            $dateFormats = array(
                'js_sdate' => 'mm-dd-yyyy',
                'php_sdate' => 'm-d-Y',
                'mysq_sdate' => '%m-%d-%Y',
                'js_ldate' => 'mm-dd-yyyy HH:mm:SS',
                'php_ldate' => 'm-d-Y H:i:s',
                'mysql_ldate' => '%m-%d-%Y %T'
                );
        }

		$this->dateFormats = $dateFormats;
        $this->data['dateFormats'] = $dateFormats;

		
		if ( $this->ion_auth->logged_in() )
		{
			$this->mUser = $this->ion_auth->user()->row();
			$this->Admin = $this->repairer->in_group('admin') ? TRUE : FALSE;
            $this->data['Admin'] = $this->Admin;
            if(!$this->Admin) {
            	$gp = $this->settings_model->getGroupPermissions($this->ion_auth->get_users_groups()->row()->id);
	            $this->GP = $gp[0];
	            $this->data['GP'] = $gp[0];
	        } else {
	            $this->data['GP'] = NULL;
	        }
		}

		$this->mConfig = $config;
	}

	
	protected function verify_login($redirect_url = NULL)
	{
		if ( !$this->ion_auth->logged_in() )
		{
			if ( $redirect_url==NULL )
				$redirect_url = $this->mConfig['login_url'];

			redirect($redirect_url);
		}
	}

	
	
	
	protected function verify_auth($group = 'members', $redirect_url = NULL)
	{
		if ( !$this->ion_auth->logged_in() || !$this->ion_auth->in_group($group) )
		{
			if ( $redirect_url==NULL )
				$redirect_url = $this->mConfig['login_url'];
			
			redirect($redirect_url);
		}
	}

	
	
	protected function add_script($files, $append = TRUE, $position = 'foot')
	{
		$files = is_string($files) ? array($files) : $files;
		$position = ($position==='head' || $position==='foot') ? $position : 'foot';

		if ($append)
			$this->mScripts[$position] = array_merge($this->mScripts[$position], $files);
		else
			$this->mScripts[$position] = array_merge($files, $this->mScripts[$position]);
	}

	
	
	protected function add_stylesheet($files, $append = TRUE, $media = 'screen')
	{
		$files = is_string($files) ? array($files) : $files;

		if ($append)
			$this->mStylesheets[$media] = array_merge($this->mStylesheets[$media], $files);
		else
			$this->mStylesheets[$media] = array_merge($files, $this->mStylesheets[$media]);
	}

	
	protected function render($view_file, $layout = 'default')
	{
		
		if ( empty($this->mPageTitle) )
		{
			if ($this->mAction=='index')
				$this->mPageTitle = humanize($this->mCtrler);
			else
				$this->mPageTitle = humanize($this->mAction);
		}
		$this->data['module'] = $this->mModule;
		$this->data['ctrler'] = $this->mCtrler;
		$this->data['action'] = $this->mAction;
		$this->data['taxRates'] = $this->mTRates;

		$this->data['site_name'] = $this->mSiteName;
		$this->data['page_title'] = $this->mPageTitlePrefix.$this->mPageTitle;
		$this->data['current_uri'] = empty($this->mModule) ? uri_string(): str_replace($this->mModule.'/', '', uri_string());
		$this->data['meta_data'] = $this->mMetaData;
		$this->data['scripts'] = $this->mScripts;
		$this->data['stylesheets'] = $this->mStylesheets;
		$this->data['page_auth'] = $this->mPageAuth;
		$this->data['clients'] = $this->settings_model->getAllClients();
		$this->data['errors'] = $this->settings_model->getAllErrors();
        $this->data['models'] = $this->reparation_model->getAllModels();
        $this->data['tax_rates'] = $this->settings_model->getTaxRates();
        $this->data['statuses'] = $this->settings_model->getRepairStatuses();
        $this->data['manufacturers'] = $this->settings_model->getAllManufacturers();

		$this->data['base_url'] = $this->mBaseUrl;
		$this->data['menu'] = $this->mMenu;
		$this->data['user'] = $this->mUser;
		$this->data['ga_id'] = empty($this->mConfig['ga_id']) ? '' : $this->mConfig['ga_id'];
		$this->data['body_class'] = $this->mBodyClass;

		
		$this->push_breadcrumb($this->mPageTitle);
		$this->data['breadcrumb'] = $this->mBreadcrumb;
        $this->data['qty_alert_num'] = $this->settings_model->get_total_qty_alerts();

		$this->data['inner_view'] = $view_file;

		if($layout !== 'file') {
			$this->load->view($this->theme . '_base/head', $this->data);
			$this->load->view($this->theme . '_layouts/'.$layout, $this->data);
			$this->load->view($this->theme . '_base/foot', $this->data);
		}else{
			$this->load->view($this->theme . '_layouts/empty', $this->data);
		}
		
	}

	
	protected function render_json($data, $code = 200)
	{
		$this->output
			->set_status_header($code)
			->set_content_type('application/json')
			->set_output(json_encode($data));
			
		
		global $OUT;
		$OUT->_display();
		exit;
	}

	
	
	protected function push_breadcrumb($name, $url = '#', $append = TRUE)
	{
		$entry = array('name' => $name, 'url' => $url);

		if ($append)
			$this->mBreadcrumb[] = $entry;
		else
			array_unshift($this->mBreadcrumb, $entry);
	}
	
}


require APPPATH."core/Auth_Controller.php";
