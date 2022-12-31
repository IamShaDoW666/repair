<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Misc extends MY_Controller
{

    function __construct() {
        parent::__construct();
    }

    public function index() {
        show_404();
    }

    function barcode($product_code = NULL, $bcs = 'code128', $height = 40, $text = true, $encoded = false) {
        $product_code = $encoded ? $this->repairer->base64url_decode($product_code) : $product_code;
        if ($this->mSettings->barcode_img) {
            header('Content-Type: image/png');
        } else {
            header('Content-type: image/svg+xml');
        }
        echo ($this->repairer->barcode($product_code, $bcs, $height, $text, true, false));
    }


    public function check_repair_signature() {
        $id = $this->input->post('id');
        $q = $this->db->get_where('reparation', array('id'=>$id));
        
        if ($q->num_rows() > 0) {
            if ($q->row()->repair_sign) {
                echo $this->repairer->send_json(array('exists'=>true, 'name'=>$q->row()->repair_sign));
            }
        }
        echo $this->repairer->send_json(array('exists'=>false));
    }

    
    public function save_repair_signature() {
        $id = $this->input->post('id');
        $data = $this->input->post('data');
        $name = $id.'__'.time().'.png';
        $this->repairer->base30_to_jpeg($data, FCPATH.'assets/uploads/signs/repair_'.$name);
        $this->db->where('id', $id);
        $this->db->update('reparation', array('repair_sign' => $name));
        echo "true";
    }


     public function save_invoice_signature() {
        $id = $this->input->post('id');
        $data = $this->input->post('data');
        $name = $id.'__'.time().'.png';
        $this->repairer->base30_to_jpeg($data, FCPATH.'assets/uploads/signs/invoice_'.$name);
        $this->db->where('id', $id);
        $this->db->update('reparation', array('invoice_sign' => $name));
        echo "true";
    }

      public function check_invoice_signature() {
        $id = $this->input->post('id');
        $q = $this->db->get_where('reparation', array('id'=>$id));
        
        if ($q->num_rows() > 0) {
            if ($q->row()->invoice_sign) {
                echo $this->repairer->send_json(array('exists'=>true, 'name'=>$q->row()->invoice_sign));
            }
        }
        echo $this->repairer->send_json(array('exists'=>false));
    }
    function qrcode($product_code = NULL) {
        echo $this->repairer->qrcode('text', $product_code);
    }

    
    public function state_save() {
        $state = $this->input->post('state');
        $table = $this->input->post('table');
        $user_id = $this->mUser->id;

        $q = $this->db->where('table_name', $table)->where('user_id', $user_id)->get('table_states');
        if ($q->num_rows() > 0) {
            $this->db
                ->where('table_name', $table)
                ->where('user_id', $user_id)
                ->update('table_states', array('state'=>$state));
        }else{
            $data = array(
                'state' => $state,
                'table_name' => $table,
                'user_id' => $user_id,
            );
            $this->db->insert('table_states', $data);
        }
    }

    public function load_state() {
        $table = $this->input->get('table');
        $user_id = $this->mUser->id;
        $q = $this->db->where('table_name', $table)->where('user_id', $user_id)->get('table_states');
        if ($q->num_rows() > 0) {
            header('Content-Type: application/json');
            echo $q->row()->state;
        }else{
            $this->repairer->send_json(array('success'=>false));
        }
    }



    public function css($name = 'head') {
        header("Content-Type: text/css");
        $this->render('inline/css/' . $name, 'file');
    }

    public function js($name = 'variables') {
        switch ($name) {
            case 'dashboard':
                $this->load->model('reports_model');
                $this->data['list'] = $this->reports_model->list_earnings(date('m'), date('Y'));
        		$this->data['stock'] = $this->reports_model->getStockValue();

                break;
            case 'stock':
                $this->load->model('reports_model');
                $this->data['stock'] = $this->reports_model ->getStockValue();
                break;
            default:
                # code...
                break;
        }
        header("Content-Type: application/javascript");
        $this->render('inline/js/' . $name, 'file');
    }


}
