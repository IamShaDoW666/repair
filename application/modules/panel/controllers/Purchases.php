<?php defined('BASEPATH') or exit('No direct script access allowed');

class Purchases extends Auth_Controller
{

    public function __construct()
    {
        parent::__construct();
     
        $this->load->library('form_validation');
        $this->load->library('repairer');
        $this->load->model('purchases_model');
        $this->digital_upload_path = 'files/';
        $this->image_types = 'gif|jpg|jpeg|png|tif';
        $this->digital_file_types = 'zip|psd|ai|rar|pdf|doc|docx|xls|xlsx|ppt|pptx|gif|jpg|jpeg|png|tif|txt';
        $this->allowed_file_size = '1024';
        $this->data['logo'] = true;

    }
   

    public function index()
    {
        $this->mPageTitle = lang('purchases');

        $this->repairer->checkPermissions();
        $this->render('purchases/index');
    }

    public function getPurchases()
    {
        $this->repairer->checkPermissions('index');


        $user = $this->ion_auth->get_user_id();
        $edit_link = anchor('panel/purchases/edit/$1', '<i class="fas fa-edit"></i> ' . lang('edit_purchase'), 'class="dropdown-item"');
        $pdf_link = anchor('panel/purchases/pdf/$1', '<i class="fas fa-file-pdf"></i> ' . lang('download_pdf'), 'class="dropdown-item"');
        $print_barcode = anchor('panel/inventory/print_barcodes/?purchase=$1', '<i class="fas fa-print"></i> ' . lang('print_barcode_label'), 'class="dropdown-item"');
        $delete_link = "<a href='#' class='po dropdown-item' title='<b>" . lang('delete_purchase') . "</b>' data-content=\"<p>"
        . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('panel/purchases/delete/$1') . "'>"
        . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fas fa-trash\"></i> "
        . lang('delete_purchase') . "</a>";

        $return_link = anchor('panel/purchases/return_purchase/$1', '<i class="fas fa-angle-double-left"></i>' . lang('return_purchase'), 'class="dropdown-item"');

        $action = '<div class="text-center"><div class="btn-group dropleft">'
        . '<button type="button" class="btn  btn-primary dropdown-toggle" data-toggle="dropdown">'
        . "Actions" . ' <span class="caret"></span></button>
        <ul class="dropdown-menu " role="menu">
            ' . $edit_link . '
            ' . $pdf_link . '
            ' . $print_barcode . '
            ' . $return_link . '
            ' . $delete_link . '
        </ul>
    </div></div>';
        $this->load->library('datatables');
        $this->datatables
            ->select("id, DATE_FORMAT(date, '%Y-%m-%d %T') as date, reference_no, supplier, status, grand_total, attachment")
            ->from('purchases');
        $this->datatables->add_column("Actions", $action, "id");
        echo $this->datatables->generate();
    }


     public function modal_view($purchase_id = null)
    {

        if ($this->input->get('id')) {
            $purchase_id = $this->input->get('id');
        }
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $inv = $this->purchases_model->getPurchaseByID($purchase_id);
        
        $this->data['rows'] = $this->purchases_model->getAllPurchaseItems($purchase_id);
        $this->data['supplier'] = $this->purchases_model->getCompanyByID($inv->supplier_id);
        $this->data['inv'] = $inv;
        $this->data['created_by'] = $this->purchases_model->getUser($inv->created_by);
        $this->data['updated_by'] = $inv->updated_by ? $this->purchases_model->getUser($inv->updated_by) : null;
        $this->data['Settings'] = $this->mSettings;

        $this->load->view($this->theme . 'purchases/modal_view', $this->data);

    }


    public function pdf($purchase_id = null, $view = null, $save_bufffer = null)
    {

        if ($this->input->get('id')) {
            $purchase_id = $this->input->get('id');
        }
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['Settings'] = $this->mSettings;
        $inv = $this->purchases_model->getPurchaseByID($purchase_id);
        $this->data['rows'] = $this->purchases_model->getAllPurchaseItems($purchase_id);
        $this->data['supplier'] = $this->purchases_model->getCompanyByID($inv->supplier_id);
        $this->data['created_by'] = $this->purchases_model->getUser($inv->created_by);
        $this->data['inv'] = $inv;
        $name = $this->lang->line("purchase") . "_" . str_replace('/', '_', $inv->reference_no) . ".pdf";
        $html = $this->load->view($this->theme . 'purchases/pdf', $this->data, true);
        $html = preg_replace("'\<\?xml(.*)\?\>'", '', $html);
        if ($view) {
            $this->load->view($this->theme . 'purchases/pdf', $this->data);
        } elseif ($save_bufffer) {
            return $this->repairer->generate_pdf($html, $name, $save_bufffer);
        } else {
            $this->repairer->generate_pdf($html, $name);
        }

    }

