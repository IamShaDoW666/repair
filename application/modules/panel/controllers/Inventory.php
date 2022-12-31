<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Inventory
 *
 *
 * @package     Repairer
 * @category    Controller
 * @author      Usman Sher
*/

// Includes all customers controller

class Inventory extends Auth_Controller
{
    // THE CONSTRUCTOR //
    public function __construct()
    {
        parent::__construct();
        $this->load->model('inventory_model');
        $this->load->library('repairer');
        $this->digital_upload_path = 'files/';
        $this->upload_path = 'assets/uploads/';
        $this->thumbs_path = 'assets/uploads/thumbs/';
        $this->image_types = 'gif|jpg|jpeg|png|tif';
        $this->digital_file_types = 'zip|psd|ai|rar|pdf|doc|docx|xls|xlsx|ppt|pptx|gif|jpg|jpeg|png|tif|txt';
        $this->allowed_file_size = '1048576';
        $this->popup_attributes = array('width' => '900', 'height' => '600', 'window_name' => 'sma_popup', 'menubar' => 'yes', 'scrollbars' => 'yes', 'status' => 'no', 'resizable' => 'yes', 'screenx' => '0', 'screeny' => '0');
    }

    function index()
    {
        $this->mPageTitle = lang('inventory_label');
        $this->repairer->checkPermissions();
        $this->render('inventory/index');
    }

    function getProducts()
    {
        $this->repairer->checkPermissions('index');
        $delete_link = "";
        if ($this->Admin || $this->GP['inventory-delete']) {
            $delete_link .= "<a class='dropdown-item' href='" . site_url('panel/inventory/delete/$1') . "' ><i class=\"fas fa-trash\"></i> "
            . lang('delete_product') . "</a>";
        }
        
        $single_barcode = anchor('panel/inventory/print_barcodes/$1', '<i class="fa fa-print"></i> ' . lang('print_barcode_label'), 'class="dropdown-item"');
        $action = '<div class="text-center"><div class="btn-group dropleft">'
            . '<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">'
            . lang('actions') . ' <span class="caret"></span></button>
        <ul class="dropdown-menu " role="menu">
            <a class="dropdown-item" href="' . site_url('panel/inventory/add/$1') . '"><i class="fa fa-plus-square"></i> ' . lang('duplicate_product') . '</a></li>
            <a class="dropdown-item" href="' . site_url('panel/inventory/edit/$1') . '"><i class="fa fa-edit"></i> ' . lang('edit_product') . '</a></li>';
        
        $action .=  $single_barcode  . $delete_link . '
            </ul>
        </div></div>';
        $this->load->library('datatables');
        
            $this->datatables
                ->select($this->db->dbprefix('inventory') . ".id as productid, image, {$this->db->dbprefix('inventory')}.code as code, {$this->db->dbprefix('inventory')}.name as name, cost as cost, price as price, COALESCE(quantity, 0) as quantity, alert_quantity", FALSE)
                ->from('inventory')
                ->where('isDeleted != ', 1)
                ->group_by("inventory.id");

        $this->datatables->add_column("Actions", $action, "productid, image, code, name");
        echo $this->datatables->generate();
    }

