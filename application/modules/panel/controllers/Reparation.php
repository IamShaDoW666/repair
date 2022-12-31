<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * Customers
 *
 *
 * @package     Reparer
 * @category    Controller
 * @author      Usman Sher
*/

class Reparation extends Auth_Controller
{
    // THE CONSTRUCTOR //
    public function __construct()
    {
        parent::__construct();
        $this->load->model('reparation_model');
    }
    
    public function index()
    {
        $this->mPageTitle = lang('reparation');


        $this->data['pending_total'] = $this->reparation_model->getTotalofRepairs();
        $this->data['completed_total'] = $this->reparation_model->getTotalofRepairs(1);

        $this->repairer->checkPermissions('index', NULL, 'repair');
       
        $this->render('reparation/index');
    }


  

    // GENERATE THE AJAX TABLE CONTENT //
    public function getAllReparations($client_id = null)
    {

        $this->repairer->checkPermissions('index', NULL, 'repair');
        $this->load->library('datatables');
        
        $completed_status = $this->settings_model->getActiveStatuses(1);
        $active_status = $this->settings_model->getActiveStatuses(0);

        $completed = $this->input->post('completed');



        $has_warranty = $this->input->post('has_warranty');
        $manufacturer = $this->input->post('manufacturer');
        $client_id_ = $this->input->post('client_id');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $status = $this->input->post('status');
        $model = $this->input->post('model');
        $imei = $this->input->post('imei');


        if ($has_warranty) {
            $this->datatables->where('has_warranty', $has_warranty);
        }

        if ($manufacturer) {
            $this->datatables->where('manufacturer', $manufacturer);
        }

        if ($client_id_) {
            $this->datatables->where('client_id', $client_id_);
        }


        if ($model) {
            $this->datatables->where('model_name', $model);
        }

        if ($imei) {
            $this->datatables->like('imei', $imei);
        }

        if ($start_date && $end_date) {
            $this->datatables->where('DATE(date_opening) >=', $start_date);
            $this->datatables->where('DATE(date_opening) <=', $end_date);
        }



        
        // DATE OF REGISTRATION,NAME,TELEPHONE,MODEL,MANIFACTURER,WARRANTY, WARRANTY CARD NUMBER,DATE OF PURCHASE, SPARE PART USED,



        if ($client_id) {
            $this->datatables->where('client_id', $client_id);
            $this->datatables
            ->select('reparation.id as id, CONCAT(reparation.id, "___", code), reparation.imei as imei, defect, model_name, date_opening, if(status > 0, CONCAT(status.label, "____", status.bg_color, "____", status.fg_color, "____", status.id, "____" ,reparation.id), "cancelled") as status, a.first_name, (SELECT CONCAT(first_name, " ", last_name) FROM users WHERE reparation.updated_by = users.id) as modified_by, grand_total')
            ->join('status', 'status.id=reparation.status', 'left')
            ->join('users a', 'a.id=reparation.created_by', 'left')
            ->from('reparation');
            $this->datatables->unset_column('id');

        }else{

            if ($status) { 
                $this->datatables->where('reparation.status', $status);
            }else{
                if ($completed) {
                    if(!empty($completed_status))
                        $this->datatables->where_in('status', $completed_status);
                }else{
                    if(!empty($active_status))
                        $this->datatables->where_in('status', $active_status);
                }
            }
            
            
            $this->datatables
                ->select('reparation.id as id, reparation.code as code, CONCAT(client_id, "___", reparation.name) as cname, reparation.imei as imei, reparation.telephone, defect, manufacturer, model_name, date_opening, date_closing, if(status > 0, CONCAT(status.label, "____", status.bg_color, "____", status.fg_color, "____", status.id, "____" ,reparation.id), "cancelled") as status, CONCAT(b.first_name, " ", b.last_name) as assigned, a.first_name, (SELECT CONCAT(first_name, " ", last_name) FROM users WHERE reparation.updated_by = users.id) as modified_by, (SELECT COUNT(attachments.id) FROM attachments WHERE reparation_id=reparation.id) as attached, grand_total, ( SELECT GROUP_CONCAT(CONCAT(payments.paid_by, "____", payments.amount)) FROM payments where payments.reparation_id = reparation.id) as payments,"actions" as actions, warranty, clients.email as email')
                ->join('status', 'status.id=reparation.status', 'left')
                ->join('users a', 'a.id=reparation.created_by', 'left')
                ->join('users b', 'b.id=reparation.assigned_to', 'left')
                ->join('clients', 'clients.id=reparation.client_id', 'left')
                ->from('reparation');

            $actions = '<div class="text-center"><div class="dropleft">'
                . '<button data-boundary="viewport"  type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                . ('actions') . ' <span class="caret"></span></button>
            
            <ul class="dropdown-menu " role="menu">';
            if ($this->Admin || $this->GP['repair-view_repair']) {
                $actions .= "<a data-dismiss='modal' class='view dropdown-item' href='#view_reparation' data-toggle='modal' data-num='$1'><i class='fas fa-check'></i> ".lang('view_reparation')."</a>"; 
            }


            if ($this->Admin || $this->GP['repair-edit']) {
                $actions .= "<a class='dropdown-item' data-dismiss='modal' id='modify_reparation' href='#reparationmodal' data-toggle='modal' data-num='$1'><i class='fas fa-edit'></i> ".lang('edit_reparation')."</a>"; 
            }
            $actions .= "". anchor('panel/reparation/payments/$1', '<i class="fas fa-money-bill-alt"></i> ' . lang('view_payments'), 'data-toggle="modal" data-target="#myModal" class="dropdown-item"') . '';
            $actions .= "". anchor('panel/reparation/add_payment/$1', '<i class="fas fa-money-bill-alt"></i> ' . lang('add_payment'), 'data-toggle="modal" data-target="#myModal" class="dropdown-item"') . '';

            if ($this->Admin || $this->GP['repair-view_repair']) {
                $actions .= "<a class='dropdown-item' target='_blank' href=\"".base_url()."panel/reparation/invoice/$1/1/\"><i class=\"fas fa-print\"></i> ".lang('invoice')."</a>"; 
                $actions .= "<a class='dropdown-item' id=\"upload_modal_btn\" data-mode=\"edit\" data-num=\"$1\"><i class=\"fas fa-cloud\"></i> ".lang('view_attached')."</a>"; 
            }

            $actions .= "<a class='dropdown-item' data-dismiss='modal' data-num='$1' data-email='$2' id='email_invoice'><i class='fas fa-envelope'></i> ".lang('email_invoice')."</a>"; 

            if ($this->Admin || $this->GP['repair-delete']) {
                $actions .= "<a class='dropdown-item' id='delete_reparation' data-num='$1'><i class='fas fa-trash-alt'></i> ".lang('delete_reparation')."</a>"; 
            }

            $actions .= '<a class="dropdown-item" href="'.base_url().'/panel/reparation/print_barcodes/$1"><i class="fas fa-print"></i> '.lang('print_barcode').'</a>'; 

            $actions .= '</ul></div>';
            $this->datatables->edit_column('actions', $actions, 'id, email');
            $this->datatables->unset_column('email');

        }

        echo $this->datatables->generate();
    }
    public function add(){
        $this->repairer->checkPermissions('add', NULL, 'repair');
        $this->load->model('inventory_model');



        $custom_fields = explode(',', $this->mSettings->custom_fields);
        $custom_toggles = explode(',', $this->mSettings->repair_custom_toggles);
        $cust = array();
        $custtoggles = array();
        foreach ($_POST as $key => $var) {
            if (substr($key, 0, 7) === 'custom_' ) {
                $cust[(substr($key, 7))] = $var;
            }
            if (substr($key, 0, 12) === 'checktoggle_' ) {
                $custtoggles[(substr($key, 12))] = $var;
            }
        }
        $cust = (json_encode($cust));
        $custtoggles = (json_encode($custtoggles));

        $client_details = $this->reparation_model->getClientNameByID($this->input->post('client_name'));
        $model = $this->inventory_model->getModelByName($this->input->post('model'));
        $data = array(
            'client_id' => $this->input->post('client_name'),
            'name' => $client_details->name,
            'telephone' => $client_details->telephone,
            'defect' => $this->input->post('defect'),
            'category' => $this->input->post('category') ?? '',
            'diagnostics' => $this->input->post('diagnostics'),
            'model_id' => $model ? $model->id : NULL,
            'model_name' => $this->input->post('model'),
            'manufacturer' => $this->input->post('manufacturer'),
            'assigned_to' => $this->input->post('assigned_to'),
            'advance' => $this->input->post('advance') ? $this->input->post('advance') : '',
            'date_opening' => date('Y-m-d H:i:s'),
            'service_charges' => $this->input->post('service_charges') > 0 ? $this->input->post('service_charges') : 0,
            'comment' => $this->input->post('comment'),
            'status' => $this->input->post('status'),
            'code' => $this->input->post('code'),
            'email' => $this->input->post('email') == 'true' ? TRUE : FALSE,
            'sms' => $this->input->post('sms') == 'true' ? TRUE : FALSE,
            'custom_field' => $cust,
            'created_by' => $this->ion_auth->get_user_id(),
            'tax_id' => $this->input->post('order_tax'),
            'imei' => $this->input->post('imei') ? $this->input->post('imei') : '',
            'expected_close_date' =>$this->input->post('expected_close_date') ? $this->repairer->fsd(trim($this->input->post('expected_close_date'))) : null,
            //Pre Repair Checklist
            'custom_toggles' => $custtoggles,
            'pin_code' => $this->input->post('cust_pin_code'),
            'pattern' => $this->input->post('patternlock'),
            'warranty'            => $this->input->post('warranty') ? $this->input->post('warranty') : '0',

            'order_discount' => $this->input->post('order_discount'),

            'has_warranty' => $this->input->post('has_warranty') ? $this->input->post('has_warranty') : 0,
            'repair_type' => $this->input->post('repair_type'),
            'warranty_card_number' => $this->input->post('warranty_card_number') ?? '',
            'date_of_purchase' => $this->input->post('date_of_purchase') ? $this->repairer->fsd(trim($this->input->post('date_of_purchase'))) : null,
            'accessories' => $this->input->post('accessories'),
            'status_text' => $this->input->post('status_text'),
            'client_date' => $this->input->post('client_date') ? $this->repairer->fsd(trim($this->input->post('client_date'))) : null,
            'error_code' => $this->input->post('error_code'),
            
        );

      


        $tax_rate = $this->settings_model->getTaxRateByID($this->input->post('order_tax'));

        
        if ($_POST['code'] == null) {
            $data['code'] = time();
        }
        $products = array(); 
        $subtotal = 0;
        $total_tax = 0;
        $total = 0;
        $gtotal = 0;

        if (isset($_POST['item_id']) && $_POST['item_id'] !== null) {
            $i = sizeof($_POST['item_id']);
            for ($r = 0; $r < $i; $r++) {
                $item_id = $_POST['item_id'][$r];
                $item_name = $_POST['item_name'][$r];
                $item_code = $_POST['item_code'][$r];
                $item_quantity = $_POST['item_quantity'][$r];
                $item_price = $_POST['item_price'][$r];
                $products[] = array(
                    'product_id' => $item_id,
                    'product_name' => $item_name,
                    'product_code' => $item_code,
                    'quantity' => $item_quantity,
                    'unit_price' => $item_price,
                    'subtotal' => $item_price * $item_quantity,
                );
                $subtotal += $item_price * $item_quantity;
            }
        }

        $total += $subtotal;
        $total += (float) $this->input->post('service_charges');


        $invoice_tax = 0;
        if ($tax_rate) {
            if ($tax_rate->type == 2) {
                $invoice_tax = ($tax_rate->rate);
            }
            if ($tax_rate->type == 1) {
                $invoice_tax = ((($total) * $tax_rate->rate) / 100);
            }
        }
        
        $total_tax += $invoice_tax;
        $gtotal = + $total + $total_tax;
        $data['tax'] = $total_tax;
        $data['total'] = $total;


        $total_discount = 0;
        $order_discount = $this->input->post('order_discount');
        if ((int)$order_discount > 0) {
            $total_discount = $order_discount;
        }
        $data['grand_total'] = $gtotal - $total_discount;


        $attachment_data = $this->input->post('attachment_data') ? $this->input->post('attachment_data') : NULL;
        $result = $this->reparation_model->add_reparation($data, $products, $attachment_data);
        $repair_id = $result['id'];


       


        if ($this->input->post('sign_id')) {
            $data = $this->input->post('sign_id');
            $name = $repair_id.'__'.time().'.png';
            $this->repairer->base30_to_jpeg($data, FCPATH.'assets/uploads/signs/repair_'.$name);
            $this->db->where('id', $repair_id);
            $this->db->update('reparation', array('repair_sign' => $name));
        }
        echo $this->repairer->send_json($result);
    }
    public function edit(){
        $this->repairer->checkPermissions('edit', NULL, 'repair');
        $this->load->model('inventory_model');

        $id = $this->input->post('id');

        $custom_fields = explode(',', $this->mSettings->custom_fields);
        $custom_toggles = explode(',', $this->mSettings->repair_custom_toggles);
        $cust = array();
        $custtoggles = array();
        foreach ($_POST as $key => $var) {
            if (substr($key, 0, 7) === 'custom_' ) {
                $cust[(substr($key, 7))] = $var;
            }
            if (substr($key, 0, 12) === 'checktoggle_' ) {
                $custtoggles[(substr($key, 12))] = $var;
            }
        }
        $cust = (json_encode($cust));
        $custtoggles = (json_encode($custtoggles));
        
        $client_details = $this->reparation_model->getClientNameByID($this->input->post('client_name'));
        $model = $this->inventory_model->getModelByName($this->input->post('model'));
        $data = array(
            'client_id' => $this->input->post('client_name'),
            'name' => $client_details->name,
            'telephone' => $client_details->telephone,
            'defect' => $this->input->post('defect'),
            'diagnostics' => $this->input->post('diagnostics'),
            'category' => $this->input->post('category') ?? '',
            'model_id' => $model ?  $model->id :'',
            'model_name' => $this->input->post('model'),
            'manufacturer' => $this->input->post('manufacturer'),
            'assigned_to' => $this->input->post('assigned_to'),
            'advance' => $this->input->post('advance') ? $this->input->post('advance') : '',
            'service_charges' => $this->input->post('service_charges') > 0 ? $this->input->post('service_charges') : 0,
            'comment' => $this->input->post('comment'),
            'status' => $this->input->post('status'),
            'code' => $this->input->post('code'),
            'custom_field' => $cust,
            'updated_by' => $this->ion_auth->get_user_id(),
            'tax_id' => $this->input->post('order_tax'),
            'email' => $this->input->post('email') == 'true' ? 1 : 0,
            'sms' => $this->input->post('sms') == 'true' ? 1 : 0,
            'imei' => $this->input->post('imei') ? $this->input->post('imei') : '',
            //Pre Repair Checklist
            'custom_toggles' => $custtoggles,
            'pin_code' => $this->input->post('cust_pin_code'),
            'pattern' => $this->input->post('patternlock'),
            'warranty'  => $this->input->post('warranty') ? $this->input->post('warranty') : '0',

            'order_discount' => $this->input->post('order_discount'),
            
            'has_warranty' => $this->input->post('has_warranty') ? $this->input->post('has_warranty') : 0,
            'repair_type' => $this->input->post('repair_type'),
            'warranty_card_number' => $this->input->post('warranty_card_number') ?? '',
            'date_of_purchase' => $this->input->post('date_of_purchase'),
            'accessories' => $this->input->post('accessories'),

            'status_text' => $this->input->post('status_text'),
            'expected_close_date' =>$this->input->post('expected_close_date') ? $this->repairer->fsd(trim($this->input->post('expected_close_date'))) : null,
            'date_of_purchase' =>$this->input->post('date_of_purchase') ? $this->repairer->fsd(trim($this->input->post('date_of_purchase'))) : null,
            'client_date' =>$this->input->post('client_date') ? $this->repairer->fsd(trim($this->input->post('client_date'))) : null,

            'error_code' => $this->input->post('error_code'),

        );
        $reparation_details = $this->reparation_model->getReparationByID($id);

        $tax_rate = $this->settings_model->getTaxRateByID($this->input->post('order_tax'));
        $this->create_log($id, $data, $reparation_details);
       
        if ($_POST['code'] == null) {
            $data['code'] = time();
        }
        $products = array(); 
        $subtotal = 0;
        $total_tax = 0;
        $total = 0;
        $gtotal = 0;

        if (isset($_POST['item_id']) && $_POST['item_id'] !== null) {
            $i = sizeof($_POST['item_id']);
            for ($r = 0; $r < $i; $r++) {
                $item_id = $_POST['item_id'][$r];
                $item_name = $_POST['item_name'][$r];
                $item_code = $_POST['item_code'][$r];
                $item_quantity = $_POST['item_quantity'][$r];
                $item_price = $_POST['item_price'][$r];
                $products[] = array(
                    'product_id' => $item_id,
                    'product_name' => $item_name,
                    'product_code' => $item_code,
                    'quantity' => $item_quantity,
                    'unit_price' => $item_price,
                    'subtotal' => $item_price * $item_quantity,
                    'reparation_id' => $id,
                );
                $subtotal += $item_price * $item_quantity;
            }
        }

        $total += $subtotal;
        $total += $this->input->post('service_charges');

        $invoice_tax = 0;
        if ($tax_rate) {
            if ($tax_rate->type == 2) {
                $invoice_tax = ($tax_rate->rate);
            }
            if ($tax_rate->type == 1) {
                $invoice_tax = ((($total) * $tax_rate->rate) / 100);
            }
        }

        

        if ($this->input->post('sign_id')) {
            $data = $this->input->post('sign_id');
            $name = $id.'__'.time().'.png';
            $this->repairer->base30_to_jpeg($data, FCPATH.'assets/uploads/signs/invoice_'.$name);
            $data['invoice_sign'] = $name;
        }

        $total_tax += $invoice_tax;
        $gtotal = + $total + $total_tax;
        $data['tax'] = $total_tax;
        $data['total'] = $total;



        $total_discount = 0;
        $order_discount = $this->input->post('order_discount');
        if ((int)$order_discount > 0) {
            $total_discount = $order_discount;
        }
        $data['grand_total'] = $gtotal - $total_discount;

        $this->reparation_model->edit_reparation($id, $data, $products);




    }

