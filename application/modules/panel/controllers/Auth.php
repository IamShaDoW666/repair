<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends Auth_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		$this->upload_path = 'assets/uploads/members';
        $this->image_types = 'gif|jpg|jpeg|png|tif';
        $this->allowed_file_size = '10720';
        $this->load->library('upload');

	}

	// redirect if needed, otherwise display the user list
	public function index()
	{
		$this->repairer->checkPermissions();
		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
		$this->mPageTitle = lang('users');
		
		//list the users
		$this->data['users'] = $this->ion_auth->users()->result();
		foreach ($this->data['users'] as $k => $user)
		{
			$this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
		}

		$this->_render_page('auth/index', $this->data);
	}

	// log the user out
	public function logout()
	{
		$this->mPageTitle = lang('logout');
		$user = $this->mUser;

		// log the user out
		$logout = $this->ion_auth->logout();
		
		$this->settings_model->addLog('logout', 'auth', $user->id, json_encode(array(
        	'email' => $user->email,
    	)));
		// redirect them to the login page
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect('panel/login', 'refresh');
	}

	// change password
	public function change_password()
	{
		$this->mPageTitle = lang('change_password');

		$this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
		$this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
		$this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

		if (!$this->ion_auth->logged_in())
		{
			redirect('panel/login', 'refresh');
		}

		$user = $this->ion_auth->user()->row();

		if ($this->form_validation->run() == false)
		{
			// display the form
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
			$this->data['old_password'] = array(
				'name' => 'old',
				'id'   => 'old',
				'type' => 'password',
				'class' => 'form-control'
			);
			$this->data['new_password'] = array(
				'name'    => 'new',
				'id'      => 'new',
				'type'    => 'password',
				'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
				'class' => 'form-control'
			);
			$this->data['new_password_confirm'] = array(
				'name'    => 'new_confirm',
				'id'      => 'new_confirm',
				'type'    => 'password',
				'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
				'class' => 'form-control'
			);
			$this->data['user_id'] = array(
				'name'  => 'user_id',
				'id'    => 'user_id',
				'type'  => 'hidden',
				'value' => $user->id,
				'class' => 'form-control'
			);

			// render
			$this->_render_page('auth/change_password', $this->data);
		}
		else
		{
			$identity = $this->session->userdata('identity');

			$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

			if ($change)
			{
				//if the password was successfully changed
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				$this->logout();
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('panel/auth/change_password', 'refresh');
			}
		}
	}

	// activate the user
	public function activate($id, $code=false)
	{
		$this->mPageTitle = lang('activate_user');

		if ($code !== false)
		{
			$activation = $this->ion_auth->activate($id, $code);
		}
		else if ($this->ion_auth->is_admin())
		{
			$activation = $this->ion_auth->activate($id);
		}
		if ($activation)
		{
			$this->settings_model->addLog('activate', 'user', $id, json_encode(array(
            	)));
			// redirect them to the auth page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("panel/auth", 'refresh');
		}
		else
		{
			// redirect them to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("panel/auth/forgot_password", 'refresh');
		}
	}
	
	public function delete_user($id)
	{
		$this->repairer->checkPermissions();

		if($this->ion_auth->delete_user($id)){
			$this->settings_model->addLog('delete', 'user', $id, json_encode(array(
            )));
			$this->session->set_flashdata('message', $this->ion_auth->messages());
		}else{
			$this->session->set_flashdata('message', $this->ion_auth->errors());
		}

		redirect('panel/auth');
	}
	
	// deactivate the user
	function deactivate($id = NULL)
	{

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error(lang('error_auth'));
		}

		$id = (int) $id;

		// do we have the right userlevel?
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
		{
			if ($this->ion_auth->deactivate($id)) {
				$this->settings_model->addLog('deactivate', 'user', $id, json_encode(array()));
				$this->session->set_flashdata('message', $this->ion_auth->messages());
			}

		}

		// redirect them back to the auth page
		redirect('panel/auth', 'refresh');
		
	}

	// create a new user
	public function create_user()
    {
		$this->repairer->checkPermissions();

        $this->mPageTitle = $this->lang->line('create_user_heading');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            redirect('panel/auth', 'refresh');
        }

        $tables = $this->config->item('tables','ion_auth');
        $identity_column = $this->config->item('identity','ion_auth');
        $this->data['identity_column'] = $identity_column;

        // validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');
        if($identity_column!=='email')
        {
            $this->form_validation->set_rules('identity',$this->lang->line('create_user_validation_identity_label'),'required|is_unique['.$tables['users'].'.'.$identity_column.']');
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email');
        }
        else
        {
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique[' . $tables['users'] . '.email]');
        }
        $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
        $this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'trim');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

        if ($this->form_validation->run() == true)
        {
            $email    = strtolower($this->input->post('email'));
            $identity = ($identity_column==='email') ? $email : $this->input->post('identity');
            $password = $this->input->post('password');

            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name'  => $this->input->post('last_name'),
                'company'    => $this->input->post('company'),
                'phone'      => $this->input->post('phone'),
				'image'		 => 'no_image.png',
            );
            if (isset($_FILES['user_image'])) {
                if ($_FILES['user_image']['size'] > 0) {
                    $config['upload_path'] = $this->upload_path;
                    $config['allowed_types'] = $this->image_types;
                    $config['max_size'] = $this->allowed_file_size;
                    $config['overwrite'] = FALSE;
                    $config['max_filename'] = 25;
                    $config['encrypt_name'] = TRUE;
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('user_image')) {
                        $error = $this->upload->display_errors();
                        $this->session->set_flashdata('error', $error);
                        redirect("panel/auth/add");
                    }else{
                        $photo = $this->upload->file_name;
                        $additional_data['image'] = $photo;
                        $config = NULL;

                    }
                }
            }
        }
        if ($this->form_validation->run() == true &&  $id = $this->ion_auth->register($identity, $password, $email, $additional_data))
        {
            // check to see if we are creating the user
            // redirect them back to the admin page
            $this->settings_model->addLog('add', 'user', $id, json_encode(array(
				'additional_data' => $additional_data,
            )));
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect("panel/auth", 'refresh');
        }
        else
        {
            // display the create user form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $this->data['first_name'] = array(
                'name'  => 'first_name',
                'id'    => 'first_name',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('first_name'),
                'class' => 'form-control'
            );
            $this->data['last_name'] = array(
                'name'  => 'last_name',
                'id'    => 'last_name',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('last_name'),
                'class' => 'form-control'

            );
            $this->data['identity'] = array(
                'name'  => 'identity',
                'id'    => 'identity',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('identity'),
                'class' => 'form-control'

            );
            $this->data['email'] = array(
                'name'  => 'email',
                'id'    => 'email',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('email'),
                'class' => 'form-control'

            );
            $this->data['company'] = array(
                'name'  => 'company',
                'id'    => 'company',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('company'),
                'class' => 'form-control'

            );
            $this->data['phone'] = array(
                'name'  => 'phone',
                'id'    => 'phone',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('phone'),
                'class' => 'form-control'

            );
            $this->data['password'] = array(
                'name'  => 'password',
                'id'    => 'password',
                'type'  => 'password',
                'value' => $this->form_validation->set_value('password'),
                'class' => 'form-control'

            );
            $this->data['password_confirm'] = array(
                'name'  => 'password_confirm',
                'id'    => 'password_confirm',
                'type'  => 'password',
                'value' => $this->form_validation->set_value('password_confirm'),
                'class' => 'form-control'

            );

            $this->_render_page('auth/create_user', $this->data);
        }
    }

	// edit a user
	public function edit_user($id)
	{
		$this->repairer->checkPermissions();

		$this->mPageTitle = $this->lang->line('edit_user_heading');

		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
		{
			redirect('panel/auth', 'refresh');
		}

		$user = $this->ion_auth->user($id)->row();
		$groups=$this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_users_groups($id)->result();
        $tables = $this->config->item('tables','ion_auth');

		// validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required');
		$this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required');
		$this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'required');
		$this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'required');

		if ($user->email !== $this->input->post('email')) {
        	$this->form_validation->set_rules('email', $this->lang->line('edit_user_validation_email_label'), 'required|valid_email|is_unique[' . $tables['users'] . '.email]');
		}

		if (isset($_POST) && !empty($_POST))
		{
		
			// update the password if it was posted
			if ($this->input->post('password'))
			{
				$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
			}

			if ($this->form_validation->run() === TRUE)
			{
				$data = array(
					'first_name' => $this->input->post('first_name'),
					'last_name'  => $this->input->post('last_name'),
					'company'    => $this->input->post('company'),
					'phone'      => $this->input->post('phone'),
					'email'      => $this->input->post('email'),
					'image'		 => 'no_image.png',
	            );
	            if (isset($_FILES['user_image'])) {
	                if ($_FILES['user_image']['size'] > 0) {
	                    $config['upload_path'] = $this->upload_path;
	                    $config['allowed_types'] = $this->image_types;
	                    $config['max_size'] = $this->allowed_file_size;
	                    $config['overwrite'] = FALSE;
	                    $config['max_filename'] = 25;
	                    $config['encrypt_name'] = TRUE;
	                    $this->upload->initialize($config);
	                    if (!$this->upload->do_upload('user_image')) {

	                        $error = $this->upload->display_errors();
	                        $this->session->set_flashdata('error', $error);
	                        redirect("panel/auth/add");
	                    }else{
	                        $photo = $this->upload->file_name;
	                        $data['image'] = $photo;
	                        $config = NULL;

	                    }
	                }
	            }

				// update the password if it was posted
				if ($this->input->post('password'))
				{
					$data['password'] = $this->input->post('password');
				}



				// Only allow updating groups if user is admin
				if ($this->ion_auth->is_admin())
				{
					//Update the groups user belongs to
					$groupData = $this->input->post('groups');

					if (isset($groupData) && !empty($groupData)) {

						$this->ion_auth->remove_from_group('', $id);

						foreach ($groupData as $grp) {
							$this->ion_auth->add_to_group($grp, $id);
						}

					}
				}

			// check to see if we are updating the user
			   if($this->ion_auth->update($user->id, $data))
			    {
			    	$this->settings_model->addLog('update', 'user', $user->id, json_encode(array(
						'data' => $data,
		            )));
			    	// redirect them back to the admin page if admin, or to the base url if non admin
				    $this->session->set_flashdata('message', $this->ion_auth->messages() );
				    if ($this->ion_auth->is_admin())
					{
						redirect('panel/auth', 'refresh');
					}
					else
					{
						redirect('panel/', 'refresh');
					}

			    }
			    else
			    {
			    	// redirect them back to the admin page if admin, or to the base url if non admin
				    $this->session->set_flashdata('message', $this->ion_auth->errors() );
				    if ($this->ion_auth->is_admin())
					{
						redirect('panel/auth', 'refresh');
					}
					else
					{
						redirect('panel/', 'refresh');
					}

			    }

			}
		}

		// display the edit user form
		$this->data['csrf'] = $this->_get_csrf_nonce();

		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		// pass the user to the view
		$this->data['user'] = $user;
		$this->data['groups'] = $groups;
		$this->data['currentGroups'] = $currentGroups;

		$this->data['first_name'] = array(
			'name'  => 'first_name',
			'id'    => 'first_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('first_name', $user->first_name),
            'class' => 'form-control',

		);
		$this->data['last_name'] = array(
			'name'  => 'last_name',
			'id'    => 'last_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('last_name', $user->last_name),
            'class' => 'form-control',

		);
		$this->data['company'] = array(
			'name'  => 'company',
			'id'    => 'company',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('company', $user->company),
            'class' => 'form-control',

		);
		$this->data['phone'] = array(
			'name'  => 'phone',
			'id'    => 'phone',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('phone', $user->phone),
            'class' => 'form-control',

		);

		$this->data['email'] = array(
			'name'  => 'email',
			'id'    => 'email',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('email', $user->email),
            'class' => 'form-control',

		);
		$this->data['password'] = array(
			'name' => 'password',
			'id'   => 'password',
			'type' => 'password',
            'class' => 'form-control'

		);
		$this->data['password_confirm'] = array(
			'name' => 'password_confirm',
			'id'   => 'password_confirm',
			'type' => 'password',
			'class' => 'form-control'
		);
		$this->data['image'] = $user->image;
		$this->_render_page('auth/edit_user', $this->data);
	}

	function user_groups()
    {
		$this->repairer->checkPermissions();
		$this->mPageTitle = $this->lang->line('user_groups');

		$this->data['group_name'] = array(
			'name'  => 'group_name',
			'id'    => 'group_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('group_name'),
			'class' => 'form-control'
		);
		$this->data['description'] = array(
			'name'  => 'description',
			'id'    => 'description',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('description'),
			'class' => 'form-control'
		);
		
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['groups'] = $this->settings_model->getGroups();
		$this->render('auth/user_groups');
    }
    function delete_group($id = NULL)
    {
		$this->repairer->checkPermissions();
        if ($this->settings_model->checkGroupUsers($id)) {
            $this->session->set_flashdata('error', lang("group_x_b_deleted"));
            redirect("panel/auth/user_groups");
        }

        if ($this->settings_model->deleteGroup($id)) {
            $this->session->set_flashdata('message', lang("group_deleted"));
            redirect("panel/auth/user_groups");
        }
    }


	// create a new group
	public function create_group()
	{
		$this->repairer->checkPermissions();
		$this->mPageTitle = $this->lang->line('create_group');

		$this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'required|alpha_dash');
		if ($this->form_validation->run() == TRUE)
		{

			$new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
			if($new_group_id)
			{
				 $this->settings_model->addLog('add', 'user-group', $new_group_id, json_encode(array(
            	)));
	            $this->db->insert('permissions', array('group_id' => $new_group_id));
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("panel/auth/permissions/".$new_group_id, 'refresh');
			}
		}else{
			$this->session->set_flashdata('warning', validation_errors());
			redirect('panel/auth/user_groups');
		}
	}

	// edit a group
	public function edit_group($id)
	{
		$this->repairer->checkPermissions();

		// bail if no group id given
		if(!$id || empty($id))
		{
			redirect('panel/auth', 'refresh');
		}

		$this->mPageTitle = $this->lang->line('edit_group_title');

		
		$group = $this->ion_auth->group($id)->row();

		// validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'required|alpha_dash');

		if (isset($_POST) && !empty($_POST))
		{
			if ($this->form_validation->run() === TRUE)
			{
				$group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $_POST['group_description']);


				if($group_update)
				{
					$this->settings_model->addLog('edit', 'user-group', $id, json_encode(array(
            		)));
					$this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
				}
				else
				{
					$this->session->set_flashdata('message', $this->ion_auth->errors());
				}
				redirect("panel/auth/user_groups", 'refresh');
			}
		}

		if (validation_errors()) {
			$this->session->set_flashdata('warning', validation_errors());
			redirect('panel/auth/user_groups');
		}
		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		// pass the user to the view
		$this->data['group'] = $group;

		$readonly = $this->config->item('admin_group', 'ion_auth') === $group->name ? 'readonly' : '';

		$this->data['group_name'] = array(
			'name'    => 'group_name',
			'id'      => 'group_name',
			'type'    => 'text',
			'value'   => $this->form_validation->set_value('group_name', $group->name),
			'class'   => 'form-control',
			$readonly => $readonly,
		);
		$this->data['group_description'] = array(
			'name'  => 'group_description',
			'id'    => 'group_description',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('group_description', $group->description),
			'class' => 'form-control',
		);

		$this->load->view($this->theme . 'auth/edit_group', $this->data);
	}


	public function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	public function _valid_csrf_nonce()
	{
		if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
			$this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue')) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function _render_page($view, $data=null, $returnhtml=false)//I think this makes more sense
	{

		$this->viewdata = (empty($data)) ? $this->data: $data;

		$view_html = $this->render($view);

		if ($returnhtml) return $view_html;//This will return html on 3rd argument being true
	}


	function permissions($id = NULL)
    {
		$this->mPageTitle = lang('group_permissions');
        $this->form_validation->set_rules('group', 'Group', 'is_natural_no_zero');
        if ($this->form_validation->run() == true) {
            $data = array(
				'repair-index' => $this->input->post('repair-index'),
				'repair-add' => $this->input->post('repair-add'),
				'repair-edit' => $this->input->post('repair-edit'),
				'repair-delete' => $this->input->post('repair-delete'),
				'repair-view_repair' => $this->input->post('repair-view_repair'),
				'customers-index' => $this->input->post('customers-index'),
				'customers-add' => $this->input->post('customers-add'),
				'customers-edit' => $this->input->post('customers-edit'),
				'customers-delete' => $this->input->post('customers-delete'),
				'customers-view_customer' => $this->input->post('customers-view_customer'),
				'auth-index' => $this->input->post('auth-index'),
				'auth-create_user' => $this->input->post('auth-create_user'),
				'auth-edit_user' => $this->input->post('auth-edit_user'),
				'auth-delete_user' => $this->input->post('auth-delete_user'),
				'auth-user_groups' => $this->input->post('auth-user_groups'),
				'auth-delete_group' => $this->input->post('auth-delete_group'),
				'auth-create_group' => $this->input->post('auth-create_group'),
				'auth-edit_group' => $this->input->post('auth-edit_group'),
				'auth-permissions' => $this->input->post('auth-permissions'),
				'inventory-index' => $this->input->post('inventory-index'),
				'inventory-add' => $this->input->post('inventory-add'),
				'inventory-edit' => $this->input->post('inventory-edit'),
				'inventory-delete' => $this->input->post('inventory-delete'),
				'inventory-print_barcodes' => $this->input->post('inventory-print_barcodes'),
				'inventory-product_actions' => $this->input->post('inventory-product_actions'),
				'inventory-suppliers' => $this->input->post('inventory-suppliers'),
				'inventory-add_supplier' => $this->input->post('inventory-add_supplier'),
				'inventory-edit_supplier' => $this->input->post('inventory-edit_supplier'),
				'inventory-delete_supplier' => $this->input->post('inventory-delete_supplier'),
				'inventory-models' => $this->input->post('inventory-models'),
				'inventory-add_model' => $this->input->post('inventory-add_model'),
				'inventory-edit_model' => $this->input->post('inventory-edit_model'),
				'inventory-delete_model' => $this->input->post('inventory-delete_model'),
				'purchases-index' => $this->input->post('purchases-index'),
				'purchases-add' => $this->input->post('purchases-add'),
				'purchases-edit' => $this->input->post('purchases-edit'),
				'purchases-delete' => $this->input->post('purchases-delete'),
				'reports-sales' => $this->input->post('reports-sales'),
				'reports-drawer' => $this->input->post('reports-drawer'),
				'reports-stock' => $this->input->post('reports-stock'),
				'reports-finance' => $this->input->post('reports-finance'),
				'reports-quantity_alerts' => $this->input->post('reports-quantity_alerts'),
				'utilities-index' => $this->input->post('utilities-index'),
				'utilities-backup_db' => $this->input->post('utilities-backup_db'),
				'utilities-restore_db' => $this->input->post('utilities-restore_db'),
				'utilities-remove_db' => $this->input->post('utilities-remove_db'),
				'tax_rates-index' => $this->input->post('tax_rates-index'),
				'tax_rates-add' => $this->input->post('tax_rates-add'),
				'tax_rates-edit' => $this->input->post('tax_rates-edit'),
				'tax_rates-delete' => $this->input->post('tax_rates-delete'),
				'categories-index' => $this->input->post('categories-index'),
				'categories-add' => $this->input->post('categories-add'),
				'categories-edit' => $this->input->post('categories-edit'),
				'categories-delete' => $this->input->post('categories-delete'),
				'dashboard-qemail' => $this->input->post('dashboard-qemail'),
				'dashboard-qsms' => $this->input->post('dashboard-qsms'),
				'inventory-manufacturers' => $this->input->post('inventory-manufacturers'),
				'inventory-add_manufacturer' => $this->input->post('inventory-add_manufacturer'),
				'inventory-edit_manufacturer' => $this->input->post('inventory-edit_manufacturer'),
				'inventory-delete_manufacturer' => $this->input->post('inventory-delete_manufacturer'),
				'reparation-print_barcodes' => $this->input->post('reparation-print_barcodes'),
				'pos-index' => $this->input->post('pos-index'),

            );

        }

        if ($this->form_validation->run() == true && $this->settings_model->updatePermissions($id, $data)) {
        	$this->settings_model->addLog('update-permissions', 'user-group', $id, json_encode(array(
        		'data' => $data,
    		)));
            $this->session->set_flashdata('message', lang('gperm_updated'));
            redirect($_SERVER["HTTP_REFERER"]);
        } else {
            $this->data['id'] = $id;
            $this->data['p'] = $this->settings_model->getGroupPermissionsByGroupID($id);
            $this->data['group'] = $this->settings_model->getGroupByID($id);
            $this->render('auth/permissions');
        }

    }

}
