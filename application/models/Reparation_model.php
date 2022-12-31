<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reparation_model extends CI_Model
{
        
	public function __construct()
    {
        parent::__construct();
        $this->load->model('settings_model');
    }

   
    public function email_message($to, $subject,$text, $name = '', $model = '', $code = '', $id = '')
    {
        $settings = $this->settings_model->getSettings();

        $search  = array('%businessname%', '%customer%', '%model%', '%site_url%', '%statuscode%', '%businesscontact%', '%id%');
        $replace = array($settings->title, $name, $model, site_url(), $code, $settings->phone,  $id);
        $text = str_replace($search, $replace, $text);

        return $this->repairer->send_email($to, $subject, $text, $settings->invoice_mail, $settings->title);
    }


    public function getAllClients()
    {
        $q = $this->db->get('clients');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
    public function getAllReparationItems($id)
    {
        $q = $this->db->get_where('reparation_items', array('reparation_id' => $id));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
    private function getBalanceQuantity($product_id) {
        $this->db->select('SUM(COALESCE(quantity, 0)) as stock', False);
        $this->db->where('product_id', $product_id)->where('quantity !=', 0);
        $q = $this->db->get('reparation_items');
        if ($q->num_rows() > 0) {
            $data = $q->row();
            return $data->stock;
        }
        return 0;
    }
    public function getProdQty($product_id) {
        $this->db->select('SUM(COALESCE(quantity, 0)) as stock', False);
        $this->db->where('id', $product_id)->where('quantity !=', 0);
        $q = $this->db->get('inventory');
        if ($q->num_rows() > 0) {
            $data = $q->row();
            return $data->stock;
        }
        return 0;
    }
    
    public function isNotService($product_id) {
        $this->db->select('type', False);
        $this->db->where('id', $product_id);
        $q = $this->db->get('inventory');
        if ($q->num_rows() > 0) {
            $data = $q->row();
            if ($data->type !== 'service') {
                return true;
            }else{
                return false;
            }
        }
        return 0;
    }
    
    public function syncProductQty($product_id, $num) {
        if ($this->db->update('inventory', array('quantity' => $num), array('id' => $product_id))) {
            return TRUE;
        }
    }
    public function getAllModels()
    {
        $q = $this->db->where('parent_id !=', 0)->get('models');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getClientNameByID($id)
    {
        $q = $this->db->get_where('clients', array('id' => $id));
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
    public function id_from_name($name)
    {
        $value = $this->db->escape_like_str($name);

        $data = array();

        $this->db->from('clients');
        $this->db->where("CONCAT(name, ' ', company) LIKE '%".$value."%'", null, false);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data = $query->row_array();
            return $data['id'];
        } else {
            return false;
        }
    }
    public function getModelNameByID($id)
    {
        $q = $this->db->get_where('models', array('id' => $id));
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
    
	public function add_reparation($data, $items, $attachments) {
        $status_text = $this->input->post('status_text');
        unset($data['status_text']);

        $this->db->insert('reparation', $data);
        $id = $this->db->insert_id();
        $i = sizeof($items);
        if ($id && ($i > 0)) {
            for ($r = 0; $r < $i; $r++) {
                $items[$r]['reparation_id'] = $id;
            }
            $this->db->insert_batch('reparation_items', $items);
            for ($r = 0; $r < $i; $r++) {
                if ($this->isNotService($items[$r]['product_id']) && substr($items[0]['product_id'], 0, 6) !== 'manual') {
                    $num = $this->getProdQty($items[$r]['product_id']) - $items[$r]['quantity'];
                    $this->syncProductQty($items[$r]['product_id'], $num);
                }
            }
        }




        if ($attachments) {
            $attachments = explode(',', $attachments);
            $this->db
                ->where_in('id', $attachments)
                ->update('attachments', array('reparation_id'=>$id));
        }

        $this->syncRepairPayments($id);
        
        $sms_result = $this->change_status($id, $data['status'], $status_text);

        $this->settings_model->addLog('add', 'reparation', $id, json_encode(array(
            'repair_data'=>$data,
            'repair_items'=>$items,
            'attachments'=>$attachments,
            'notification_result'=>$sms_result,
        )));

        $array = array();
        $array['id'] = $id;
        return $array;
    }

    public function edit_reparation($id, $data, $items) {
        $reparation = $this->findReparationByID($id);


        $status_text = $this->input->post('status_text');
        unset($data['status_text']);

        $this->db->where('id', $id);
        $this->db->update('reparation', $data);
        $pitems = $this->reparation_model->getAllReparationItems($id);
        $this->db->where('reparation_id', $id);
        if ($this->db->delete('reparation_items')) {
            $i = $pitems ? sizeof($pitems) : 0;
            if ($pitems && $i > 0) {
                for ($r = 0; $r < $i; $r++) {
                    if ($this->isNotService($pitems[$r]->product_id)) {
                        $qty = $pitems[$r]->quantity;
                        $num = $this->getProdQty($pitems[$r]->product_id) + $qty;
                        $this->syncProductQty($pitems[$r]->product_id, $num);
                    }
                }
            }
            $i = sizeof($items);
            if ($id && ($i > 0)) {
                $this->db->insert_batch('reparation_items', $items);
                for ($r = 0; $r < $i; $r++) {
                    if ($this->isNotService($items[$r]['product_id']) && substr($items[0]['product_id'], 0, 6) !== 'manual') {
                        $num = $this->getProdQty($items[$r]['product_id']) - $items[$r]['quantity'];
                        $this->syncProductQty($items[$r]['product_id'], $num);
                    }
                }
            }
        }




        $change_status = $this->change_status($id, $data['status'], $status_text, $reparation['status']);
        $this->settings_model->addLog('update', 'reparation', $id, json_encode(array(
            'repair_data'=>$data,
            'repair_items'=>$items,
            'notification_result'=>$change_status,
        )));

        $this->syncRepairPayments($id);
        return true;

    }
     
    public function getRepairStatuses($reparation_id)
    {

        $data = [];
        $q1 = $this->db
            ->select('date, CONCAT(users.first_name, " ",users.last_name) as updated_by_name, log') 
            ->order_by('date', 'DESC')
            ->join('users', 'users.id=log.updated_by', 'left')
            ->where('reparation_id', $reparation_id)
            ->get('log');
        if ($q1->num_rows() > 0) {
            foreach (($q1->result()) as $row) {
                $data[] = $row;
            }

        }

        $q = $this->db
            ->select('reparation_status.*, CONCAT(users.first_name, " ", users.last_name) as updated_by_name, users.image as image')
            ->order_by('date', 'DESC')
            ->where('reparation_id', $reparation_id)
            ->join('users', 'users.id=reparation_status.updated_by', 'left')
            ->get("reparation_status");
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
        }


        usort($data, function($a, $b) {
          return new DateTime($a->date) <=> new DateTime($b->date);
        });


       

        return $data;
    }



    public function getTotalofRepairs($complete = 0)
    {
        $q = $this->db
            ->select('SUM(reparation.grand_total) as total')
            ->where('status.completed', $complete)
            ->join('status', 'status.id=reparation.status', 'left')
            ->get("reparation");
        if ($q->num_rows() > 0) {
            return $q->row()->total ?? 0;
        }
        return 0;
    }


    public function getReparationByID($id) {
        $this->db->where('reparation.id', $id);
        $q = $this->db
                ->select('reparation.*, status.label as status_name, status.position as status_position, status.bg_color as bg_color, status.fg_color as fg_color')
                ->join('status', 'status.id = reparation.status', 'left')
                ->get('reparation');

        $data = array();
        $items = array();
        if ($q->num_rows() > 0) {
            $data = $q->row_array();
            $q = $this->db->get_where('reparation_items', array('reparation_id' => $id));
            foreach (($q->result()) as $row) {
                $items[$row->id]['id'] = $row->product_id;
                $items[$row->id]['code'] = $row->product_code;
                $items[$row->id]['name'] = $row->product_name;
                $items[$row->id]['qty'] = $row->quantity;
                $items[$row->id]['price'] = $row->unit_price;
            }
            $data['items'] = $items;
            $data['next_status'] = $this->getNextStatusByID($data['status']);
            $data['timeline'] = $this->getRepairStatuses($id);
            return $data;
        }

        return false;
    }


    public function getReparationByIMEI($imei) {
        $this->db->where('imei', $imei);
        $q = $this->db->select('*')
                ->get('reparation');

        $data = array();
        $items = array();
        if ($q->num_rows() > 0) {
            $data = $q->row_array();
            return $data;
        }
        return false;
    }

    public function getNextStatusByID($id) {
        $this->db->where('id > ', $id);
        $q = $this->db
                ->limit(1)
                ->order_by('position', 'ASC')
                ->select('*')
                ->get('status');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }


    public function isCompletedStatus($id) {
        $this->db->where('id', $id);
        $q = $this->db->get('status');
        if ($q->num_rows() > 0) {
            return $q->row()->completed ? true : false;
        }
        return false;
    }

    /*
    |--------------------------------------------------------------------------
    | Change THE ORDER STATUS
    | @param Order ID
    |--------------------------------------------------------------------------
    */
    public function change_status($id, $to_status, $status_text = '', $old_status = null) {
        $sms_result = FALSE;
        $email_result = FALSE;

        if ($to_status < 1) {
            $this->db->update('reparation', array('status' => 'cancelled'), array('id'=>$id)); 
            $returnData = array();
            $returnData['sms_sent'] = $sms_result;
            $returnData['email_sent'] = $email_result;
            $returnData['label'] = 'Cancelled';
            return $returnData;
        }

        $reparation = $this->findReparationByID($id);

        if($old_status && $old_status == $to_status) {
            return false;
        }else{
            $status_Data = $this->settings_model->getStatusByID($to_status);
            if ($reparation['sms'] && $status_Data->send_sms) {
                $client_details = $this->reparation_model->getClientNameByID($reparation['client_id']);
                $telephone = $client_details ? $client_details->telephone : $reparation['telephone'];
                $msg = $status_Data->sms_text;
                $sms_result = $this->send_sms($telephone, $msg, $reparation['name'], $reparation['model_name'], $reparation['code'], $id);
            }

            if ($reparation['email'] && $status_Data->send_email) {
                $email = $status_Data->email_text;
                $subject = sprintf(lang('status_change_email_subject'), $status_Data->label);
                if ($status_Data->email_subject !== '') {
                    $subject = sprintf($status_Data->email_subject, $status_Data->label);
                }
                $client_details = $this->reparation_model->getClientNameByID($reparation['client_id']);
                $email_result = $this->email_message($client_details->email, $subject, $email, $reparation['name'], $reparation['model_name'], $reparation['code'], $id);
            }


            $data = array(
                'status' => $status_Data->id,
            );
            if ($this->isCompletedStatus($status_Data->id)) {
                $data['date_closing'] = date('Y-m-d H:i:s');
                $data['client_date'] = date('Y-m-d');
                
            }else{
                $data['date_closing'] = null;
                $data['date_closing'] = null;
            }

            $this->db->update('reparation', $data, array('id'=>$id)); 



            $status = [
                'reparation_id' => $id,
                'status_id' => $data['status'],
                'label' => $status_Data ? $status_Data->label : '',
                'updated_by' => $this->session->userdata( 'user_id' ),
                'description' => $status_text,
                'date' => date('Y-m-d H:i:s'),
            ];
            $this->db->insert('reparation_status', $status);


            $returnData = array();
            $returnData['sms_sent'] = $sms_result;
            $returnData['email_sent'] = $email_result;
            $returnData['label'] = $status_Data->label;
            return $returnData;

        }

    }


    /*
    |--------------------------------------------------------------------------
    | FIND ORDER/REPARATION
    | @param The ID
    |--------------------------------------------------------------------------
    */
    public function findReparationByID($id)
    {
        $data = array();
        $query = $this->db->get_where('reparation', array('id' => $id));
        if ($query->num_rows() > 0) {
            $data = $query->row_array();
        }

        return $data;
    }


    public function getRepairByID($id)
    {
        $data = array();
        $query = $this->db->get_where('reparation', array('id' => $id));
        if ($query->num_rows() > 0) {
            $data = $query->row();
        }

        return $data;
    }


    /*
    |--------------------------------------------------------------------------
    | SEND THE SMS TO CUSTOMER
    |--------------------------------------------------------------------------
    */
    public function send_sms($number, $text, $name = '', $model = '', $code = '', $id = '')
    {
        

        if (strpos($number, '+') == false) {
            $number = '+'.$number;
        }

        $settings = $this->settings_model->getSettings();
        $search  = array('%businessname%', '%customer%', '%model%', '%site_url%', '%statuscode%', '%id%');
        $replace = array($settings->title, $name, $model, site_url(), $code, $id);
        $text = str_replace($search, $replace, $text);

        if($settings->usesms == 1) {
            try {
                // IF THAT IS NEXMO //
               $client = new Vonage\Client(
                   new Vonage\Client\Credentials\Basic($settings->nexmo_api_key, $settings->nexmo_api_secret),
               );
               $text = new \Vonage\SMS\Message\SMS($number, $settings->nexmo_number, $text);
               $text->setClientRef('test-message');
               $response = $client->sms()->send($text);
               if($response->current()->getMessageID()) {
                   $success = true;
               }else{
                   $success = FALSE;
               }
           } catch (Exception $e) {
               $success = FALSE;
               $msg = $e->getMessage();
           }
        } elseif($settings->usesms == 2) {

            try {
                
                $client = new Twilio\Rest\Client($settings->twilio_account_sid, $settings->twilio_auth_token);
                $message = $client->messages->create(
                    $number,
                    array(
                        'from' => $settings->twilio_number,
                        'body' => $text,
                    )
                );
            } catch (Exception $e) {
                return $e->getMessage();
            }
            if($message->sid){
                return TRUE;
            }
        } elseif($settings->usesms == 3) {

            $array_fields['phone_number'] = $number;
            $array_fields['message'] = $text;
            $array_fields['device_id'] = $settings->smsgateway_device_id;

            $token = $settings->smsgateway_token;

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://smsgateway.me/api/v4/message/send",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "[  " . json_encode($array_fields) . "]",
                CURLOPT_HTTPHEADER => array(
                    "authorization: $token",
                    "cache-control: no-cache"
                ),
            ));
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                return TRUE;
            } else {
                return FALSE;
            }

        } elseif($settings->usesms == 5) {
            // IF THAT IS MessageBird //
            try {
                $MessageBird = new \MessageBird\Client($settings->message_bird_access_key);
                $Message = new \MessageBird\Objects\Message();
                $Message->originator = 'TestMessage';
                $Message->recipients = array($number);
                $Message->body = $text;

                $result = $MessageBird->messages->create($Message);
                return true;
            } catch (Exception $e) {
                return FALSE;
            }

        } else {
            $api = $this->settings_model->getSMSGatewayByID($settings->default_http_api);
            if ($api) {
                $append = "?";
                $append .= $api->to_name . "=" . urlencode($number);
                $append .= "&" . $api->message_name . "=" . urlencode($text);

                $postdata = [];
                try {
                    $postdata = @json_decode($api->postdata);
                } catch (Exception $e) {
                    
                }
                foreach ($postdata as $key => $value) {
                    $append .= "&" . $key . "=" . urlencode($value);
                }

                $url = $api->url . $append;


                //send sms here
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_ENCODING, "");
                curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
                curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                $curl_scraped_page = curl_exec($ch);
                curl_close($ch);
                return true;

            }
            return false;
        }
    }

    public function getStatusNameByID($id)
    {
        $q = $this->db->get_where('status', array('id'=>$id));
        if ($q->num_rows() > 0) {
            return $q->row()->label;
        }
        return '';
    }
    public function getTaxLabelByID($id)
    {
        $q = $this->db->get_where('tax_rates', array('id'=>$id));
        if ($q->num_rows() > 0) {
            return $q->row()->name;
        }
        return '';
    }


     public function getAllReparations()
    {
        $q = $this->db
            ->select('reparation.*, status.id as status_id, fg_color, bg_color')
            ->join('status', 'status.id=reparation.status', 'left')
            ->get('reparation');
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }




    public function getPendingPayments($reparation_id)
    {
        $q = $this->db->where('reparation_id', $reparation_id)->select('SUM(amount) as total')->where('approved', 0)->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row()->total ? $q->row()->total : 0;
        }
        return 0;
    }

    
    public function getRepairPayments($reparation_id)
    {
        $q = $this->db->get_where("payments", array('reparation_id' => $reparation_id));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }

            return $data;
        }
        return FALSE;
    }
    public function syncRepairPayments($id) {
        $sale = $this->getRepairByID($id);
        if ($payments = $this->getRepairPayments($id)) {
            $paid = 0;
            $grand_total = $sale->grand_total;
            foreach ($payments as $payment) {
                $paid += $payment->amount;
            }
            
            $payment_status = $paid == 0 ? 'pending' : $sale->payment_status;
            if ($this->repairer->formatDecimal($grand_total) == $this->repairer->formatDecimal($paid)) {
                $payment_status = 'paid';
            } elseif ($paid != 0) {
                $payment_status = 'partial';
            }

            if ($this->db->update('reparation', array('paid' => $paid, 'payment_status' => $payment_status), array('id' => $id))) {
                return true;
            }
        } else {
            $payment_status = 'pending';
            if ($this->db->update('reparation', array('paid' => 0, 'payment_status' => $payment_status), array('id' => $id))) {
                return true;
            }
        }
        return FALSE;
    }

    public function getPaymentByID($id)
    {
        $q = $this->db->get_where('payments', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getPaymentByReparationID($id)
    {
        $q = $this->db->get_where('payments', array('reparation_id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getPaymentsByReparationID($id) {
        $q = $this->db->get_where('payments', array('reparation_id' => $id));
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return FALSE;
    }

    
    public function deletePayment($id)
    {
        $opay = $this->getPaymentByID($id);
        if ($this->db->delete('payments', array('id' => $id))) {
            $repair = $this->getReparationByID($data['reparation_id']);
            $this->syncRepairPayments($opay->reparation_id);
            $this->settings_model->addLog('delete-payment', 'reparation', $opay->reparation_id, json_encode(array(
                'data'=>$repair,
            )));
            return true;
        }
        return FALSE;
    }

    public function addPayment($data = array())
    {
        unset($data['cc_cvv2']);
        if ($this->db->insert('payments', $data)) {
            $payment_id = $this->db->insert_id();
            $repair = $this->getReparationByID($data['reparation_id']);
            if ($this->repairer->getReference('pay') == $data['reference_no']) {
                $this->repairer->updateReference('pay');
            }
            $this->syncRepairPayments($data['reparation_id']);

            $this->settings_model->addLog('add-payment', 'reparation', $data['reparation_id'], json_encode(array(
                'data'=>$repair,
            )));

            return true;
        }
        return false;
    }

    public function updatePayment($id, $data = array())
    {
        $opay = $this->getPaymentByID($id);
        if ($this->db->update('payments', $data, array('id' => $id))) {
            $repair = $this->getReparationByID($data['reparation_id']);
            $this->syncRepairPayments($data['reparation_id']);

            $this->settings_model->addLog('update-payment', 'reparation', $data['reparation_id'], json_encode(array(
                'data'=>$repair,
            )));

            return true;
        }
        return false;
    }
}
