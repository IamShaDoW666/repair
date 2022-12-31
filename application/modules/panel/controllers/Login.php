<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// NOTE: this controller inherits from MY_Controller instead of Admin_Controller,
// since no authentication is required
class Login extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		if ($this->ion_auth->logged_in()) {
			redirect('panel/welcome');
		}

	}
	/**
	 * Login page and submission
	 */
	// log the user in
	public function index()
	{

		// Load Recaptcha
		if ($this->mSettings->enable_recaptcha) {
			$this->load->library('recaptcha');
			$this->recaptcha->set_keys($this->mSettings->google_site_key, $this->mSettings->google_secret_key);
		}
		
		$this->mPageTitle = $this->lang->line('login_heading');
		$this->mBodyClass = 'hold-transition login-page';
		//validate form input
		$this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
		$this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

		if ($this->form_validation->run() == true)
		{

			if ($this->mSettings->enable_recaptcha) {
				$response = $this->input->post('g-recaptcha-response');
				if ($response) {
					if(!$this->recaptcha->is_valid($response, NULL)){
		            	$this->session->set_flashdata('message', lang("invalid_captcha"));
						redirect('panel/login');
					}
				}else{
					$this->session->set_flashdata('message', lang("invalid_captcha"));
						redirect('panel/login');
				}
			}
			// check to see if the user is logging in
			// check for "remember me"
			$remember = (bool) $this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
			{
				$user = $this->ion_auth->user()->row();
				$this->settings_model->addLog('login', 'auth', $user->id, json_encode(array(
                	'email' => $this->input->post('identity'),
            	)));
				//if the login is successful
				//redirect them back to the home page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect('panel/welcome'); // use redirects instead of loading views for compatibility with MY_Controller libraries

			}
			else
			{
				// if the login was un-successful
				// redirect them back to the login page
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('panel/'); // use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		}
		else
		{
			// the user is not logging in so display the login page
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['identity'] = array('name' => 'identity',
				'id'    => 'identity',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('identity'),
			);
			$this->data['password'] = array('name' => 'password',
				'id'   => 'password',
				'type' => 'password',
			);

			$this->render('auth/login', 'empty');
		}
	}



	// forgot password
	public function forgot_password()
	{

		// Load Recaptcha
		if ($this->mSettings->enable_recaptcha) {
			$this->load->library('recaptcha');
			$this->recaptcha->set_keys($this->mSettings->google_site_key, $this->mSettings->google_secret_key);
		}


		$this->mBodyClass = 'hold-transition login-page';

		// setting validation rules by checking whether identity is username or email
		if($this->config->item('identity', 'ion_auth') != 'email' ) {
		   $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
		} else {
		   $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
		}

		if ($this->form_validation->run() == false) {
			$this->data['type'] = $this->config->item('identity','ion_auth');
			// setup the input
			$this->data['identity'] = array('name' => 'identity',
				'id' => 'identity',
				'class'=>'form-control'
			);

			if ( $this->config->item('identity', 'ion_auth') != 'email' ){
				$this->data['identity_label'] = $this->lang->line('forgot_password_identity_label');
			}
			else
			{
				$this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
			}

			// set any errors and display the form
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->render('auth/forgot_password', 'empty');
		} else {
			if ($this->mSettings->enable_recaptcha) {
				$response = $this->input->post('g-recaptcha-response');
				if ($response) {
					if(!$this->recaptcha->is_valid($response, NULL)){
		            	$this->session->set_flashdata('message', lang("invalid_captcha"));
						redirect('panel/login/forgot_password');
					}
				}else{
					$this->session->set_flashdata('message', lang("invalid_captcha"));
						redirect('panel/login/forgot_password');
				}
			}

			$identity_column = $this->config->item('identity','ion_auth');
			$identity = $this->ion_auth->where($identity_column, $this->input->post('identity'))->users()->row();

			if(empty($identity)) {
        		if($this->config->item('identity', 'ion_auth') != 'email')
            	{
            		$this->ion_auth->set_error('forgot_password_identity_not_found');
            	}
            	else
            	{
            	   $this->ion_auth->set_error('forgot_password_email_not_found');
            	}

                $this->session->set_flashdata('message', $this->ion_auth->errors());
        		redirect("panel/login/forgot_password", 'refresh');
    		}

			// run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

			if ($forgotten)
			{
				// if there were no errors
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("panel/login", 'refresh'); //we should display a confirmation page here instead of the login page
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect("panel/login/forgot_password", 'refresh');
			}
		}
	}	

	public function _get_csrf_nonce() {
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);
		return array($key => $value);
	}


	public function reset_password($code = NULL) {
		$this->mBodyClass = 'hold-transition login-page';

        if (!$code) {
            show_404();
        }

        $user = $this->ion_auth->forgotten_password_check($code);

        if ($user) {

            $this->form_validation->set_rules('new', lang('password'), 'required|min_length[8]|max_length[25]|matches[new_confirm]');
            $this->form_validation->set_rules('new_confirm', lang('confirm_password'), 'required');

            if ($this->form_validation->run() == false) {
                $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
                $this->data['message'] = $this->session->flashdata('message');
                $this->data['title'] = lang('reset_password');
                $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
                $this->data['new_password'] = array(
                    'name' => 'new',
                    'id' => 'new',
                    'type' => 'password',
                    'class' => 'form-control',
                    'data-bv-regexp-message' => lang('pasword_hint'),
                    'placeholder' => lang('new_password')
                );
                $this->data['new_password_confirm'] = array(
                    'name' => 'new_confirm',
                    'id' => 'new_confirm',
                    'type' => 'password',
                    'class' => 'form-control',
                    'data-bv-identical' => 'true',
                    'data-bv-identical-field' => 'new',
                    'data-bv-identical-message' => lang('pw_not_same'),
                    'placeholder' => lang('confirm_password')
                );
                $this->data['user_id'] = array(
                    'name' => 'user_id',
                    'id' => 'user_id',
                    'type' => 'hidden',
                    'value' => $user->id,
                );
                $this->data['csrf'] = $this->_get_csrf_nonce();
                $this->data['code'] = $code;
                $this->data['identity_label'] = $user->email;
                //render
                $this->render('auth/reset_password', 'empty');
            } else {
                // do we have a valid request?
                if ($user->id != $this->input->post('user_id')) {
                    //something fishy might be up
                    $this->ion_auth->clear_forgotten_password_code($code);
                    show_error(lang('error_csrf'));

                } else {
                    // finally change the password
                    $identity = $user->email;

                    $change = $this->ion_auth->reset_password($identity, $this->input->post('new'));
                    if ($change) {
                        //if the password was successfully changed
                        $this->data['message'] = $this->ion_auth->messages();
                        $this->session->set_flashdata('message', $this->ion_auth->messages());
                        redirect('panel/login');
                    } else {
                        $this->data['message'] = $this->ion_auth->errors();
                        $this->session->set_flashdata('error', $this->ion_auth->errors());
                        redirect('panel/login/reset_password/' . $code);
                    }
                }
            }
        } else {
            //if the code is invalid then send them back to the forgot password page
            $this->session->set_flashdata('error', $this->ion_auth->errors());
            redirect("panel/login/forgot_password");
        }
    }



}
?>