    public function create_log($id, $new, $old) {
        $new['status_name'] = $this->reparation_model->getStatusNameByID($new['status']);
        $new['tax_name'] = $this->reparation_model->getTaxLabelByID($new['tax_id']);
        $old['tax_name'] = $this->reparation_model->getTaxLabelByID($old['tax_id']);

        $old['email'] = (int)$old['email'];
        $old['sms'] = (int)$old['sms'];
        $new['email'] = (int)$new['email'];
        $new['sms'] = (int)$new['sms'];

        $changes = array();
        
        if ($new['email'] !== $old['email']) {
            if ($new['email'] == 1) {
                $changes[] = lang('email_set_to_true');
            }else{
                $changes[] = lang('email_set_to_false');
            }
        }

        if ($new['sms'] !== $old['sms']) {
            if ($new['sms']) {
                $changes[] = lang('sms_set_to_true');
            }else{
                $changes[] = lang('sms_set_to_false');
            }
        }

        // Unset IDs & Numeric Values
        unset(
            $new['client_id'], 
            $new['model_id'], 
            $new['updated_by'], 
            $new['status'], 
            $new['tax_id'], 
            $new['email'], 
            $new['sms'],
            $new['custom_field'],
            $new['telephone']
        );

        foreach ($old as $key => $value) {
            foreach ($new as $_key => $_value) {
                if ($_key == $key) {
                    if ($value !== $_value) {
                        $changes[] = array($key, $value, $_value);
                    }
                }
            }
        }
        
        // Insert Log
        if (!empty($changes)) {
            $log = array(
                'updated_by' => $this->ion_auth->get_user_id(),
                'date' => date('Y-m-d H:i:s'),
                'reparation_id' => $id,
                'log' => json_encode($changes),
            );
            $this->db->insert('log', $log);
        }
        
    }
    public function delete(){
        $add_to_stock = (string)$this->input->post('add_to_stock');
        $this->repairer->checkPermissions('delete', NULL, 'repair');
        $id = $this->input->post('id');
        $repair = $this->reparation_model->getReparationByID($id);
        $this->db->where('id', $id);
        $this->db->delete('reparation');
        if ($add_to_stock == 'true') {
            $items = $this->reparation_model->getAllReparationItems($this->input->post('id'));
            $i = sizeof($items);
            for ($r = 0; $r < $i; $r++) {
                if ($this->reparation_model->isNotService($items[$r]->product_id)) {
                    $qty = $items[$r]->quantity;
                    $num = $this->reparation_model->getProdQty($items[$r]->product_id) + $qty;
                    $this->reparation_model->syncProductQty($items[$r]->product_id, $num);
                }
            }
        }
        $this->db->where('id', $this->input->post('id'));
        $this->db->delete('reparation_items');

        $this->settings_model->addLog('delete', 'reparation', $id, json_encode(array(
            'repair' => $repair,
            'items' => $items,
        )));

        echo "true";
    }

