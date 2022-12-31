<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends Auth_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->load->model('welcome_model');
        $this->load->model('reports_model');
    }
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
        $this->mPageTitle = lang('home');
		$this->data['reparation_count'] = $this->welcome_model->getReparationCount();
		$this->data['clients_count'] = $this->welcome_model->getClientCount();
		$this->data['stock_count'] = $this->welcome_model->getStockCount();
		$this->data['currency'] = $this->mSettings->currency;
		$this->data['technicians'] = $this->getTechReport();
		$this->render('dashboard');
	}

	public function getTechReport()
	{
		$q = $this->db
			->select('CONCAT(users.first_name, " ",users.last_name) as name,first_name, last_name, COUNT(reparation.id) as repair_count, SUM(grand_total) as total_revenue')
			->join('users', 'reparation.assigned_to=users.id','left')
			->where('users.id !=', null)
			->group_by('reparation.assigned_to')
			->get('reparation');
		if ($q->num_rows() > 0) {
			return $q->result();
		}
		return [];
	}

	public function getTechReportDA()
	{
        $this->load->library('datatables');

		$q = $this->datatables
			->select('CONCAT(users.first_name, " ",users.last_name) as name, (SELECT COUNT(reparation.id)  FROM reparation WHERE assigned_to = users.id) as repair_count, (SELECT SUM(reparation.grand_total)  FROM reparation WHERE assigned_to = users.id) as total_revenue')
			->from('users');
        echo $this->datatables->generate();

	}

	public function getTechReportD()
	{
        $this->load->library('datatables');

        $start_date = null;
        $end_date = null;
      	if ($this->input->post('start_date')) {
            $start_date = $this->input->post('start_date');
        }

        if ($this->input->post('end_date')) {
            $end_date = $this->input->post('end_date');
        }

        $date = '';
        if ($start_date && $end_date) {
        	$date = ' AND reparation.date_opening BETWEEN "'.$start_date.'" AND "'.$end_date.'"';
        }

		$q = $this->datatables
			->select('CONCAT(users.first_name, " ",users.last_name) as name, (SELECT COUNT(reparation.id)  FROM reparation WHERE assigned_to = users.id '.$date.') as repair_count, (SELECT SUM(reparation.grand_total)  FROM reparation WHERE assigned_to = users.id '.$date.') as total_revenue')
			->from('users');
        echo $this->datatables->generate();

	}
	
	public function send_mail(){
		if ($this->input->post('email_to')) {
			$to 		= ($this->input->post('email_to')  != '') ? $this->input->post('email_to') : FALSE;
			$to 		= $this->settings_model->getClientsByIDs($to);
			$to 		= array_column($to, 'email');
		}else{
			$to 		= ($this->input->post('to')  != '') ? $this->input->post('to') : FALSE;
		}
		$subject 	= ($this->input->post('subject') != '') ? $this->input->post('subject') : FALSE;
		$body 		= ($this->input->post('body') != '') ? $this->input->post('body') : FALSE;
		if ($to==FALSE OR $subject==FALSE OR $body==FALSE) {
			echo 2;
			die();
		}
		$this->load->library('repairer');
		$result = $this->repairer->send_email($to, $subject, $body);
		if ($result) {
			echo 1;
		}else{
			echo 0;
		}
	}
	
	public function nav_toggle() {
        $this->output->set_header('Content-Type: application/json; charset=utf-8');
        $state = (string) $this->input->post('state');
        if ($state == '') {
            $state = null;
            $this->session->unset_userdata('main_sidebar_state');
        } else {
            $this->session->set_userdata('main_sidebar_state', $state);
        }
        $this->output->set_output(json_encode(array('state' => $state)));
    }
    
   
}
