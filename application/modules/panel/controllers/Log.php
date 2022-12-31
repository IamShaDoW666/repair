<?php

class Log extends Auth_Controller
{
    // THE CONSTRUCTOR //
    public function __construct()
    {
        parent::__construct();
    }

    function index()
    {
    	$this->mPageTitle=lang('logs/index');
        $this->render('activity_log');
    }

    function getLog(){
    	$this->load->library('datatables');
        
        $this->datatables
    			->select('"" as id, if(amount, CONCAT(action, "___", amount, "___", model),  action), model, CONCAT(model, "___" ,link_id) as link_id, CONCAT(users.first_name, " ", users.last_name), DATE_FORMAT(date,"%d-%m-%Y %H:%i") as date, ip_addr, "activity_log.id" as actions, details, amount, action, activity_log.id as aid')
                ->join('users', 'users.id=activity_log.user_id', 'left')
    			->from('activity_log');
        echo $this->datatables->generate();
    }

}