    public function getReparationByID($id = null){
        if ($id) {
            return $this->reparation_model->getReparationByID($id);
        }else{
            $id = $this->input->post('id');
            $reparation_details = $this->reparation_model->getReparationByID($id);
            echo json_encode($reparation_details); 
        }
        
    }


    public function status_toggle(){
        $id = $this->input->post('id');
        $to_status = $this->input->post('to_status');
        $result = $this->reparation_model->change_status($id, $to_status);
        echo $this->repairer->send_json(array('success'=>true, 'data'=>$result)); 
    }
    
     // SEND A SMS DIRECT //
    public function send_sms() {
        $number    = $this->input->post('number');
        $text      = $this->input->post('text', true);
        $client_id = $this->input->post('client_id', true);
        if ($client_id) {
            $client_details = $this->reparation_model->getClientNameByID($client_id);
            $result = $this->reparation_model->send_sms($client_details->telephone, $text);
            echo json_encode(array('status' => $result=='true'?TRUE:FALSE, 'data'=>$result));
        }else{
           

            $result = $this->reparation_model->send_sms($number, $text);
            echo json_encode(array('status' => $result, 'data'=>$result));
        }
    }
    // SHOW A INVOICE TEMPLATE //
    public function invoice($id,$type)
    {

        $this->data['db'] = $this->reparation_model->findReparationByID($id);
        $this->data['items'] = $this->reparation_model->getAllReparationItems($id);
        $this->data['tax_rate'] = $this->settings_model->getTaxRateByID($this->data['db']['tax_id']);
        $this->data['client'] = $this->reparation_model->getClientNameByID($this->data['db']['client_id']);
        $this->data['currency'] = $this->mSettings->currency;
        $this->data['language'] = $this->mSettings->language;
        $this->data['status'] = $this->settings_model->getStatusByID($this->data['db']['status']);
        $this->data['payments'] = $this->reparation_model->getRepairPayments($id);

        $this->data['user'] = $this->mUser;
        $this->data['two_copies'] = 0;
        $this->data['is_a4'] = 0;

        

        if($type == 1) {
            $this->settings_model->addLog('view-invoice', 'reparation', $id, json_encode(array(
                'repair' => $this->data['db'],
                'items' => $this->data['items'],
            )));
            $this->mPageTitle = lang('invoice_title');
            if (in_array($this->mSettings->invoice_template, array(1,2,3,4))) {
                $this->load->view($this->theme . 'template/invoice_template'.$this->mSettings->invoice_template, $this->data);
            }else{
                $this->load->view($this->theme . 'template/invoice_template1', $this->data);
            }
        } else {
             $this->settings_model->addLog('view-report', 'reparation', $id, json_encode(array(
                'repair' => $this->data['db'],
                'items' => $this->data['items'],
            )));
            $this->mPageTitle = lang('report');
            if (in_array($this->mSettings->report_template, array(1,2,3,4,5))) {
                $this->load->view($this->theme . 'template/report_template'.$this->mSettings->report_template, $this->data);
            }else{
                $this->load->view($this->theme . 'template/report_template1', $this->data);
            }
        };
    }

