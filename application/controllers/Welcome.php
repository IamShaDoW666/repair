<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {


	public function index()
	{
        $this->load->model('settings_model');
		$this->load->view($this->theme . 'home', $this->data);
		$this->load->language('main_lang');
	}



	public function status()
    {
    	header("Access-Control-Allow-Origin: *");
        $code = $this->input->post('code', true);
        $id = $this->input->post('id', true);
        $data = array();
        $query = $this->db
            ->where('code', $code)
        	
        	->select('*, status.label as status, fg_color, bg_color')
        	->join('status', 'status.id=reparation.status')
        	->get('reparation');
        if ($query->num_rows() > 0) {
            $data = $query->row_array();
            $data['date_opening'] = date('d-m-Y', strtotime($data['date_opening']));
            if ($data['date_closing'] && $data['date_closing'] !== '0000-00-00 00:00:00') {
                $data['date_closing'] = date('d-m-Y', strtotime($data['date_closing']));
            }else{
                $data['date_closing'] = null;
            }

            echo json_encode($data);
        } else {
            echo 'false';
        }
    }


    public function save_repair()
    {
    	$this->load->model('inventory_model');
        $name = $this->input->post('first_name') . ' ' . $this->input->post('last_name');
        $model = $this->inventory_model->getModelByName($this->input->post('model'));

        $data = array(
            'name' => $name,
            'telephone' => $this->input->post('phone'),
            'email' => $this->input->post('email'),
            'address' => $this->input->post('address'),
            'where_you_hear_about_us' => $this->input->post('where_you_hear_about_us'),
            
            'manufacturer' => $this->input->post('manufacturer'),
            'model_id' => $model ? $model->id : NULL,
            'model_name' => $this->input->post('model'),
            'passcode' => $this->input->post('passcode'),
            'defect' => $this->input->post('problem'),
            'imei' => $this->input->post('imei'),
            'date' => date('Y-m-d H:i:s'),
        );

        $this->db->insert('leads', $data);
        $lead_id = $this->db->insert_id();


        if ($this->input->post('sign_id')) {
            $data = $this->input->post('sign_id');
            $name = 'lead_' . $lead_id . '__'.time().'.png';
            $this->repairer->base30_to_jpeg($data, FCPATH.'assets/uploads/signs/'.$name);
            $this->db->where('id', $lead_id);
            $this->db->update('leads', array('repair_sign' => $name));
        }

        $this->session->set_flashdata('message', lang('frontend_repair_added'));
        redirect('welcome/repair');
    }


    public function import()
    {
        $DB1 = $this->load->database('master', TRUE);
        


        $orders = $DB1->get('orders');
        $repairs = [];
        foreach ($orders->result() as $order) {
            

            $date_of_purchase = false;
            if ($order->zakupeno_na !== '') {
                $dop = $order->zakupeno_na;
                $dop = explode('.', $dop);
                if (count($dop) > 2) {
                    $date_of_purchase = $dop[2].'-'.$dop[1].'-'.$dop[0];
                }
            }

            $client_date = false;
            if ($order->data_pol !== '') {
                $cd = $order->data_pol;
                $cd = explode('.', $cd);
                if (count($cd) > 2) {
                    $client_date = $cd[2].'-'.$cd[1].'-'.$cd[0];
                }
            }


            $repairs[] = [
                'id' => $order->uid,
                'client_id' => $order->klient_id,
                'date_opening' => $order->data,
                'date_closing' => $order->data_izd,
                'code' => $order->rkod,
                'manufacturer' => $order->marka,
                'repair_type' => $order->produkt,
                'category' => $order->kategoria,
                'model_id' => null,
                'name' => $this->settings_model->getClientByID($order->klient_id) ? $this->settings_model->getClientByID($order->klient_id)->name : '',
                'telephone' => $this->settings_model->getClientByID($order->klient_id) ? $this->settings_model->getClientByID($order->klient_id)->telephone : '',
                'model_name' => $order->model,
                'imei' => $order->serien_nomer,
                'date_of_purchase' => $date_of_purchase,
                'accessories' => $order->aksesoari,
                'defect' => $order->defekt,
                'comment' => $order->zab,
                'total' => $order->materiali,
                'service_charges' => $order->trud,
                'grand_total' => $order->obshto,
                'status' => (int)$order->status_remont>0 ? $order->status_remont : 1, 
                'created_by' => 1,
                'assigned_to' => 1,
                'paid' => $order->obshto,
                'payment_status' => 'paid',
                'warranty' => '0',
                'has_warranty' => $order->tip_remont,
                'client_date' => $client_date,
                

            ];
        }
        $this->db->insert_batch('reparation', $repairs);

    }
}