    function add($id = NULL)
    {
        $this->repairer->checkPermissions();
        $this->mPageTitle = lang('add_product');

        $this->load->helper('security');
        $this->form_validation->set_error_delimiters('', '');


        $this->form_validation->set_rules('code', ("product_code"), 'is_unique[inventory.code]|alpha_dash');

        if ($this->form_validation->run() == true) {
            $tax_rate = $this->input->post('tax_rate') ? $this->settings_model->getTaxRateByID($this->input->post('tax_rate')) : NULL;
            $data = array(
                'code' => $this->input->post('code'),
                'name' => $this->input->post('name'),
                'type' => $this->input->post('type'),
                'model_id' => $this->input->post('model'),
                'model_name' => $this->inventory_model->getModelNameByID($this->input->post('model')),
                'price' => ($this->input->post('price')),
                'image' => 'no_image.png',
                'cost' => NULL,
                'unit' => NULL,
                'tax_rate' => $this->input->post('tax_rate'),
                'tax_method' => ($this->input->post('tax_method')) ? $this->input->post('tax_method') : 0,
                'alert_quantity' => 0,
                'quantity' => 0,
                'details' => $this->input->post('details'),
                'category_id' => $this->input->post('category') ? $this->input->post('category') : NULL,
                'category' => $this->input->post('category') ? $this->settings_model->getCategoryByID($this->input->post('category'))->name : NULL,
                'subcategory_id' => $this->input->post('subcategory') ? $this->input->post('subcategory') : NULL,
                'subcategory' => $this->input->post('subcategory') ? $this->settings_model->getCategoryByID($this->input->post('subcategory'))->name : NULL,
                'supplier' => $this->input->post('supplier') ? implode(',', $this->input->post('supplier')) : null,
            );

            if ($this->input->post('type') == 'standard') {
                $data['cost'] = $this->input->post('cost') ? $this->input->post('cost') : 0;
                $data['unit'] = $this->input->post('unit');
                $data['quantity'] = ($this->input->post('quantity'));
                $data['alert_quantity'] = ($this->input->post('alert_quantity'));
            }

             $this->load->library('upload');
            if ($_FILES['product_image']['size'] > 0) {

                $config['upload_path'] = $this->upload_path;
                $config['allowed_types'] = $this->image_types;
                $config['max_size'] = $this->allowed_file_size;
                $config['max_width'] = $this->mSettings->iwidth;
                $config['max_height'] = $this->mSettings->iheight;
                $config['overwrite'] = FALSE;
                $config['max_filename'] = 25;
                $config['encrypt_name'] = TRUE;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('product_image')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect("panel/inventory/add");
                }
                $photo = $this->upload->file_name;
                $data['image'] = $photo;
                $this->load->library('image_lib');
                $config['image_library'] = 'gd2';
                $config['source_image'] = $this->upload_path . $photo;
                $config['new_image'] = $this->thumbs_path . $photo;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = $this->mSettings->twidth;
                $config['height'] = $this->mSettings->theight;
                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                if (!$this->image_lib->resize()) {
                    echo $this->image_lib->display_errors();
                }
                if ($this->mSettings->watermark) {
                    $this->image_lib->clear();
                    $wm['source_image'] = $this->upload_path . $photo;
                    $wm['wm_text'] = 'Copyright ' . date('Y') . ' - ' . $this->mSettings->site_name;
                    $wm['wm_type'] = 'text';
                    $wm['wm_font_path'] = 'system/fonts/texb.ttf';
                    $wm['quality'] = '100';
                    $wm['wm_font_size'] = '16';
                    $wm['wm_font_color'] = '999999';
                    $wm['wm_shadow_color'] = 'CCCCCC';
                    $wm['wm_vrt_alignment'] = 'top';
                    $wm['wm_hor_alignment'] = 'left';
                    $wm['wm_padding'] = '10';
                    $this->image_lib->initialize($wm);
                    $this->image_lib->watermark();
                }
                $this->image_lib->clear();
                $config = NULL;
            }
        }