    public function upload_attachments()
    {
        // upload.php
        // 'images' refers to your file input name attribute
        if (empty($_FILES['upload_manager'])) {
            echo json_encode(['error'=>lang('upload_no_file')]); 
            // or you can throw an exception 
            return; // terminate
        }
        // get user id posted
        $reparation_id = $this->input->post('id') ? $this->input->post('id') : NULL;

        // a flag to see if everything is ok
        $success = null;

        // file paths to store
        $paths = [];

        // loop and process files
        $this->load->library('upload');
        $number_of_files_uploaded = count($_FILES['upload_manager']['name']);
        for ($i = 0; $i < $number_of_files_uploaded; $i++) {
            $_FILES['userfile']['name']     = $_FILES['upload_manager']['name'][$i];
            $_FILES['userfile']['type']     = $_FILES['upload_manager']['type'][$i];
            $_FILES['userfile']['tmp_name'] = $_FILES['upload_manager']['tmp_name'][$i];
            $_FILES['userfile']['error']    = $_FILES['upload_manager']['error'][$i];
            $_FILES['userfile']['size']     = $_FILES['upload_manager']['size'][$i];
            $config = array(
                'upload_path'   => 'files/',
                'allowed_types' => 'zip|psd|ai|rar|pdf|doc|docx|xls|xlsx|ppt|pptx|gif|jpg|jpeg|png|tif|txt',
                'max_size'      => 204800,
            );
            $this->upload->initialize($config);
            if ( ! $this->upload->do_upload('userfile')){
                $success = false;
                break;
            }else{
                $success = true;
                $paths[] = $this->upload->file_name;
            }
        }

        // check and process based on successful status 
        if ($success === true) {
            $uploaded_ids = array();
            foreach ($paths as $file) {
                $label = explode('.', $file);
                $data = array(
                    'label' => $label[0],
                    'filename' => $file,
                    'added_date' => date('Y-m-d H:i:s'),
                    'reparation_id' => $reparation_id,
                );
                $this->db->insert('attachments', $data);
                $uploaded_ids[] = $this->db->insert_id();
            }
            $output = ["success"=> true, 'data'=>json_encode($uploaded_ids)];
        } elseif ($success === false) {
            $output = ['error'=>lang('error_Contant_Admin')];
            foreach ($paths as $file) {
                unlink('files/'.$file);
            }
        } else {
            $output = ['error'=>lang('error_proccess_upload')];
        }

        echo json_encode(array_unique($output));
    }
    public function getAttachments()
    {
        $id = $this->input->post('id');
        $q = $this->db->get_where('attachments', array('reparation_id'=>$id));

        $urls = array();
        $previews = array();
        if ($q->num_rows() > 0) {
            $result = $q->result();
            foreach ($result as $row) {
                $url = base_url().'files/'.$row->filename;
                $burl = FCPATH.'files/'.$row->filename;
                if (file_exists($burl)) {
                    list($width) = getimagesize($burl);
                    $size = filesize($burl);
                    $extension = (explode('.', $row->filename));
                    $extension = $extension[count($extension) - 1];
                    if (in_array($extension, explode('|', 'doc|docx|xls|xlsx|ppt|pptx'))) {
                        $type = 'office';
                    }elseif (in_array($extension, explode('|', 'pdf'))) {
                        $type = 'pdf';

                    }elseif (in_array($extension, explode('|', 'htm|html'))) {
                        $type = 'html';
                    }elseif (in_array($extension, explode('|', 'txt|ini|csv|java|php|js|css'))) {
                        $type = 'text';
                    }elseif (in_array($extension, explode('|', 'avi|mpg|mkv|mov|mp4|3gp|webm|wmv'))) {
                        $type = 'video';
                    }elseif (in_array($extension, explode('|', 'mp3|wav'))) {
                        $type = 'audio';
                    }
                    elseif (in_array($extension, explode('|', 'doc|docx|xls|xlsx|ppt|pptx'))) {
                        $type = 'office';
                    }
                    elseif (in_array($extension, explode('|', 'png|gif|jpg|jpeg|tif'))) {
                        $type = 'image';
                    }else{
                        $type = 'other';
                    }
            
                    $previews[] = array(
                        'caption' => $row->label,
                        'filename' => $row->filename,
                        'downloadUrl' => $url,
                        'size' => $width,
                        'width' => (string)$width.'px',
                        'key'=>$row->id,
                        'filetype' => mime_content_type($burl),
                        'type'=>$type,
                    );
                    $urls[] = $url;
                }
                
            }
        }
        echo $this->repairer->send_json(array(
            'show_data' => !empty($urls) ? TRUE : FALSE,
            'previews' => $previews,
            'urls' => $urls,
        ));
    }
    public function delete_attachment()
    {
        $id = $this->input->post('key');
        $q = $this->db->get_where('attachments', array('id'=>$id));
        if ($q->num_rows() > 0) {
            $row = $q->row();
            $this->db->delete('attachments', array('id'=>$id));
            unlink(FCPATH.'/files/'.$row->filename);
            $this->repairer->send_json(array('success'=>true));

            $this->settings_model->addLog('delete-attachment', 'reparation', $row->reparation_id, json_encode(array(
                'filename' => $row->filename,
            )));

            return true;
        }
        $this->repairer->send_json(array('success'=>false));
        return false;

    }

