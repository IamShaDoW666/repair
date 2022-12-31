<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Customers
 *
 *
 * @package		Repairer
 * @category	Controller
 * @author		Usman Sher
*/

// Includes all customers controller

class Errors extends Auth_Controller
{
	// THE CONSTRUCTOR //
    public function __construct()
    {
        parent::__construct();
        $this->load->model('errors_model');
    }

	// PRINT A CUSTOMERS PAGE //
    public function index()
    {
        $this->mPageTitle = lang('reparation_errors');
        $this->render('reparation/errors');
    }

	// GENERATE THE AJAX TABLE CONTENT //
    public function getAllErrors()
    {
        $this->load->library('datatables');
        $this->datatables
            ->select('id, defect, code, description, reason')
            ->from('reparation_errors');


        $actions = '<div class="text-center"><div class="btn-group dropleft">'
            . '<button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">'
            . ('actions') . ' <span class="caret"></span></button>
        <ul class="dropdown-menu " role="menu">';


        $actions .= "<a class='dropdown-item' data-dismiss='modal' id='modify_error' href='#errormodal' data-toggle='modal' data-num='$1'><i class='fas fa-edit'></i> ".lang('edit_error')."</a>";
        $actions .= '<a class="dropdown-item" id="delete_error" data-num="$1"><i class="fas fa-trash"></i> '.lang('delete_error').'</a>';

        $actions .= '</ul></div>';


        $this->datatables->add_column('actions', $actions, 'id');
        $this->datatables->unset_column('id');
        echo $this->datatables->generate();
    }

    
	// ADD A CUSTOMER //
    public function add() {

        $data = array(
            'defect' =>  $this->input->post('defect', true),
            'code' =>  $this->input->post('code', true),
            'description' =>  $this->input->post('description', true),
            'reason' =>  $this->input->post('reason', true),
        );

        $error = null;
        $id = $this->errors_model->add($data);
        echo $this->repairer->send_json(array('id'=>$id, 'error'=>$error));
    }

	// EDIT CUSTOMER //
    public function edit()
    {

        $id = $this->input->post('id', true);
        $data = array(
            'defect' =>  $this->input->post('defect', true),
            'code' =>  $this->input->post('code', true),
            'description' =>  $this->input->post('description', true),
            'reason' =>  $this->input->post('reason', true),
        );

        $error = null;
       
        $this->errors_model->edit($id, $data);
        echo $this->repairer->send_json(array('id'=>$id, 'error'=>$error));
    }

	// DELETE CUSTOMER 
    public function delete()
    {
		$id = $this->security->xss_clean($this->input->post('id', true));
        $data = $this->errors_model->delete($id);
        echo $this->repairer->send_json($data);
    }


	// GET CUSTOMER AND SEND TO AJAX FOR SHOW IT //
    public function getErrorByID()
    {
        $id = $this->security->xss_clean($this->input->post('id', true));
		$data = $this->errors_model->find($id);
		$token = $this->input->post('token', true);
        echo $this->repairer->send_json($data);
    }

    

}   