        if ($this->form_validation->run() == true && $this->inventory_model->addProduct($data)) {
            $this->session->set_flashdata('message', ("product_added"));
            redirect('panel/inventory');
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['tax_rates'] = $this->settings_model->getTaxRates();
            $this->data['product'] = $id ? $this->inventory_model->getProductByID($id) : NULL;
            $this->data['categories'] = $this->settings_model->getAllCategories();
            $this->data['suppliers'] = $this->settings_model->getAllSuppliers();
            $this->render('inventory/add');
        }
    }

    function product_barcode($product_code = NULL, $bcs = 'code128', $height = 30)
    {
        $this->gen_barcode($product_code, $bcs, $height);
    }

    function barcode($product_code = NULL, $bcs = 'code128', $height = 60)
    {
        return site_url('panel/inventory/gen_barcode/' . $product_code . '/' . $bcs . '/' . $height);
    }

    function gen_barcode($product_code = NULL, $bcs = 'code128', $height = 60, $text = 1)
    {
        echo $this->repairer->barcode($product_code, $bcs, $height, false);
    }
    function print_barcodes($product_id = NULL)
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
                redirect("panel/inventory/print_barcodes");
            }
            for ($m = 0; $m < $s; $m++) {
                $pid = $_POST['product'][$m];
                $quantity = $_POST['quantity'][$m];
                $product = $this->inventory_model->getProductByID($pid);

                $barcodes[] = array(
                    'site' => $this->input->post('site_name') ? $this->mSettings->title : FALSE,
                    'name' => $this->input->post('product_name') ? $product->name : FALSE,
                    'barcode' => ($product->code),
                    'price' => $this->input->post('price') ? ($product->price) : FALSE,
                    'quantity' => $quantity
                );
            }
            $this->data['barcodes'] = $barcodes;
            $this->data['style'] = $style;
            $this->data['items'] = false;
            
            $this->render('inventory/print_barcodes');
        } else {
            if ($this->input->get('purchase')) {
                $purchase_id = $this->input->get('purchase', TRUE);
                $items = $this->inventory_model->getPurchaseItems($purchase_id);
                if ($items) {
                    foreach ($items as $item) {
                        if ($row = $this->inventory_model->getProductByID($item->product_id)) {
                             $pr[$row->id] = array('id' => $row->id, 'label' => $row->name . " (" . $row->code . ")", 'code' => $row->code, 'name' => $row->name, 'price' => $row->price, 'qty' => $item->quantity);
                                $this->session->set_flashdata('message',  lang('product_added_to_list'));
                        }
                    }
                    $this->data['message'] = lang('products_added_to_list');
                }
            }
            if ($product_id) {
                if ($row = $this->inventory_model->getProductByID($product_id)) {
                     $pr[$row->id] = array('id' => $row->id, 'label' => $row->name . " (" . $row->code . ")", 'code' => $row->code, 'name' => $row->name, 'price' => $row->price, 'qty' => $row->quantity > 0 ? $row->quantity : 1);
                        $this->session->set_flashdata('message',  lang('product_added_to_list'));
                }
            }
            $this->data['items'] = isset($pr) ? json_encode($pr) : false;
            $this->render('inventory/print_barcodes');

        }
    }

    function edit($id = NULL)
    {
        $this->mPageTitle = lang('edit_product');

        $this->repairer->checkPermissions();

        $this->load->helper('security');
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
        }
        $product = $this->inventory_model->getProductByID($id);
        if (!$id || !$product) {
            $this->session->set_flashdata('error', lang('prduct_not_found'));
            redirect($_SERVER["HTTP_REFERER"]);
        }
        if ($this->input->post('type') == 'standard') {
            $this->form_validation->set_rules('cost', lang("product_cost"), 'required');
        }
        $this->form_validation->set_rules('code', lang("product_code"), 'alpha_dash');
        if ($this->input->post('code') !== $product->code) {
            $this->form_validation->set_rules('code', ("product_code"), 'is_unique[inventory.code]');
        }
        if ($this->input->post('barcode_symbology') == 'ean13') {
            $this->form_validation->set_rules('code', lang("product_code"), 'min_length[13]|max_length[13]');
        }

        if ($this->form_validation->run('panel/inventory/edit') == true) {
            $data = array(
                'code' => $this->input->post('code'),
                'name' => $this->input->post('name'),
                'type' => $this->input->post('type'),
                'model_id' => $this->input->post('model'),
                'model_name' => $this->inventory_model->getModelNameByID($this->input->post('model')),
                'cost' => ($this->input->post('cost')),
                'price' => ($this->input->post('price')),
                'unit' => $this->input->post('unit'),
                'tax_rate' => $this->input->post('tax_rate'),
                'tax_method' => $this->input->post('tax_method'),
                'alert_quantity' => $this->input->post('alert_quantity'),
                'details' => $this->input->post('details'),
                'category_id' => $this->input->post('category') ? $this->input->post('category') : NULL,
                'category' => $this->input->post('category') ? $this->settings_model->getCategoryByID($this->input->post('category'))->name : NULL,
                'subcategory_id' => $this->input->post('subcategory') ? $this->input->post('subcategory') : NULL,
                'subcategory' => $this->input->post('subcategory') ? $this->settings_model->getCategoryByID($this->input->post('subcategory'))->name : NULL,
                'supplier' => $this->input->post('supplier') ? implode(',', $this->input->post('supplier')) : null,
            );
            
            
            $this->load->library('upload');
            if ($_FILES['product_image']['size'] > 0) {

                $config['upload_path'] = $this->upload_path;
                $config['allowed_types'] = $this->image_types;
                $config['max_size'] = $this->allowed_file_size;
                $config['max_width'] = $this->mSettings->iwidth;
                $config['max_height'] = $this->mSettings->iheight;
                $config['overwrite'] = FALSE;
                $config['max_filename'] = 25;
                $config['encrypt_name'] = TRUE;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('product_image')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect("panel/inventory/edit/".$id);
                }
                $photo = $this->upload->file_name;
                $data['image'] = $photo;
                $this->load->library('image_lib');
                $config['image_library'] = 'gd2';
                $config['source_image'] = $this->upload_path . $photo;
                $config['new_image'] = $this->thumbs_path . $photo;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = $this->mSettings->twidth;
                $config['height'] = $this->mSettings->theight;
                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                if (!$this->image_lib->resize()) {
                    echo $this->image_lib->display_errors();
                }
                if ($this->mSettings->watermark) {
                    $this->image_lib->clear();
                    $wm['source_image'] = $this->upload_path . $photo;
                    $wm['wm_text'] = 'Copyright ' . date('Y') . ' - ' . $this->mSettings->site_name;
                    $wm['wm_type'] = 'text';
                    $wm['wm_font_path'] = 'system/fonts/texb.ttf';
                    $wm['quality'] = '100';
                    $wm['wm_font_size'] = '16';
                    $wm['wm_font_color'] = '999999';
                    $wm['wm_shadow_color'] = 'CCCCCC';
                    $wm['wm_vrt_alignment'] = 'top';
                    $wm['wm_hor_alignment'] = 'left';
                    $wm['wm_padding'] = '10';
                    $this->image_lib->initialize($wm);
                    $this->image_lib->watermark();
                }
                $this->image_lib->clear();
                $config = NULL;
            }
        }

        if ($this->form_validation->run() == true && $this->inventory_model->updateProduct($id, $data)) {
            $this->session->set_flashdata('message', lang("product_updated"));
            redirect('panel/inventory');
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['tax_rates'] = $this->settings_model->getTaxRates();
            $this->data['product'] = $product;
            $this->data['categories'] = $this->settings_model->getAllCategories();
            $this->data['suppliers'] = $this->settings_model->getAllSuppliers();
            $this->render('inventory/edit');
        }
    }
    function delete($id = NULL)
    {
        $this->repairer->checkPermissions();

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }

        if ($this->inventory_model->deleteProduct($id)) {
            if($this->input->is_ajax_request()) {
                echo lang("product_deleted"); die();
            }
            $this->session->set_flashdata('message', lang('product_deleted'));
            redirect('panel/inventory');
        }

    }
    function modal_view($id = NULL)
    {
        $pr_details = $this->inventory_model->getProductByID($id);
        if (!$id || !$pr_details) {
            $this->session->set_flashdata('error', lang('prduct_not_found'));
            $this->repairer->md();
        }
        $this->data['barcode'] = "<img src='" . site_url('panel/inventory/gen_barcode/' . $pr_details->code . '/' . 'code128' . '/40/0') . "' alt='" . $pr_details->code . "' class='pull-left' />";
        
        $this->data['product'] = $pr_details;
        $this->data['tax_rate'] = $pr_details->tax_rate ? $this->settings_model->getTaxRateByID($pr_details->tax_rate) : NULL;
        $this->data['Settings'] = $this->mSettings;

        $this->load->view($this->theme . 'inventory/modal_view', $this->data);
    }


    // PRINT A SUPPLIERS PAGE //
    public function suppliers()
    {
        $this->mPageTitle = lang('suppliers');
        $this->repairer->checkPermissions();
        $this->render('inventory/suppliers_index');
    }

    // GENERATE THE AJAX TABLE CONTENT //
    public function getAllSuppliers()
    {
        $this->load->library('datatables');
        $this->datatables
            ->select('id, name, company, phone, email, city, country, vat_no')
            ->from('suppliers');
        $actions = '<div class="text-center"><div class="btn-group dropleft">'
            . '<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">'
            . lang('actions') . ' <span class="caret"></span></button>
        <ul class="dropdown-menu pull-right" role="menu">';

        $actions .= "<a class='dropdown-item view_supplier' data-dismiss='modal' href='#view_supplier' data-toggle='modal' data-num='$1'><i class='fas fa-check'></i> ".lang('view_supplier')."</a>";
        if ($this->Admin || $this->GP['inventory-edit_supplier']) {
            $actions .= "<a class='dropdown-item'  data-dismiss='modal' id='modify_supplier' href='#suppliermodal' data-toggle='modal' data-num='$1'><i class='fas fa-edit'></i> ".lang('edit_supplier')."</a>";
        }
        if ($this->Admin || $this->GP['inventory-delete_supplier']) {
        $actions .= "<a class='dropdown-item' id='delete' data-num='$1'><i class='fas fa-trash'></i> ".lang('delete_supplier')."</a>";
        }
        $actions .= '</ul></div>';

        $this->datatables->add_column('actions', $actions, 'id');
        $this->datatables->unset_column('id');
        echo $this->datatables->generate();
    }
    
    // ADD A CUSTOMER //
    public function add_supplier()
    {
        $this->repairer->checkPermissions();

        $data = array(
            'name'      => $this->input->post('name', true),
            'company'   => $this->input->post('company', true),
            'address'   => $this->input->post('address', true),
            'city'      => $this->input->post('city', true),
            'country'   => $this->input->post('country', true),
            'state'     => $this->input->post('state', true),
            'postal_code'  => $this->input->post('postal_code', true),
            'phone'     => $this->input->post('phone', true),
            'email'     => $this->input->post('email', true),
            'vat_no'    => $this->input->post('vat_no', true),
        );

        echo $this->inventory_model->insert_supplier($data);
    }

    // EDIT CUSTOMER //
    public function edit_supplier()
    {
        $this->repairer->checkPermissions();

        $id = $this->input->post('id', true);
        $data = array(
            'name'      => $this->input->post('name', true),
            'company'   => $this->input->post('company', true),
            'address'   => $this->input->post('address', true),
            'city'      => $this->input->post('city', true),
            'country'   => $this->input->post('country', true),
            'state'     => $this->input->post('state', true),
            'postal_code'  => $this->input->post('postal_code', true),
            'phone'     => $this->input->post('phone', true),
            'email'     => $this->input->post('email', true),
            'vat_no'    => $this->input->post('vat_no', true),
        );
        $token = $this->input->post('token', true);
        echo $this->inventory_model->edit_supplier($id, $data);
       
    }

    // DELETE CUSTOMER 
    public function delete_supplier()
    {
        $this->repairer->checkPermissions();

        $id = $this->security->xss_clean($this->input->post('id', true));
        $data = $this->inventory_model->delete_supplier($id);
        echo json_encode($data);
    }

    // GET CUSTOMER AND SEND TO AJAX FOR SHOW IT //
    public function getSupplierByID()
    {
        $id = $this->security->xss_clean($this->input->post('id', true));
        $data = $this->inventory_model->find_supplier($id);
        $token = $this->input->post('token', true);
        echo json_encode($data);
    }

    ///////////////////////////////////////
    // PRINT A Models PAGE //
    public function models()
    {
        $this->mPageTitle = lang('models');
        $this->repairer->checkPermissions();
        $this->render('inventory/model_index');
    }

    // GENERATE THE AJAX TABLE CONTENT //
    public function getAllModels()
    {
        $this->load->library('datatables');
        $this->datatables
            ->select("{$this->db->dbprefix('models')}.id as id, {$this->db->dbprefix('models')}.name, c.name as parent", FALSE)
            ->from("models")
            ->join("models c", 'c.id=models.parent_id', 'left')
            ->where('models.parent_id !=', 0)
            ->group_by('models.id');

        $actions = '';
        if ($this->Admin || $this->GP['inventory-edit_model']) {
            $actions .= "<a  class='btn btn-sm btn-primary' id='modify_model' data-num='$1'><i class='fas fa-edit'></i></a> ";
        }

        if ($this->Admin || $this->GP['inventory-delete_model']) {
            $actions .= "<a class='btn btn-sm btn-danger' id='delete' data-num='$1'><i class='fas fa-trash'></i></a>";
        }

        $this->datatables->add_column('actions', $actions, 'id');
        $this->datatables->unset_column('id');
        echo $this->datatables->generate();
    }
    
    // ADD A CUSTOMER //
    public function add_model()
    {
        $this->repairer->checkPermissions();
        $manufacturer = ($this->input->post('parent_id'));
        if ($mdata = $this->inventory_model->getManufacturerByName($manufacturer)) {
            $parent_id = $mdata->id;
        }else{
            $parent_id = $this->inventory_model->addManufacturer(array(
                'name' => $manufacturer,
                'parent_id' => 0
            ));
        }
        $models = $this->input->post('name');
        $data = array();
        foreach ($models as $model) {
            $mdata = $this->inventory_model->getModelByName($model);
            if (!$mdata) {
                $data[] = array(
                    'name'      => $model,
                    'parent_id' => $parent_id,
                );
            }
        }
        $this->db->insert_batch('models' ,$data);
        echo 'true';
    }

    // EDIT CUSTOMER //
    public function edit_model()
    {
        $this->repairer->checkPermissions();
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $this->db->where('id', $id)->update('models', array('name'=>$name));
        echo $this->repairer->send_json(array('success'=>true));
    }

    // DELETE CUSTOMER 
    public function delete_model()
    {
        $this->repairer->checkPermissions();

        $id = $this->security->xss_clean($this->input->post('id', true));
        $data = $this->inventory_model->delete_model($id);
        echo json_encode($data);
    }


    // GET MODEL BY ID //
    public function getModelByID()
    {
        $id = $this->security->xss_clean($this->input->post('id', true));
        $data = $this->inventory_model->find_model($id);
        echo $this->repairer->send_json($data);
    }


    // GET Manufacturer BY ID //
    public function getManufacturerByID()
    {
        $id = $this->security->xss_clean($this->input->post('id', true));
        $data = $this->inventory_model->find_manufacturer($id);
        echo $this->repairer->send_json($data);
    }

    ///////////////////////////////////////
    // PRINT A Models PAGE //
    public function manufacturers()
    {
        $this->mPageTitle = lang('manufacturers');
        $this->repairer->checkPermissions();
        $this->render('inventory/manufacturer_index');
    }

    // GENERATE THE AJAX TABLE CONTENT //
    public function getAllManufacturers()
    {
        $this->load->library('datatables');
        $this->datatables
            ->select("id, name")
            ->from("models")
            ->where('parent_id', 0)
            ->or_where('parent_id', null);

        $actions = '';
        if ($this->Admin || $this->GP['inventory-edit_manufacturer']) {
            $actions .= "<a class='btn btn-primary btn-sm' id='modify_manufacturer' data-num='$1'><i class='fas fa-edit'></i> </a> ";
        }

        if ($this->Admin || $this->GP['inventory-delete_manufacturer']) {
        $actions .= "<a class='btn btn-danger btn-sm' id='delete' data-num='$1'><i class='fas fa-trash'></i> </a>";
        }

        $this->datatables->add_column('actions', $actions, 'id');
        $this->datatables->unset_column('id');
        echo $this->datatables->generate();
    }
    
    // ADD A CUSTOMER //
    public function add_manufacturer()
    {
        $this->repairer->checkPermissions();
        $manufacturer = ($this->input->post('name'));
        $parent_id = null;
        if ($mdata = $this->inventory_model->getManufacturerByName($manufacturer)) {
            $success = false;
        }else{
            $parent_id = $this->inventory_model->addManufacturer(array(
                'name' => $manufacturer,
                'parent_id' => 0
            ));
        }
        if ($parent_id) {
            echo $this->repairer->send_json(array('success'=>true));
        }else{
            echo $this->repairer->send_json(array('success'=>false));
        }
    }

    // EDIT CUSTOMER //
    public function edit_manufacturer()
    {
        $this->repairer->checkPermissions();
        $id = $this->input->post('id');
        $name = $this->input->post('name');

        $this->db->where('id', $id)->update('models', array('name'=>$name));
        echo $this->repairer->send_json(array('success'=>true));
    }

    // DELETE CUSTOMER 
    public function delete_manufacturer()
    {
        $this->repairer->checkPermissions();
        $id = $this->security->xss_clean($this->input->post('id', true));
        $success = $this->inventory_model->delete_manufacturer($id);
        echo $this->repairer->send_json(array(
            'success' => $success,
        ));
    }


  
    function suggestions()
    {
        $term = $this->input->get('term', TRUE);
        if ($this->mSettings->model_based_search) {
            $model_id = $this->input->get('model_id', TRUE) ? $this->input->get('model_id', TRUE) : FALSE;
        }else{
            $model_id = FALSE;
        }
        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . site_url('welcome') . "'; }, 10);</script>");
        }
        $rows = $this->inventory_model->getProductNames($term, 5, $model_id);
        if ($rows) {
            foreach ($rows as $row) {

                $pr[] = array('id' => $row->id, 'label' => $row->code . ' - ' . $row->name , 'code' => $row->code, 'name' => $row->name, 'price' => $row->price, 'qty' => 1, 'available_now' => $row->quantity, 'total_qty' => $row->quantity, 'type' => $row->type);
            }
            $this->repairer->send_json($pr);
        } else {
            $this->repairer->send_json(array(array('id' => 0, 'label' => lang('no_match_found'), 'value' => $term)));
        }
    }
    function product_actions($wh = NULL)
    {
       
        $this->repairer->checkPermissions();
        $this->form_validation->set_rules('form_action', lang("form_action"), 'required');

        if ($this->form_validation->run() == true) {

            if (!empty($_POST['val'])) {
                if ($this->input->post('form_action') == 'delete') {
                    foreach ($_POST['val'] as $id) {
                        $this->inventory_model->deleteProduct($id);
                    }
                    $this->session->set_flashdata('message', $this->lang->line("products_deleted"));
                    redirect($_SERVER["HTTP_REFERER"]);

                } elseif ($this->input->post('form_action') == 'labels') {
                    foreach ($_POST['val'] as $id) {
                        $row = $this->inventory_model->getProductByID($id);
                        if($row->type != 'service'){
                            $pr[$row->id] = array('id' => $row->id, 'label' => $row->name . " (" . $row->code . ")", 'code' => $row->code, 'name' => $row->name, 'price' => $row->price, 'qty' => $row->quantity);

                        }
                    }
                    $this->data['items'] = isset($pr) ? json_encode($pr) : false;
                    $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
                    $this->render('inventory/print_barcodes');

                } elseif ($this->input->post('form_action') == 'export_excel' || $this->input->post('form_action') == 'export_pdf') {

                    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
                    $sheet = $spreadsheet->getActiveSheet();

                    $sheet->setTitle('Products');
                    $sheet->SetCellValue('A1', lang('code'));
                    $sheet->SetCellValue('B1', lang('name'));
                    $sheet->SetCellValue('C1', lang('model'));
                    $sheet->SetCellValue('D1', lang('cost'));
                    $sheet->SetCellValue('E1', lang('price'));
                    $sheet->SetCellValue('F1', lang('alert_quantity'));
                    $sheet->SetCellValue('G1', lang('tax_rate'));
                    $sheet->SetCellValue('H1', lang('tax_method'));
                    $sheet->SetCellValue('I1', lang('quantity'));
                    $sheet->SetCellValue('J1', lang('type'));

                    $row = 2;
                    foreach ($_POST['val'] as $id) {
                        $product = $this->inventory_model->getProductByID($id);
                        $tax_rate = $this->settings_model->getTaxRateByID($product->tax_rate);
                        $quantity = $product->quantity;

                        $sheet->SetCellValue('A' . $row, $product->code);
                        $sheet->SetCellValue('B' . $row, $product->name);
                        $sheet->SetCellValue('C' . $row, ($product->model_name));
                        $sheet->SetCellValue('D' . $row, $this->repairer->formatDecimal($product->cost));
                        $sheet->SetCellValue('E' . $row, $product->price);
                        $sheet->SetCellValue('F' . $row, $product->alert_quantity);
                        $sheet->SetCellValue('G' . $row, $tax_rate->name);
                        $sheet->SetCellValue('H' . $row, $product->tax_method ? lang('exclusive') : lang('inclusive'));
                        $sheet->SetCellValue('I' . $row, $quantity);
                        $sheet->SetCellValue('J' . $row, $product->type);
                        $row++;
                    }

                    $sheet->getColumnDimension('A')->setWidth(15);
                    $sheet->getColumnDimension('B')->setWidth(20);
                    $sheet->getColumnDimension('C')->setWidth(10);
                    $sheet->getColumnDimension('D')->setWidth(10);
                    $sheet->getColumnDimension('E')->setWidth(10);
                    $sheet->getColumnDimension('F')->setWidth(10);
                    $sheet->getColumnDimension('G')->setWidth(10);
                    $sheet->getParent()->getDefaultStyle()->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                    $filename = 'products_' . date('Y_m_d_H_i_s');
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
                        $sheet->getStyle('A0:J'.($row-1))->applyFromArray($styleArray);
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
                $this->session->set_flashdata('error', $this->lang->line("no_product_selected"));
                redirect($_SERVER["HTTP_REFERER"]);
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        }
    }

    function getSubCategories($category_id = NULL)
    {
        if ($rows = $this->inventory_model->getSubCategories($category_id)) {
            $data = json_encode($rows);
        } else {
            $data = 'null';
        }
        echo $data;
    }

    public function getModels($term = null)
    {
        $manufacturer = $this->input->get('manufacturer');
        if ($mdata = $this->inventory_model->getManufacturerByName($manufacturer)) {
            $this->db->where('parent_id', $mdata->id);
        }   
        if ($term) {
            $this->db->like('name', $term);
        }
        $q = $this->db->where('parent_id !=', 0)->get('models');
        $names = array();
        if ($q->num_rows() > 0) {
            $names = $q->result_array();
        }
        echo $this->repairer->send_json($names);
    }


    function import_csv()
    {
        $this->load->helper('security');
        $this->form_validation->set_rules('userfile', lang("upload_file"), 'xss_clean');

        if ($this->form_validation->run() == true) {

            if (isset($_FILES["userfile"])) {

                $this->load->library('upload');
                $config['upload_path'] = $this->digital_upload_path;
                $config['allowed_types'] = 'csv';
                $config['max_size'] = $this->allowed_file_size;
                $config['overwrite'] = TRUE;
                $config['encrypt_name'] = FALSE;
                $config['max_filename'] = 25;
                $this->upload->initialize($config);

                if (!$this->upload->do_upload()) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect("panel/inventory/import_csv");
                }

                $csv = $this->upload->file_name;

                $arrResult = array();
                $handle = fopen($this->digital_upload_path . $csv, "r");
                if ($handle) {
                    while (($row = fgetcsv($handle, 5000, ",")) !== FALSE) {
                        $arrResult[] = $row;
                    }
                    fclose($handle);
                }
                $titles = array_shift($arrResult);
                $updated = 0; $items = array();

                foreach ($arrResult as $key => $value) {

                    $item = [
                        'type'              => isset($value[0]) ? trim($value[0]) : '',
                        'name'              => isset($value[1]) ? trim($value[1]) : '',
                        'code'              => isset($value[2]) ? trim($value[2]) : '',
                        'category_code'     => isset($value[3]) ? trim($value[3]) : '',
                        'subcategory_code'  => isset($value[4]) ? trim($value[4]) : '',
                        'model_name'        => isset($value[5]) ? trim($value[5]) : '',
                        'cost'              => isset($value[6]) ? trim($value[6]) : '',
                        'price'             => isset($value[7]) ? trim($value[7]) : '',
                        'quantity'          => isset($value[8]) ? trim($value[8]) : '',
                        'alert_quantity'    => isset($value[9]) ? trim($value[9]) : '',
                        'supplier'          => isset($value[10]) ? trim($value[10]) : '',
                        'tax_rate'          => isset($value[11]) ? trim($value[11]) : '',
                        'tax_method'        => isset($value[12]) ? (trim($value[12]) == 'exclusive' ? 1 : 0) : '',
                        'image'             => isset($value[13]) ? trim($value[13]) : 'no_image.png',
                        'details'           => isset($value[14]) ? trim($value[14]) : '',
                        'isDeleted'         => 0,
                    ];

                    
                    if ($catd = $this->inventory_model->getCategoryByCode($item['category_code'])) {
                        $tax_details = $this->inventory_model->getTaxRateByName($item['tax_rate']);
                        $prsubcat = $this->inventory_model->getCategoryByCode($item['subcategory_code']);
                        unset($item['category_code'], $item['subcategory_code']);

                        $item['tax_rate'] = $tax_details ? $tax_details->id : NULL;
                        $item['category_id'] = $catd->id;
                        $item['subcategory_id'] = $prsubcat ? $prsubcat->id : NULL;
                        $item['category'] = $catd->name;
                        $item['subcategory'] = $prsubcat ? $prsubcat->name : NULL;

                    } else {
                        $this->session->set_flashdata('error', lang("check_category_code") . " (" . $item['category_code'] . "). " . lang("category_code_x_exist") . " " . lang("line_no") . " " . ($key+1));
                        redirect("panel/inventory/import_csv");
                    }

                    // Supplier
                    if ($item['supplier'] !== '') {
                        $suppliers = explode(',', $item['supplier']);
                        $found_suppliers = array();
                        foreach ($suppliers as $supplier) {
                            $data_supplier = $this->inventory_model->getSupplierByName($supplier);
                            if ($data_supplier ) {
                                $found_suppliers[] = $data_supplier->id;
                            }
                        }
                        $item['supplier'] = implode(',', $found_suppliers);
                    }else{
                        unset($item['supplier']);
                    }
                    

                    if ($item['model_name'] !== '') {
                        if ($model = $this->inventory_model->getModelByNameC(strtolower($item['model_name']))) {
                            $item['model_id'] = $model ? $model->id : 1;
                        }else{
                            $this->db->insert('models', ['name'=>$item['model_name'], 'parent_id' => 0]);
                            $item['model_id'] = $this->db->insert_id();

                        }
                    }
                    

                  
                    if ($product = $this->inventory_model->getProductByCode($item['code'])) {
                        $this->inventory_model->updateProduct($product->id, $item);
                        $item = false;
                    }else{
                        $items[] = $item;
                    }

                }
            }
        }

        if ($this->form_validation->run() == true && !empty($items)) {
            if ($this->inventory_model->add_products($items)) {
                $updated = $updated ? '<p>'.sprintf(lang("products_updated"), $updated).'</p>' : '';
                $this->session->set_flashdata('message', sprintf(lang("products_added"), count($items)).$updated);
                redirect('panel/inventory');
            }
        } else {
            if (isset($items) && empty($items)) {
                if ($updated) {
                    $this->session->set_flashdata('message', sprintf(lang("products_updated"), $updated));
                    redirect('panel/inventory');
                } else {
                    $this->session->set_flashdata('warning', lang('csv_issue'));
                }
                redirect('panel/inventory/import_csv');
            }

            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['userfile'] = array('name' => 'userfile',
                'id' => 'userfile',
                'type' => 'text',
                'value' => $this->form_validation->set_value('userfile')
            );

            $this->render('inventory/import_csv');

        }
    }
}