    public function state_save() {
        $state = $this->input->post('state');
        $this->db->update('settings', array('reparation_table_state'=>($state)));
    }

    public function load_state() {
        if (!empty($this->mSettings->reparation_table_state)) {
            header('Content-Type: application/json');
            echo $this->mSettings->reparation_table_state;
        } else {
            http_response_code(201);
        }
    }

    public function view_log($reparation_id  = NULL) {
        $this->mPageTitle = lang('view_log_title');
        $this->data['id'] = $reparation_id;
        $this->render('reparation/view_log');
    }
    public function getLogTable($reparation_id  = NULL) {
        $this->load->library('datatables');
        $this->datatables
            ->select('date,CONCAT(users.first_name, " ",users.last_name) as name, log') 
            ->join('users', 'users.id=log.updated_by', 'left')
            ->where('reparation_id', $reparation_id)
            ->from('log');
        echo $this->datatables->generate();
    }

    function print_barcodes($repair_id = NULL)
    {
        $this->mPageTitle = lang('print_barcode');
        $this->repairer->checkPermissions();
        $this->form_validation->set_rules('style', lang("style"), 'required');

        if ($this->form_validation->run() == true) {
            $style = $this->input->post('style');
            $bci_size = ($style == 10 || $style == 12 ? 50 : ($style == 14 || $style == 18 ? 30 : 20));
            if ($style == 50) {
                $bci_size = 30;
                # code...
            }
            $this->data['bci_size'] = $bci_size;
            $s = isset($_POST['product']) ? sizeof($_POST['product']) : 0;
            if ($s < 1) {
                $this->session->set_flashdata('error', lang('no_product_selected'));
                redirect("panel/reparation/print_barcodes");
            }
            for ($m = 0; $m < $s; $m++) {
                $pid = $_POST['product'][$m];
                $quantity = $_POST['quantity'][$m];
                $product = $this->reparation_model->getReparationByID($pid);
                $barcodes[] = array(
                    'site' => $this->input->post('site_name') ? $this->mSettings->title : FALSE,
                    'name' => $this->input->post('client_name') ? $product['name'] : FALSE,
                    'model' => $this->input->post('model') ? $product['model_name'] : FALSE,
                    'imei' => $this->input->post('imei') ? $product['imei'] : FALSE,
                    'telephone' => $this->input->post('telephone') ? $product['telephone'] : FALSE,
                    'pin_code' => $this->input->post('pin_code') ? $product['pin_code'] : FALSE,
                    'price' => $this->input->post('price') ? number_format($product['grand_total'], 0, '', '') : FALSE,
                    'barcode' => ($product['code']),
                    'quantity' => $quantity,
                    'defect' => $product['defect'],
                );
            }
            $this->data['barcodes'] = $barcodes;
            $this->data['style'] = $style;
            $this->data['items'] = false;
            
            $this->render('reparation/print_barcodes');
        } else {
            if ($repair_id) {
                if ($row = $this->reparation_model->getReparationByID($repair_id)) {
                    $pr[$row['id']] = array(
                        'id' => $row['id'], 
                        'label' => $row['name'] . " (" . $row['model_name'] . ")", 
                        'name' => $row['name'], 
                        'imei' => $row['imei'], 
                        'model' => $row['model_name'], 
                        'telephone' => $row['telephone'], 
                        'qty' => 1
                    );
                    $this->session->set_flashdata('message',  lang('product_added_to_list'));
                }
            }
            $this->data['items'] = isset($pr) ? json_encode($pr) : false;
            $this->render('reparation/print_barcodes');
        }
    }