    public function add()
    {   
        $this->mPageTitle = lang('add_purchase');

        $this->repairer->checkPermissions();

        $this->form_validation->set_message('is_natural_no_zero', $this->lang->line("no_zero_required"));
        $this->form_validation->set_rules('posupplier', $this->lang->line("supplier"), 'required');

        $this->session->unset_userdata('csrf_token');
        if ($this->form_validation->run() == true) {
            $reference = $this->input->post('reference_no') ? $this->input->post('reference_no') : $this->purchases_model->getReference('po');

            $date = $this->repairer->fld(trim($this->input->post('date')));
            $supplier_id = $this->input->post('posupplier');
            $status = $this->input->post('status');
            $shipping = $this->input->post('shipping') ? $this->input->post('shipping') : 0;
            $supplier_details = $this->purchases_model->getCompanyByID($supplier_id);
            $supplier = $supplier_details->company != '-'  ? $supplier_details->company : $supplier_details->name;
            $note = $this->repairer->clear_tags($this->input->post('note'));

            $total = 0;
            $product_tax = 0;
            $order_tax = 0;
            $product_discount = 0;
            $order_discount = 0;
            $percentage = '%';
            $i = sizeof($_POST['product']);
            for ($r = 0; $r < $i; $r++) {
                $item_code = $_POST['product'][$r];
                $item_net_cost = ($_POST['net_cost'][$r]);
                $unit_cost = ($_POST['unit_cost'][$r]);
                $item_tax_rate = isset($_POST['product_tax'][$r]) ? $_POST['product_tax'][$r] : null;
                $item_discount = isset($_POST['product_discount'][$r]) ? $_POST['product_discount'][$r] : null;
                $item_quantity = $_POST['quantity'][$r];

                if (isset($item_code) && isset($unit_cost) && isset($item_quantity)) {
                    $product_details = $this->purchases_model->getProductByCode($item_code);
                    $pr_discount = 0;
                    if (isset($item_discount)) {
                        $discount = $item_discount;
                        $dpos = strpos($discount, $percentage);
                        if ($dpos !== false) {
                            $pds = explode("%", $discount);
                            $pr_discount = ((($unit_cost) * (Float) ($pds[0])) / 100);
                        } else {
                            $pr_discount = ($discount);
                        }
                    }

                    $unit_cost = ($unit_cost - $pr_discount);
                    $item_net_cost = $unit_cost;
                    $pr_item_discount = ($pr_discount * $item_quantity);
                    $product_discount += $pr_item_discount;
                    $pr_tax = 0;
                    $pr_item_tax = 0;
                    $item_tax = 0;
                    $tax = "";

                    if (isset($item_tax_rate) && $item_tax_rate != 0) {
                        $pr_tax = $item_tax_rate;
                        $tax_details = $this->purchases_model->getTaxRateByID($pr_tax);
                        if ($tax_details->type == 1 && $tax_details->rate != 0) {

                            if ($product_details && $product_details->tax_method == 1) {
                                $item_tax = ((($unit_cost) * $tax_details->rate) / 100);
                                $tax = $tax_details->rate . "%";
                            } else {
                                $item_tax = ((($unit_cost) * $tax_details->rate) / (100 + $tax_details->rate));
                                $tax = $tax_details->rate . "%";
                                $item_net_cost = $unit_cost - $item_tax;
                            }

                        } elseif ($tax_details->type == 2) {

                            if ($product_details && $product_details->tax_method == 1) {
                                $item_tax = ((($unit_cost) * $tax_details->rate) / 100);
                                $tax = $tax_details->rate . "%";
                            } else {
                                $item_tax = ((($unit_cost) * $tax_details->rate) / (100 + $tax_details->rate));
                                $tax = $tax_details->rate . "%";
                                $item_net_cost = $unit_cost - $item_tax;
                            }

                            $item_tax = ($tax_details->rate);
                            $tax = $tax_details->rate;

                        }
                        $pr_item_tax = ($item_tax * $item_quantity);

                    }

                    $product_tax += $pr_item_tax;
                    $subtotal = (($item_net_cost * $item_quantity) + $pr_item_tax);

                    $products[] = array(
                        'product_id' => $product_details->id,
                        'product_code' => $item_code,
                        'product_name' => $product_details->name,
                        'net_unit_cost' => $item_net_cost,
                        'unit_cost' => ($item_net_cost + $item_tax),
                        'quantity' => $item_quantity,
                        'quantity_balance' => $item_quantity,
                        'item_tax' => $pr_item_tax,
                        'tax_rate_id' => $pr_tax,
                        'tax' => $tax,
                        'discount' => $item_discount,
                        'item_discount' => $pr_item_discount,
                        'subtotal' => ($subtotal),
                        'date' => date('Y-m-d', strtotime($date)),
                        'status' => $status,
                    );

                    $total += (($item_net_cost * $item_quantity));
                }
            }
            if (empty($products)) {
                $this->form_validation->set_rules('product', lang("order_items"), 'required');
            } else {
                krsort($products);
            }

            if ($this->input->post('discount')) {
                $order_discount_id = $this->input->post('discount');
                $opos = strpos($order_discount_id, $percentage);
                if ($opos !== false) {
                    $ods = explode("%", $order_discount_id);
                    $order_discount = (((($total + $product_tax) * (Float) ($ods[0])) / 100));

                } else {
                    $order_discount = ($order_discount_id);
                }
            } else {
                $order_discount_id = null;
            }
            $total_discount = ($order_discount + $product_discount);

            if ($this->mSettings->tax2 != 0) {
                $order_tax_id = $this->input->post('order_tax');
                if ($order_tax_details = $this->purchases_model->getTaxRateByID($order_tax_id)) {
                    if ($order_tax_details->type == 2) {
                        $order_tax =  ($order_tax_details->rate);
                    }
                    if ($order_tax_details->type == 1) {
                        $order_tax =  (((($total + $product_tax - $order_discount) * $order_tax_details->rate) / 100));
                    }
                }
            } else {
                $order_tax_id = null;
            }

            $total_tax = (($product_tax + $order_tax));
            $grand_total = (($total + $total_tax + $this->repairer->formatDecimal($shipping) - $order_discount));
            $data = array('reference_no' => $reference,
                'date' => $date,
                'supplier_id' => $supplier_id,
                'supplier' => $supplier,
                'note' => $note,
                'total' => $total,
                'product_discount' => $product_discount,
                'order_discount_id' => $order_discount_id,
                'order_discount' => $order_discount,
                'total_discount' => $total_discount,
                'product_tax' => $product_tax,
                'order_tax_id' => $order_tax_id,
                'order_tax' => $order_tax,
                'total_tax' => $total_tax,
                'shipping' => ($shipping),
                'grand_total' => $grand_total,
                'status' => $status,
                'created_by' => $this->session->userdata('user_id'),
            );

            if ($_FILES['document']['size'] > 0) {
                $this->load->library('upload');
                $config['upload_path'] = $this->digital_upload_path;
                $config['allowed_types'] = $this->digital_file_types;
                $config['max_size'] = $this->allowed_file_size;
                $config['overwrite'] = false;
                $config['encrypt_name'] = true;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('document')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER["HTTP_REFERER"]);
                }
                $photo = $this->upload->file_name;
                $data['attachment'] = $photo;
            }

        }

        if ($this->form_validation->run() == true && $this->purchases_model->addPurchase($data, $products)) {
            $this->session->set_userdata('remove_pols', 1);
            $this->session->set_flashdata('message', lang("purchase_added"));
            redirect('panel/purchases');
        }else{
            $this->data['ponumber'] =  $this->purchases_model->getReference('po');
            
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['suppliers'] = $this->purchases_model->getAllCompanies('supplier');
            $this->data['tax_rates'] = $this->purchases_model->getAllTaxRates();
            $this->load->helper('string');
            $value = random_string('alnum', 20);
            $this->session->set_userdata('user_csrf', $value);
            $this->data['csrf'] = $this->session->userdata('user_csrf');
            $this->render('purchases/add');
        }
    }

    public function edit($id = null)
    {
        $this->mPageTitle = lang('edit_purchase');
        
        $this->repairer->checkPermissions();

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }
        $inv = $this->purchases_model->getPurchaseByID($id);
        
        if ($inv->status == 'received') {
            $this->session->set_flashdata('error', lang('received_purchase_non_editable'));
            redirect('panel/purchases');
        }
        $this->form_validation->set_message('is_natural_no_zero', lang("no_zero_required"));
        $this->form_validation->set_rules('reference_no', lang("ref_no"), 'required');
        $this->form_validation->set_rules('posupplier', lang("supplier"), 'required');

        $this->session->unset_userdata('csrf_token');
        if ($this->form_validation->run() == true) {

            $reference = $this->input->post('reference_no');
            $date = $this->repairer->fld(trim($this->input->post('date')));
            
            $supplier_id = $this->input->post('posupplier');
            $status = $this->input->post('status');
            $shipping = $this->input->post('shipping') ? $this->input->post('shipping') : 0;
            $supplier_details = $this->purchases_model->getCompanyByID($supplier_id);
            $supplier = $supplier_details->company != '-'  ? $supplier_details->company : $supplier_details->name;
            $note = $this->repairer->clear_tags($this->input->post('note'));

            $total = 0;
            $product_tax = 0;
            $order_tax = 0;
            $product_discount = 0;
            $order_discount = 0;
            $percentage = '%';
            $partial = false;
            $i = sizeof($_POST['product']);
            for ($r = 0; $r < $i; $r++) {
                $item_code = $_POST['product'][$r];
                $item_net_cost = $this->repairer->formatDecimal($_POST['net_cost'][$r]);
                $unit_cost = $this->repairer->formatDecimal($_POST['unit_cost'][$r]);
                $item_unit_quantity = $_POST['quantity'][$r];
                $item_unit_quantity_balc = $_POST['quantity_balance'][$r];
                $item_option = isset($_POST['product_option'][$r]) && $_POST['product_option'][$r] != 'false' ? $_POST['product_option'][$r] : null;
                $item_tax_rate = isset($_POST['product_tax'][$r]) ? $_POST['product_tax'][$r] : null;
                $item_discount = isset($_POST['product_discount'][$r]) ? $_POST['product_discount'][$r] : null;

                if (isset($item_code) && isset($unit_cost) && isset($item_unit_quantity)) {
                    $product_details = $this->purchases_model->getProductByCode($item_code);
                    $pr_discount = 0;

                    if (isset($item_discount)) {
                        $discount = $item_discount;
                        $dpos = strpos($discount, $percentage);
                        if ($dpos !== false) {
                            $pds = explode("%", $discount);
                            $pr_discount = $this->repairer->formatDecimal(((($this->repairer->formatDecimal($unit_cost)) * (Float) ($pds[0])) / 100), 4);
                        } else {
                            $pr_discount = $this->repairer->formatDecimal($discount);
                        }
                    }

                    $unit_cost = $this->repairer->formatDecimal($unit_cost - $pr_discount);
                    $item_net_cost = $unit_cost;
                    $pr_item_discount = $this->repairer->formatDecimal($pr_discount * $item_unit_quantity);
                    $product_discount += $pr_item_discount;
                    $pr_tax = 0;
                    $pr_item_tax = 0;
                    $item_tax = 0;
                    $tax = "";

                    if (isset($item_tax_rate) && $item_tax_rate != 0) {
                        $pr_tax = $item_tax_rate;
                        $tax_details = $this->purchases_model->getTaxRateByID($pr_tax);
                        if ($tax_details->type == 1 && $tax_details->rate != 0) {

                            if ($product_details && $product_details->tax_method == 1) {
                                $item_tax = $this->repairer->formatDecimal((($unit_cost) * $tax_details->rate) / 100, 4);
                                $tax = $tax_details->rate . "%";
                            } else {
                                $item_tax = $this->repairer->formatDecimal((($unit_cost) * $tax_details->rate) / (100 + $tax_details->rate), 4);
                                $tax = $tax_details->rate . "%";
                                $item_net_cost = $unit_cost - $item_tax;
                            }

                        } elseif ($tax_details->type == 2) {

                            if ($product_details && $product_details->tax_method == 1) {
                                $item_tax = $this->repairer->formatDecimal((($unit_cost) * $tax_details->rate) / 100, 4);
                                $tax = $tax_details->rate . "%";
                            } else {
                                $item_tax = $this->repairer->formatDecimal((($unit_cost) * $tax_details->rate) / (100 + $tax_details->rate), 4);
                                $tax = $tax_details->rate . "%";
                                $item_net_cost = $unit_cost - $item_tax;
                            }

                            $item_tax = $this->repairer->formatDecimal($tax_details->rate);
                            $tax = $tax_details->rate;

                        }
                        $pr_item_tax = $this->repairer->formatDecimal($item_tax * $item_unit_quantity, 4);

                    }

                    $product_tax += $pr_item_tax;
                    $subtotal = (($item_net_cost * $item_unit_quantity) + $pr_item_tax);

                    $items[] = array(
                        'product_id' => $product_details->id,
                        'product_code' => $item_code,
                        'product_name' => $product_details->name,
                        'net_unit_cost' => $item_net_cost,
                        'unit_cost' => $this->repairer->formatDecimal($item_net_cost + $item_tax),
                        'quantity' => $item_unit_quantity,
                        'quantity_balance' => $item_unit_quantity_balc,
                        'item_tax' => $pr_item_tax,
                        'tax_rate_id' => $pr_tax,
                        'tax' => $tax,
                        'discount' => $item_discount,
                        'item_discount' => $pr_item_discount,
                        'subtotal' => $this->repairer->formatDecimal($subtotal),
                        'date' => date('Y-m-d', strtotime($date)),
                    );

                    $total += $item_net_cost * $item_unit_quantity;
                }
            }
            if ($status == 'received' || $status == 'partial') {
                $status = $partial ? $partial : 'received';
            }
            if (empty($items)) {
                $this->form_validation->set_rules('product', lang("order_items"), 'required');
            } else {
                foreach ($items as $item) {
                    $item["status"] = $status;
                    $products[] = $item;
                }
                krsort($products);
            }

            if ($this->input->post('discount')) {
                $order_discount_id = $this->input->post('discount');
                $opos = strpos($order_discount_id, $percentage);
                if ($opos !== false) {
                    $ods = explode("%", $order_discount_id);
                    $order_discount = $this->repairer->formatDecimal(((($total + $product_tax) * (Float) ($ods[0])) / 100), 4);

                } else {
                    $order_discount = $this->repairer->formatDecimal($order_discount_id);
                }
            } else {
                $order_discount_id = null;
            }
            $total_discount = $this->repairer->formatDecimal($order_discount + $product_discount);

            if ($this->mSettings->tax2 != 0) {
                $order_tax_id = $this->input->post('order_tax');
                if ($order_tax_details = $this->purchases_model->getTaxRateByID($order_tax_id)) {
                    if ($order_tax_details->type == 2) {
                        $order_tax = $this->repairer->formatDecimal($order_tax_details->rate);
                    }
                    if ($order_tax_details->type == 1) {
                        $order_tax = $this->repairer->formatDecimal(((($total + $product_tax - $order_discount) * $order_tax_details->rate) / 100), 4);
                    }
                }
            } else {
                $order_tax_id = null;
            }

            $total_tax = $this->repairer->formatDecimal(($product_tax + $order_tax), 4);
            $grand_total = $this->repairer->formatDecimal(($total + $total_tax + $this->repairer->formatDecimal($shipping) - $order_discount), 4);
            $data = array('reference_no' => $reference,
                'supplier_id' => $supplier_id,
                'supplier' => $supplier,
                'note' => $note,
                'total' => $total,
                'product_discount' => $product_discount,
                'order_discount_id' => $order_discount_id,
                'order_discount' => $order_discount,
                'total_discount' => $total_discount,
                'product_tax' => $product_tax,
                'order_tax_id' => $order_tax_id,
                'order_tax' => $order_tax,
                'total_tax' => $total_tax,
                'shipping' => $this->repairer->formatDecimal($shipping),
                'grand_total' => $grand_total,
                'status' => $status,
                'updated_by' => $this->session->userdata('user_id'),
                'updated_at' => date('Y-m-d H:i:s'),
            );
            if ($date) {
                $data['date'] = $date;
            }

            if ($_FILES['document']['size'] > 0) {
                $this->load->library('upload');
                $config['upload_path'] = $this->digital_upload_path;
                $config['allowed_types'] = $this->digital_file_types;
                $config['max_size'] = $this->allowed_file_size;
                $config['overwrite'] = false;
                $config['encrypt_name'] = true;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('document')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER["HTTP_REFERER"]);
                }
                $photo = $this->upload->file_name;
                $data['attachment'] = $photo;
            }
        }

        if ($this->form_validation->run() == true && $this->purchases_model->updatePurchase($id, $data, $products)) {
            $this->session->set_userdata('remove_pols', 1);
            $this->session->set_flashdata('message', lang('purchase_updated'));
            redirect('panel/purchases', 'refresh');
        } else {

            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['inv'] = $inv;
           
            $inv_items = $this->purchases_model->getAllPurchaseItems($id);
            krsort($inv_items);
            $c = rand(100000, 9999999);
            foreach ($inv_items as $item) {
                $row = $this->purchases_model->getProductByID($item->product_id);
                $row->base_quantity = $item->quantity;
                $row->qty = $item->quantity;
                $row->quantity_balance = $item->quantity_balance;
                $row->discount = $item->discount ? $item->discount : '0';
                $row->cost = $this->repairer->formatDecimal($item->net_unit_cost + ($item->item_discount / $item->quantity));
                $row->tax_rate = $item->tax_rate_id;
                unset($row->details, $row->product_details, $row->price, $row->file, $row->product_group_id);
                $tax_rate = $this->purchases_model->getTaxRateByID($row->tax_rate);
                $ri = $row->id;

                $pr[$ri] = array('id' => $c, 'item_id' => $row->id, 'label' => $row->name . " (" . $row->code . ")", 
                    'row' => $row, 'tax_rate' => $tax_rate);
                $c++;
            }

            $this->data['inv_items'] = json_encode($pr);
            $this->data['id'] = $id;
            $this->data['suppliers'] = $this->purchases_model->getAllCompanies('supplier');
            $this->data['purchase'] = $this->purchases_model->getPurchaseByID($id);
            $this->data['tax_rates'] = $this->settings_model->getTaxRates();
            $this->load->helper('string');
            $value = random_string('alnum', 20);
            $this->session->set_userdata('user_csrf', $value);
            $this->session->set_userdata('remove_pols', 1);
            $this->data['csrf'] = $this->session->userdata('user_csrf');
            $this->render('purchases/edit');
        }
    }
    public function delete($id = null) {
        $this->repairer->checkPermissions();
        
        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }

        if ($this->purchases_model->deletePurchase($id)) {
            if ($this->input->is_ajax_request()) {
                echo 'purchase deleted';die();
            }
            $this->session->set_flashdata('message', lang('purchase_deleted'));
            redirect('panel/purchases');
        }
    }
    function getSupplier($id = NULL)
    {
        $this->db->select("id, (CASE WHEN company = '-' THEN name ELSE CONCAT(company, ' (', name, ')') END) as text", FALSE);
        $q = $this->db->get_where('suppliers', array('id' => $id));
        $row = $q->row();
        $this->repairer->send_json((array('id' => $row->id, 'text' => $row->text)));
    }

    function supplier_suggestions($term = NULL, $limit = NULL)
    {
        if ($this->input->get('term')) {
            $term = $this->input->get('term', TRUE);
            $term = $term['term'];
        }
        $limit = $this->input->get('limit', TRUE);
        $rows['results'] = $this->purchases_model->getSupplierSuggestions($term, $limit);
        $this->repairer->send_json($rows);
    }

    public function suggestions()
    {
        $term = $this->input->get('term', true);
        $supplier_id = $this->input->get('supplier_id', true);

        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . site_url('welcome') . "'; }, 10);</script>");
        }

        $rows = $this->purchases_model->getProductNames($term);
        if ($rows) {
            $c = str_replace(".", "", microtime(true));
            $r = 0;
            foreach ($rows as $row) {
                $option = false;
                $row->item_tax_method = $row->tax_method;
               

                $opt = json_decode('{}');
                $opt->cost = 0;
                $row->supplier_part_no = '';
                if ($opt->cost != 0) {
                    $row->cost = $opt->cost;
                }
                $row->real_unit_cost = $row->cost;
                $row->base_quantity = 1;
                $row->base_unit = $row->unit;
                $row->base_unit_cost = $row->cost;
                $row->new_entry = 1;
                $row->expiry = '';
                $row->qty = 1;
                $row->quantity_balance = '';
                $row->discount = '0';
                unset($row->details, $row->product_details, $row->price, $row->file);

                $tax_rate = $this->purchases_model->getTaxRateByID($row->tax_rate);

                $pr[] = array('id' => ($c + $r), 'item_id' => $row->id, 'label' => $row->name . " (" . $row->code . ")", 
                    'row' => $row, 'tax_rate' => $tax_rate);
                $r++;
            }
            $this->repairer->send_json($pr);
        } else {
            $this->repairer->send_json(array(array('id' => 0, 'label' => lang('no_match_found'), 'value' => $term)));
        }
    }

    public function purchase_actions()
    {

        $this->form_validation->set_rules('form_action', lang("form_action"), 'required');

        if ($this->form_validation->run() == true) {

            if (!empty($_POST['val'])) {
                if ($this->input->post('form_action') == 'delete') {

                    foreach ($_POST['val'] as $id) {
                        $this->purchases_model->deletePurchase($id);
                    }

                    $this->session->set_flashdata('message', $this->lang->line("purchases_deleted"));
                    redirect($_SERVER["HTTP_REFERER"]);

                } elseif ($this->input->post('form_action') == 'export_excel' || $this->input->post('form_action') == 'export_pdf') {
                    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
                    $sheet = $spreadsheet->getActiveSheet();

                    $sheet->setTitle(lang('purchases_title'));
                    $sheet->SetCellValue('A1', lang('date'));
                    $sheet->SetCellValue('B1', lang('reference_no'));
                    $sheet->SetCellValue('C1', lang('supplier'));
                    $sheet->SetCellValue('D1', lang('status'));
                    $sheet->SetCellValue('E1', lang('grand_total'));

                    $row = 2;
                    foreach ($_POST['val'] as $id) {
                        $purchase = $this->purchases_model->getPurchaseByID($id);
                        $sheet->SetCellValue('A' . $row, $this->repairer->hrld($purchase->date));
                        $sheet->SetCellValue('B' . $row, $purchase->reference_no);
                        $sheet->SetCellValue('C' . $row, $purchase->supplier);
                        $sheet->SetCellValue('D' . $row, $purchase->status);
                        $sheet->SetCellValue('E' . $row, $this->repairer->formatMoney($purchase->grand_total));
                        $row++;
                    }

                    $sheet->getColumnDimension('A')->setWidth(20);
                    $sheet->getColumnDimension('B')->setWidth(20);
                    $sheet->getParent()->getDefaultStyle()->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                    $filename = 'purchases_' . date('Y_m_d_H_i_s');
                    
                    if ($this->input->post('form_action') == 'export_excel') {
                        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                        header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
                        header('Cache-Control: max-age=0');

                        $writer = PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
                        $writer->save('php://output');
                        exit();
                    }

                    if ($this->input->post('form_action') == 'export_pdf') {
                        $styleArray = [
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                                    'color' => ['argb' => 'FFFF0000'],
                                ],
                            ],
                        ];
                        $sheet->getStyle('A0:E'.($row-1))->applyFromArray($styleArray);
                        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                        header('Content-Type: application/pdf');
                        header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
                        header('Cache-Control: max-age=0');
                        $writer = PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Mpdf');
                        $writer->save('php://output');
                    }

                    redirect($_SERVER["HTTP_REFERER"]);
                }
            } else {
                $this->session->set_flashdata('error', $this->lang->line("no_purchase_selected"));
                redirect($_SERVER["HTTP_REFERER"]);
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        }
    }
    

       public function return_purchase($id = null)
    {
        $this->repairer->checkPermissions('return_purchases');

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }

        $purchase = $this->purchases_model->getPurchaseByID($id);
        if ($purchase->return_id) {
            $this->session->set_flashdata('error', lang('purchase_already_returned'));
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->form_validation->set_rules('return_surcharge', lang('return_surcharge'), 'required');

        if ($this->form_validation->run() == true) {
            $reference = $this->input->post('reference_no') ? $this->input->post('reference_no') : $this->repairer->getReference('rep');
                $date = $this->repairer->fld(trim($this->input->post('date')));
            

            $return_surcharge = $this->input->post('return_surcharge') ? $this->input->post('return_surcharge') : 0;
            $note             = $this->repairer->clear_tags($this->input->post('note'));
            $supplier_details = $this->purchases_model->getCompanyByID($purchase->supplier_id);

            $total            = 0;
            $product_tax      = 0;
            $product_discount = 0;
            $i                = isset($_POST['product']) ? sizeof($_POST['product']) : 0;
            for ($r = 0; $r < $i; $r++) {
                $item_id            = $_POST['product_id'][$r];
                $item_code          = $_POST['product'][$r];
                $purchase_item_id   = $_POST['purchase_item_id'][$r];
                $item_option        = isset($_POST['product_option'][$r]) && !empty($_POST['product_option'][$r]) && $_POST['product_option'][$r] != 'false' ? $_POST['product_option'][$r] : null;
                $real_unit_cost     = $this->repairer->formatDecimal2($_POST['real_unit_cost'][$r]);
                $unit_cost          = $this->repairer->formatDecimal2($_POST['unit_cost'][$r]);
                $item_quantity = (0 - $_POST['quantity'][$r]);
                $item_tax_rate      = $_POST['product_tax'][$r]      ?? null;
                $item_discount      = $_POST['product_discount'][$r] ?? null;
                $item_unit          = $_POST['product_unit'][$r];
                $item_quantity      = (0 - $_POST['quantity'][$r]);

                if (isset($item_code) && isset($real_unit_cost) && isset($unit_cost) && isset($item_quantity)) {
                    $product_details = $this->purchases_model->getProductByCode($item_code);

                    $item_type        = $product_details->type;
                    $item_name        = $product_details->name;
                    $pr_discount      = $this->repairer->calculateDiscount($item_discount, $unit_cost);
                    $unit_cost        = $this->repairer->formatDecimal2($unit_cost - $pr_discount);
                    $pr_item_discount = $this->repairer->formatDecimal2(($pr_discount * $item_quantity), 4);
                    $product_discount += $pr_item_discount;
                    $item_net_cost = $unit_cost;
                    $pr_item_tax   = $item_tax   = 0;
                    $tax           = '';

                    if (isset($item_tax_rate) && $item_tax_rate != 0) {
                        $tax_details = $this->settings_model->getTaxRateByID($item_tax_rate);
                        $ctax        = $this->repairer->calculateTax($product_details, $tax_details, $unit_cost);
                        $item_tax    = $this->repairer->formatDecimal2($ctax['amount']);
                        $tax         = $ctax['tax'];
                        if ($product_details->tax_method != 1) {
                            $item_net_cost = $unit_cost - $item_tax;
                        }
                        $pr_item_tax = $this->repairer->formatDecimal2($item_tax * $item_quantity, 4);
                    }

                    $product_tax += $pr_item_tax;
                    $subtotal = $this->repairer->formatDecimal2((($item_net_cost * $item_quantity) + $pr_item_tax), 4);

                    $product = [
                        'product_id'        => $item_id,
                        'product_code'      => $item_code,
                        'product_name'      => $item_name,
                        'net_unit_cost'     => $item_net_cost,
                        'unit_cost'         => $this->repairer->formatDecimal2($item_net_cost + $item_tax),
                        'quantity'          => $item_quantity,
                        'quantity'     => $item_quantity,
                        'quantity_balance'  => $item_quantity,
                        'item_tax'          => $pr_item_tax,
                        'tax_rate_id'       => $item_tax_rate,
                        'tax'               => $tax,
                        'discount'          => $item_discount,
                        'item_discount'     => $pr_item_discount,
                        'subtotal'          => $this->repairer->formatDecimal2($subtotal),
                        'purchase_item_id'  => $purchase_item_id,
                        'status'            => 'received',
                    ];

                    $products[] = ($product);
                    $total += $this->repairer->formatDecimal2(($item_net_cost * $item_quantity), 4);
                }
            }
            if (empty($products)) {
                $this->form_validation->set_rules('product', lang('order_items'), 'required');
            } else {
                krsort($products);
            }



            $order_discount = $this->repairer->calculateDiscount($this->input->post('order_discount'), ($total + $product_tax), true);
            $total_discount = $this->repairer->formatDecimal2(($order_discount + $product_discount), 4);
            $order_tax      = $this->repairer->calculateOrderTax($this->input->post('order_tax'), ($total + $product_tax - $order_discount));
            $total_tax      = $this->repairer->formatDecimal2(($product_tax + $order_tax), 4);
            $grand_total    = $this->repairer->formatDecimal2(($this->repairer->formatDecimal2($total) + $this->repairer->formatDecimal2($total_tax) + $this->repairer->formatDecimal2($return_surcharge) - $this->repairer->formatDecimal2($order_discount)), 4);
            $data           = [
                'date' => $date,
                'purchase_id'         => $id,
                'reference_no'        => $purchase->reference_no,
                'supplier_id'         => $purchase->supplier_id,
                'supplier'            => $purchase->supplier,
                'note'                => $note,
                'total'               => $total,
                'product_discount'    => $product_discount,
                'order_discount_id'   => ($this->input->post('discount') ? $this->input->post('order_discount') : null),
                'order_discount'      => $order_discount,
                'total_discount'      => $total_discount,
                'product_tax'         => $product_tax,
                'order_tax_id'        => $this->input->post('order_tax'),
                'order_tax'           => $order_tax,
                'total_tax'           => $total_tax,
                'surcharge'           => $this->repairer->formatDecimal2($return_surcharge),
                'grand_total'         => $grand_total,
                'created_by'          => $this->session->userdata('user_id'),
                'return_purchase_ref' => $reference,
                'status'              => 'returned',

                'rma_number'        => $this->input->post('rma_number'),
                'return_status' => 1,
            ];
          
            if ($_FILES['document']['size'] > 0) {
                $this->load->library('upload');
                $config['upload_path']   = $this->digital_upload_path;
                $config['allowed_types'] = $this->digital_file_types;
                $config['max_size']      = $this->allowed_file_size;
                $config['overwrite']     = false;
                $config['encrypt_name']  = true;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('document')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER['HTTP_REFERER']);
                }
                $photo              = $this->upload->file_name;
                $data['attachment'] = $photo;
            }

        }

        if ($this->form_validation->run() == true && $this->purchases_model->addPurchase($data, $products)) {
            $this->session->set_flashdata('message', lang('return_purchase_added'));
            redirect('panel/purchases');
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

            $this->data['inv'] = $purchase;
            if ($this->data['inv']->status != 'received' && $this->data['inv']->status != 'partial') {
                $this->session->set_flashdata('error', lang('purchase_status_x_received'));
                redirect($_SERVER['HTTP_REFERER']);
            }

           
            
            $inv_items = $this->purchases_model->getAllPurchaseItems($id);
            $c = rand(100000, 9999999);

            $inv_items = $this->purchases_model->getAllPurchaseItems($id);
            $c = rand(100000, 9999999);
            foreach ($inv_items as $item) {
                $row                   = $this->purchases_model->getProductByID($item->product_id);

                $row->base_quantity    = $item->quantity;
                $row->base_unit        = $row->unit;
                $row->base_unit_cost   = $row->cost ? $row->cost : $item->unit_cost;
                $row->qty              = $item->quantity;
                $row->oqty             = $item->quantity;

                $row->purchase_item_id = $item->id;
                $row->received         = $item->quantity;
                $row->quantity_balance = $item->quantity_balance + ($item->quantity - $row->received);
                $row->discount         = $item->discount ? $item->discount : '0';
                
                $row->real_unit_cost   = $item->unit_cost;
                $row->cost             = $this->repairer->formatDecimal2($item->net_unit_cost + ($item->item_discount / $item->quantity));
                $row->tax_rate         = $item->tax_rate_id;
                
                unset($row->details, $row->product_details, $row->price, $row->file, $row->product_group_id);
                $tax_rate = $this->settings_model->getTaxRateByID($row->tax_rate);
                $ri       = $row->id;

                $pr[$ri] = ['id' => $c, 'item_id' => $row->id, 'label' => $row->name . ' (' . $row->code . ')', 'row' => $row, 'tax_rate' => $tax_rate, 'options' => null];

                $c++;
            }

            $this->data['inv_items'] = json_encode($pr);
            $this->data['id']        = $id;
            $this->data['reference'] = '';
            $this->data['tax_rates'] = $this->settings_model->getTaxRates();
            $this->render('purchases/return_purchase');
        }
    }

}
