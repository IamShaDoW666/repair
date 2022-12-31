<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends Auth_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('repairer');
		$this->load->model('reports_model');
	}

	function stock()
    {
        $this->mPageTitle = lang('stock');
        $this->repairer->checkPermissions();
        $data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['totals'] = $this->reports_model->getStockTotals();
        $this->render('reports/stock_chart');

    }

    public function finance()
    {
        $start = date("Y-m-d",strtotime("-1 month"));
        if ($this->input->get('start')) {
            $start = $this->repairer->fsd($this->input->get('start'));
        }

        
        $end = date('Y-m-d 23:59:59');
        if ($this->input->get('end')) {
            $end = $this->repairer->fsd($this->input->get('end'));
        }

        $created_by = null;
        if ($this->input->get('created_by')) {
            $created_by = $this->input->get('created_by');
        }

        $sales_count = $this->reports_model->getTotalSales($start,$end, $created_by);
        $repairs_sum = $this->reports_model->getRepairSales($start,$end, $created_by);
       
        $this->data['reports_data'] = [
            'order_counts' => $sales_count[0],
            'order_counts_total' => $sales_count[1],
            'order_repairs' => $repairs_sum[0],
            'order_repairs_total' => $repairs_sum[1],
        ];
        $this->data['users'] = $this->db->where('active', 1)->get('users')->result();
        
        $this->render('reports/finance_new');
    }

    function quantity_alerts($warehouse_id = NULL)
    {
        $this->repairer->checkPermissions();
        $this->mPageTitle = lang('quantity_alerts');

        $this->render('reports/quantity_alerts');
    }
    function getQuantityAlerts($warehouse_id = NULL, $pdf = NULL, $xls = NULL)
    {
        $this->repairer->checkPermissions('quantity_alerts');

        $this->load->library('datatables');
        
        $this->datatables
            ->select('code, name, quantity, alert_quantity')
            ->where('isDeleted != ', 1)
            ->from('inventory')
            ->where('alert_quantity > quantity', NULL)
            ->where('alert_quantity >', 0);
        echo $this->datatables->generate();
    }




}