    public function getDefects($term = null) {
        if ($term) {
            $this->db->like('defect', $term);
        }
        $q = $this->db->group_by('defect')->get('reparation');
        $defects = array();
        if ($q->num_rows() > 0) {
            $defects = $q->result_array();
        }
        echo $this->repairer->send_json($defects);
    }

    public function getMobileImeis($term = null) {
        if ($term) {
            $this->db->like('imei', $term);
        }
        $q = $this->db->group_by('imei')->get('reparation');
        $imei = array();
        if ($q->num_rows() > 0) {
            $imei = $q->result_array();
        }
        echo $this->repairer->send_json($imei);
    }

     public function getReparationByIMEI(){
        $imei = $this->input->post('imei');
        $reparation_details = $this->reparation_model->getReparationByIMEI($imei);
        echo $this->repairer->send_json($reparation_details);
    }
    

    public function getNextInsertID()
    {

        $q = $this->db->order_by('id', 'DESC')->select('id')->from('reparation')->limit(1)->get();
        if ($q->num_rows() > 0) {
            $Auto_increment = $q->row()->id + 1;
        }else{
            $Auto_increment = 1;
        }

        echo uniqid();
    }




     // Reparation Payments
    // 
      public function payments($id = null)
    {
        $this->data['payments'] = $this->reparation_model->getRepairPayments($id);
        $this->data['inv'] = $this->reparation_model->getRepairByID($id);
        $this->load->view($this->theme.'/reparation/payments', $this->data);
    }


    public function delete_payment($id = null) {
        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }


        if ($this->reparation_model->deletePayment($id)) {
            $this->session->set_flashdata('message', lang("payment_deleted"));
            redirect($_SERVER["HTTP_REFERER"]);
        }
    }


    public function add_payment($id = NULL)
    {
        $this->load->helper('security');
        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }
        if ($this->input->post('sale_id')) {
            $id = $this->input->post('sale_id');
        }


        $sale = $this->reparation_model->getRepairByID($id);
        if ($sale->payment_status == 'paid' && $sale->grand_total == $sale->paid) {
            $this->session->set_flashdata('message', lang('sale_already_paid'));
            $this->repairer->md();
        }

        $this->form_validation->set_rules('amount-paid', lang("amount"), 'required');
        $this->form_validation->set_rules('paid_by', lang("paid_by"), 'required');
        $this->form_validation->set_rules('userfile', lang("attachment"), 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $date = date('Y-m-d H:i:s');
            $payment = array(
                'date'         => $date,
                'reparation_id'      => $this->input->post('sale_id'),
                'reference_no' => $this->repairer->getReference('pay'),
                'amount'       => $this->input->post('amount-paid'),
                'paid_by'      => $this->input->post('paid_by'),
                'cheque_no'    => $this->input->post('cheque_no'),
                'cc_no'        => $this->input->post('paid_by') == 'voucher' ? $this->input->post('voucher_no') : $this->input->post('pcc_no'),
                'cc_holder'    => $this->input->post('pcc_holder'),
                'cc_month'     => $this->input->post('pcc_month'),
                'cc_year'      => $this->input->post('pcc_year'),
                'cc_type'      => $this->input->post('pcc_type'),
                'cc_cvv2'      => $this->input->post('pcc_ccv'),
                'note'         => $this->input->post('note'),
                'created_by'   => $this->session->userdata('user_id'),
                'type'         => 'received',
            );

         

        } elseif ($this->input->post('add_payment')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        }

        if ($this->form_validation->run() == TRUE && $msg = $this->reparation_model->addPayment($payment)) {
            if ($msg) {
                $this->session->set_flashdata('message', lang("payment_added"));
                $success = true;
            } else {
                $this->session->set_flashdata('error', lang("payment_failed"));
                $success = false;
            }
            redirect($_SERVER["HTTP_REFERER"]);
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $sale = $this->reparation_model->getRepairByID($id);
            $this->data['inv'] = $sale;
            $this->data['payment_ref'] = $this->repairer->getReference('pay');
            $this->load->view($this->theme.'/reparation/add_payment', $this->data);
        }
    }

    public function edit_payment($id = null, $reparation_id = null)
    {
        $this->load->helper('security');
        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }
        $payment = $this->reparation_model->getPaymentByID($id);
        $sale = $this->reparation_model->getRepairByID($payment->reparation_id);
        if ($sale->payment_status == 'paid' && $sale->grand_total == $sale->paid) {
            $this->session->set_flashdata('message', lang('sale_already_paid'));
            $this->repairer->md();
        }

        $this->form_validation->set_rules('amount-paid', lang("amount"), 'required');
        $this->form_validation->set_rules('paid_by', lang("paid_by"), 'required');
        $this->form_validation->set_rules('userfile', lang("attachment"), 'xss_clean');

        if ($this->form_validation->run() == true) {
            $date = date('Y-m-d H:i:s');

            $payment = array(
                'date' => $date,
                'reparation_id' => $this->input->post('reparation_id'),
                'reference_no' => $this->repairer->getReference('pay'),
                'amount' => $this->input->post('amount-paid'),
                'paid_by' => $this->input->post('paid_by'),
                'cheque_no' => $this->input->post('cheque_no'),
                'cc_no'        => $this->input->post('paid_by') == 'voucher' ? $this->input->post('voucher_no') : $this->input->post('pcc_no'),
                'cc_holder' => $this->input->post('pcc_holder'),
                'cc_month' => $this->input->post('pcc_month'),
                'cc_year' => $this->input->post('pcc_year'),
                'cc_type' => $this->input->post('pcc_type'),
                'note'         => $this->input->post('note'),
                'created_by' => $this->session->userdata('user_id'),
            );

        } elseif ($this->input->post('edit_payment')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        }

        if ($this->form_validation->run() == true && $this->reparation_model->updatePayment($id, $payment, 'reparation')) {
            $this->session->set_flashdata('error', lang('payment_updated'));
            redirect($_SERVER["HTTP_REFERER"]);
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['payment'] = $payment;
            $this->data['inv'] = $sale;
            $this->load->view($this->theme . '/reparation/edit_payment', $this->data);
        }
    }


    public function email_invoice($id = null) {
        $email = $this->input->post('email');
        $id = $this->input->post('id');

        $repair = $this->reparation_model->findReparationByID($id);
        $customer = $this->reparation_model->getClientNameByID($repair['client_id']);

        $this->data['page_title'] = lang('invoice');
        $this->data['settings'] = $this->mSettings;

        $this->load->library('parser');
        $message = $this->mSettings->invoice_email_text;

        $parse_data = array(
            'stylesheet' => '<link rel="stylesheet" href="'.$this->assets.'assets/vendor/bootstrap/css/bootstrap.css" />',
            'name' => $customer->company && $customer->company != '-' ? $customer->company :  $customer->name,
            'email' => $customer->email,
            'heading' => lang('invoice').'<hr>',
            'msg' => $message,
            'site_link' => base_url(),
            'site_name' => $this->mSettings->title,
            'logo' => '<img src="' . base_url('assets/uploads/logos/' . $this->mSettings->logo) . '" alt="' . $this->mSettings->title . '"/>',
            'email_footer' => '<body bgcolor="#f7f9fa">
                    <table class="body-wrap" bgcolor="#f7f9fa">
                        <tr>
                            <td></td>
                            <td class="container" bgcolor="#FFFFFF">
                                <div class="content">' . $this->mSettings->email_footer . '</div>

                            </td>
                            <td></td>
                        </tr>
                    </table>',
        );

        $msg = file_get_contents(FCPATH.'themes/'.$this->theme.'email_templates/email_con.html');
        $message = $this->parser->parse_string($msg, $parse_data, TRUE);
        $subject = lang('invoice') . ' - ' . $this->mSettings->title;

        $repair = $this->reparation_model->findReparationByID($id);
        $this->data['db'] = $repair;
        $this->data['items'] = $this->reparation_model->getAllReparationItems($id);
        $this->data['tax_rate'] = $this->settings_model->getTaxRateByID($this->data['db']['tax_id']);
        $this->data['client'] = $this->reparation_model->getClientNameByID($this->data['db']['client_id']);
        $this->data['currency'] = $this->mSettings->currency;
        $this->data['language'] = $this->mSettings->language;
        $this->data['status'] = $this->settings_model->getStatusByID($this->data['db']['status']);
        $this->data['payments'] = $this->reparation_model->getPaymentsByReparationID($repair['id']);
        $this->data['user'] = $this->mUser;
        $this->data['two_copies'] = 0;
        $this->data['is_a4'] = 0;
        $this->data['pdf'] = true;
        $html = $this->load->view($this->theme . 'template/invoice_template2', $this->data, TRUE);
        $pdf = $this->repairer->generate_pdf($html, lang('invoice').'.pdf', 'S');

        if ($this->repairer->send_email($email, $subject, $message, null, null, $pdf)) {
            $this->repairer->send_json(array('msg' => lang("email_sent")));
        } else {
            $this->repairer->send_json(array('msg' => lang("email_failed")));
        }
    }

    // SHOW A INVOICE TEMPLATE //
    public function sheet($id)
    {
        $this->data['db'] = $this->reparation_model->findReparationByID($id);
        $this->data['items'] = $this->reparation_model->getAllReparationItems($id);
        $this->data['tax_rate'] = $this->settings_model->getTaxRateByID($this->data['db']['tax_id']);
        $this->data['client'] = $this->reparation_model->getClientNameByID($this->data['db']['client_id']);
        $this->data['currency'] = $this->mSettings->currency;
        $this->data['language'] = $this->mSettings->language;
        $this->data['status'] = $this->settings_model->getStatusByID($this->data['db']['status']);

        $this->data['user'] = $this->mUser;
        $this->data['two_copies'] = 0;
        $this->data['is_a4'] = 0;
        $this->mPageTitle = lang('report');
        $this->load->view($this->theme . 'template/sheet_template', $this->data);
    }



     public function update_status($id)
    {
        $this->form_validation->set_rules('status', lang('sale_status'), 'required');

        if ($this->form_validation->run() == true) {
            $status = $this->input->post('status');
            $description   = $this->repairer->clear_tags($this->input->post('description'));
        } elseif ($this->input->post('update')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'panel/reparations');
        }

        if ($this->form_validation->run() == true && $this->reparation_model->change_status($id, $status, $description)) {
            $this->session->set_flashdata('message', lang('status_updated'));
            redirect(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'panel/reparations');
        } else {
            $this->data['repair']      = $this->reparation_model->getReparationByID($id);
            $this->data['statuses'] = $this->settings_model->getRepairStatuses();
            $this->load->view($this->theme . 'reparation/update_status', $this->data);
        }
    }

    public function export($excel = true, $pdf = false)
    {



        $has_warranty = $this->input->get('has_warranty');
        $manufacturer = $this->input->get('manufacturer');
        $client_id = $this->input->get('client_id');
        $status = $this->input->get('status');
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');


        if ($has_warranty) {
            $this->db->where('has_warranty', $has_warranty);
        }

        if ($manufacturer) {
            $this->db->where('manufacturer', $manufacturer);
        }

        if ($client_id) {
            $this->db->where('client_id', $client_id);
        }

        if ($status) {
            $this->db->where('status', $status);
        }

        if ($start_date && $end_date) {
            $this->db->where('DATE(date_opening) >=', $start_date);
            $this->db->where('DATE(date_opening) <=', $end_date);
        }
        $wm = array('1' => lang('in_warranty'), '0' => lang('out_warranty')); 
        



        $q = $this->db
            ->select('reparation.id, DATE(date_opening) as date_opening, name, telephone, model_name, manufacturer, warranty, warranty_card_number, date_of_purchase, GROUP_CONCAT(product_name) as parts, has_warranty')
            ->join('reparation_items', 'reparation.id=reparation_items.reparation_id', 'left')
            ->group_by('reparation.id')
            ->get('reparation');

        if ($q->num_rows() > 0) {

                $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();

                $sheet->setTitle(lang('reparation_title'));
                $sheet->SetCellValue('A1', lang('date_opening'));
                $sheet->SetCellValue('B1', lang('client_name'));
                $sheet->SetCellValue('C1', lang('client_telephone'));
                $sheet->SetCellValue('D1', lang('model_name'));
                $sheet->SetCellValue('E1', lang('manufacturer'));
                $sheet->SetCellValue('F1', lang('has_warranty'));
                $sheet->SetCellValue('G1', lang('warranty_card_number'));
                $sheet->SetCellValue('H1', lang('date_of_purchase'));
                $sheet->SetCellValue('I1', lang('material'));

                $row = 2;
                foreach ($q->result() as $repair) {
                    $sheet->SetCellValue('A' . $row, $this->repairer->hrsd($repair->date_opening));
                    $sheet->SetCellValue('B' . $row, $repair->name);
                    $sheet->SetCellValue('C' . $row, $repair->telephone);
                    $sheet->SetCellValue('D' . $row, $repair->model_name);
                    $sheet->SetCellValue('E' . $row, $repair->manufacturer);
                    $sheet->SetCellValue('F' . $row, $wm[$repair->has_warranty]);
                    $sheet->SetCellValue('G' . $row, $repair->warranty_card_number);
                    $sheet->SetCellValue('H' . $row, $this->repairer->hrsd($repair->date_of_purchase));
                    $sheet->SetCellValue('I' . $row, $repair->parts);
                    $row++;
                }

                $sheet->getColumnDimension('A')->setWidth(15);
                $sheet->getColumnDimension('B')->setWidth(20);
                $sheet->getColumnDimension('C')->setWidth(20);
                $sheet->getColumnDimension('D')->setWidth(30);
                $sheet->getColumnDimension('E')->setWidth(20);
                $sheet->getColumnDimension('F')->setWidth(20);
                $sheet->getColumnDimension('G')->setWidth(20);
                $sheet->getColumnDimension('H')->setWidth(15);
                $sheet->getColumnDimension('I')->setWidth(40);
                $sheet->getParent()->getDefaultStyle()->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $filename = 'orders_' . date('Y_m_d_H_i_s');
                if ($excel) {
                    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
                    header('Cache-Control: max-age=0');

                    $writer = PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
                    $writer->save('php://output');
                    exit();
                }

                if ($pdf) {
                    $styleArray = [
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                                'color' => ['argb' => 'FFFF0000'],
                            ],
                        ],
                    ];
                    $sheet->getStyle('A0:I'.($row-1))->applyFromArray($styleArray);
                    $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                    header('Content-Type: application/pdf');
                    header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
                    header('Cache-Control: max-age=0');
                    $writer = PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Mpdf');
                    $writer->save('php://output');
                }

            # code...
        }
        # code...
    }

}