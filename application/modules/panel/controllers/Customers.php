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

class Customers extends Auth_Controller
{
	// THE CONSTRUCTOR //
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Customers_model');
        $this->upload_path = 'assets/uploads/images';
        $this->image_types = 'gif|jpg|jpeg|png|tif';
        $this->allowed_image_size = 10000;
        $this->load->library('upload');
    }

	// PRINT A CUSTOMERS PAGE //
    public function index()
    {
        $this->mPageTitle = lang('clients');
        $this->repairer->checkPermissions('index');
        $this->render('clients/index');
    }

	// GENERATE THE AJAX TABLE CONTENT //
    public function getAllCustomers()
    {
        $this->repairer->checkPermissions('index');
        $this->load->library('datatables');
        $this->datatables
            ->select('clients.id as id, clients.name as name, company, address, clients.email as email, clients.telephone as telephone, image, (SELECT COUNT(reparation.id) FROM reparation WHERE reparation.client_id=clients.id) as total_repairs, (SELECT SUM(reparation.grand_total) FROM reparation WHERE reparation.client_id=clients.id) as sum')
            ->from('clients');


        $actions = '<div class="text-center"><div class="btn-group dropleft">'
            . '<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">'
            . ('actions') . ' <span class="caret"></span></button>
        <ul class="dropdown-menu" role="menu">';

        $actions .= "<a data-dismiss='modal' class='view_client dropdown-item' href='#view_client' data-toggle='modal' data-num='$1'><i class='fas fa-check'></i> ".lang('view_client')."</a>";
        


        $actions .= "<a class='dropdown-item' data-dismiss='modal' id='modify_client' href='#clientmodal' data-toggle='modal' data-num='$1'><i class='fas fa-edit'></i> ".lang('edit_client')."</a>";


        $actions .= "<a class='dropdown-item' id='delete_client' data-num='$1'><i class='fas fa-trash'></i> ".lang('delete_client')."</a>";
        $actions .= "<a class='dropdown-item' id='view_image' data-num='$2'><i class='fas fa-image'></i> ".lang('view_image')."</a>";
        $actions .= '</ul></div>';


        $this->datatables->add_column('actions', $actions, 'id, image');
        $this->datatables->unset_column('image');
        echo $this->datatables->generate();
    }

    // PRINT A CUSTOMERS PAGE //
    public function view_repairs($id=NULL)
    {
        $this->mPageTitle = lang('clients');
        $data['settings'] = $this->mSettings;
        $data['id'] = $id;
        $this->load->view($this->theme . 'clients/getRepairs', $data);
    }

    // GENERATE THE AJAX TABLE CONTENT //
    public function getClientRepairs($id = NULL)
    {
        $this->repairer->checkPermissions('index');
        $this->load->library('datatables');
        $this->datatables
            ->select('reparation.id as id, code, name, reparation.imei as imei, telephone, defect, model_name, date_opening, a.first_name, (SELECT CONCAT(first_name, " ", last_name) FROM users WHERE reparation.updated_by = users.id) as modified_by, (SELECT COUNT(attachments.id) FROM attachments WHERE reparation_id=reparation.id) as attached, grand_total')
            ->join('users a', 'a.id=reparation.created_by', 'left')
            ->where('client_id', $id)
            ->from('reparation');
        echo $this->datatables->generate();
    }
	
    
	// ADD A CUSTOMER //
    public function add()
    {

        $this->repairer->checkPermissions();

        $name = $this->input->post('name', true);
        $company = $this->input->post('company', true);
        $address = $this->input->post('address', true);
        $city = $this->input->post('city', true);
        $postal_code = $this->input->post('postal_code', true);
        $telephone = $this->input->post('telephone', true);
        $email = $this->input->post('email', true);
        $comment = $this->input->post('comment', true);
        $vat = $this->input->post('vat', true);
        $cf = $this->input->post('cf', true) ?? '';
		

        $this->form_validation->set_rules('telephone', lang('client_telephone'), 'is_unique[clients.telephone]');

        if ($this->form_validation->run() == true) {

            $data = array(
                'name' => $name,
                'company' => $company,
                'telephone' => $telephone,
                'address' => $address,
                'city' => $city,
                'postal_code' => $postal_code,
                'email' => $email,
                'date' => date('Y-m-d H:i:s'),
                'comment' => $comment,
                'vat' => $vat,
                'cf' => $cf,
                'image' => null,
            );




            $error = null;
            if (isset($_FILES['image'])) {
                if ($_FILES['image']['size'] > 0) {
                    $config['upload_path'] = $this->upload_path;
                    $config['allowed_types'] = $this->image_types;
                    $config['max_size'] = $this->allowed_image_size;
                    $config['max_width'] = $this->mSettings->iwidth;
                    $config['max_height'] = $this->mSettings->iheight;
                    $config['overwrite'] = FALSE;
                    $config['max_filename'] = 25;
                    $config['encrypt_name'] = TRUE;
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('image')) {
                        $error = $this->upload->display_errors();
                    }else{
                        $upload_file = $this->upload->file_name;
                        $data['image'] = $upload_file;
                        $config = NULL;
                    }
                }
            }

            $id = $this->Customers_model->insert_client($data);
            echo $this->repairer->send_json(array('success' => true, 'id'=>$id, 'error'=>$error));
        }else{
            echo $this->repairer->send_json(array('success' => false, 'error'=>validation_errors()));

        }
    }

	// EDIT CUSTOMER //
    public function edit()
    {

        $this->repairer->checkPermissions();
        $id = $this->input->post('id', true);
        $name = $this->input->post('name', true);
        $company = $this->input->post('company', true);
        $address = $this->input->post('address', true);
        $city = $this->input->post('city', true);
        $postal_code = $this->input->post('postal_code', true);
        $telephone = $this->input->post('telephone', true);
        $email = $this->input->post('email', true);
        $comment = $this->input->post('comment', true);
        $vat = $this->input->post('vat', true);
        $cf = $this->input->post('cf', true);


        $customer = $this->Customers_model->find_customer($id);

        $this->form_validation->set_rules('name', lang('client_name'), 'required');
        if ($customer['telephone'] !== $this->input->post('telephone')) {
            $this->form_validation->set_rules('telephone', lang('client_telephone'), 'is_unique[clients.telephone]');
        }

        if ($this->form_validation->run() == true) {
            $data = array(
                'name' => $name,
                'company' => $company,
                'telephone' => $telephone,
                'address' => $address,
                'city' => $city,
                'postal_code' => $postal_code,
                'email' => $email,
                'comment' => $comment,
                'vat' => $vat,
                'cf' => $cf
            );

            $error = null;
            if (isset($_FILES['image'])) {
                if ($_FILES['image']['size'] > 0) {
                    $config['upload_path'] = $this->upload_path;
                    $config['allowed_types'] = $this->image_types;
                    $config['max_size'] = $this->allowed_image_size;
                    $config['max_width'] = $this->mSettings->iwidth;
                    $config['max_height'] = $this->mSettings->iheight;
                    $config['overwrite'] = FALSE;
                    $config['max_filename'] = 25;
                    $config['encrypt_name'] = TRUE;
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('image')) {
                        $error = $this->upload->display_errors();
                    }else{
                        $upload_file = $this->upload->file_name;
                        $data['image'] = $upload_file;
                        $config = NULL;
                    }
                }
            }
            $this->Customers_model->edit_client($id, $data);
            echo $this->repairer->send_json(array('success' => true, 'id'=>$id, 'error'=>$error));
        }else{
            echo $this->repairer->send_json(array('success' => false, 'error'=>validation_errors()));

        }
    }

	// DELETE CUSTOMER 
    public function delete()
    {
        $this->repairer->checkPermissions();
		$id = $this->security->xss_clean($this->input->post('id', true));
        $data = $this->Customers_model->delete_clients($id);
        echo json_encode($data);
    }

    public function delete_image()
    {
        $id = $this->security->xss_clean($this->input->post('id', true));
        $this->db->where('id', $id);
        $this->db->update('clients', array('image'=>null));
         $this->settings_model->addLog('delete-image', 'customer', $id, json_encode(array(
            
        )));
        echo $this->repairer->send_json(array('success'=>true));
    }
	// GET CUSTOMER AND SEND TO AJAX FOR SHOW IT //
    public function getCustomerByID()
    {
        $id = $this->security->xss_clean($this->input->post('id', true));
		$data = $this->Customers_model->find_customer($id);
		$token = $this->input->post('token', true);
        echo json_encode($data);
    }

    function export_csv() {

        $q = $this->db
            ->select('id, name, company, address, email, telephone, image, city, postal_code, vat, comment')
            ->from('clients')->get();

        $customers = array();
        if ($q->num_rows() > 0) {
            $customers = $q->result();
        }

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle('Customers');
        $sheet->SetCellValue('A1', lang('client_company'));
        $sheet->SetCellValue('B1', lang('name'));
        $sheet->SetCellValue('C1', lang('client_telephone'));
        $sheet->SetCellValue('D1', lang('client_email'));
        $sheet->SetCellValue('E1', lang('client_address'));
        $sheet->SetCellValue('F1', lang('client_city'));
        $sheet->SetCellValue('G1', lang('client_postal_code'));
        $sheet->SetCellValue('H1', lang('client_vat'));
        $sheet->SetCellValue('I1', lang('client_comment'));


        $row = 2;

        foreach ($customers as $customer) {
            $sheet->SetCellValue('A' . $row, $customer->company);
            $sheet->SetCellValue('B' . $row, $customer->name);
            $sheet->SetCellValue('C' . $row, $customer->telephone);
            $sheet->SetCellValue('D' . $row, $customer->email);
            $sheet->SetCellValue('E' . $row, $customer->address);
            $sheet->SetCellValue('F' . $row, $customer->city);
            $sheet->SetCellValue('G' . $row, $customer->postal_code);
            $sheet->SetCellValue('H' . $row, $customer->vat);
            $sheet->SetCellValue('I' . $row, $customer->comment);
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
        $filename = 'customers' . date('Y_m_d_H_i_s');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'.csv"');
        header('Cache-Control: max-age=0');

        $writer = PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Csv');
        $writer->save('php://output');
        exit();

    }




    function import_csv()
    {
        $this->repairer->checkPermissions('add', true);
        $this->load->helper('security');
        $this->form_validation->set_rules('csv_file', lang("upload_file"), 'xss_clean');
        if ($this->form_validation->run() == true) {
            if (isset($_FILES["csv_file"])) {
                $this->load->library('upload');
                $config['upload_path'] = 'files';
                $config['allowed_types'] = 'csv';
                $config['max_size'] = '2000';
                $config['overwrite'] = FALSE;
                $config['encrypt_name'] = TRUE;
            
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('csv_file')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect("panel/customers");
                }
                $csv = $this->upload->file_name;
                $arrResult = array();
                $handle = fopen('files/' . $csv, "r");

                if ($handle) {
                    while (($row = fgetcsv($handle, 5000, ",")) !== FALSE) {
                        $arrResult[] = $row;
                    }
                    fclose($handle);
                }


                $titles = array_shift($arrResult);
                $keys = array('company', 'name', 'telephone', 'email', 'address', 'city', 'postal_code', 'vat', 'comment');

                $final = array();
                $data = array();

                foreach ($arrResult as $key => $value) {
                    $final[] = array_combine($keys, $value);
                }

                $updated = false;
                foreach ($final as $record) {
                    $record['date'] = date('Y-m-d');
                    if ($record['email'] !== '') {
                        if ($client_ = $this->Customers_model->getCustomerByEmail($record['email'])) {
                            $updated = true;
                            $this->db->where('id', $client_->id)->update('clients', $record);
                            continue;
                        }
                    }

                    $data[] = $record;
                }
            }

        } elseif ($this->input->post('import')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('panel/customers');
        }

        if ($this->form_validation->run() == true) {
            if (!empty($data)) {
                if ($this->Customers_model->addCustomers($data)) {
                    $this->session->set_flashdata('message', lang("customers_added"));
                }
            }elseif ($updated) {
                $this->session->set_flashdata('message', lang("customers_updated"));
            }  
            redirect('panel/customers');
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->load->view($this->theme . 'clients/import', $this->data);
        }
    }


    function customer_actions()
    {
       
        $this->repairer->checkPermissions();
        $this->form_validation->set_rules('form_action', lang("form_action"), 'required');

        if ($this->form_validation->run() == true) {

            if (!empty($_POST['val'])) {
                if ($this->input->post('form_action') == 'delete') {
                    foreach ($_POST['val'] as $id) {
                        $this->db->delete('clients', array('id'=>$id));
                    }
                    $this->session->set_flashdata('message', $this->lang->line("clients_deleted"));
                    redirect($_SERVER["HTTP_REFERER"]);

                }elseif ($this->input->post('form_action') == 'export_excel' || $this->input->post('form_action') == 'export_pdf') {

                    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
                    $sheet = $spreadsheet->getActiveSheet();

                    $sheet->setTitle('Customers');
                    $sheet->SetCellValue('A1', lang('client_name'));
                    $sheet->SetCellValue('B1', lang('client_company'));
                    $sheet->SetCellValue('C1', lang('client_address'));
                    $sheet->SetCellValue('D1', lang('client_city'));
                    $sheet->SetCellValue('E1', lang('client_postal_code'));
                    $sheet->SetCellValue('F1', lang('client_telephone'));
                    $sheet->SetCellValue('G1', lang('client_email'));
                    $sheet->SetCellValue('H1', lang('client_vat'));
                    $sheet->SetCellValue('I1', lang('client_comment'));


                    $row = 2;
                    foreach ($_POST['val'] as $id) {
                        $client = $this->Customers_model->find_customer($id);
                        $sheet->SetCellValue('A' . $row, $client['name']);
                        $sheet->SetCellValue('B' . $row, $client['company']);
                        $sheet->SetCellValue('C' . $row, $client['address']);
                        $sheet->SetCellValue('D' . $row, $client['city']);
                        $sheet->SetCellValue('E' . $row, $client['postal_code']);
                        $sheet->SetCellValue('F' . $row, $client['telephone']);
                        $sheet->SetCellValue('G' . $row, $client['email']);
                        $sheet->SetCellValue('H' . $row, $client['vat']);
                        $sheet->SetCellValue('I' . $row, $client['comment']);
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
                    $filename = 'customers' . date('Y_m_d_H_i_s');
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
                $this->session->set_flashdata('error', $this->lang->line("no_customer_selected"));
                redirect($_SERVER["HTTP_REFERER"]);
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        }
    }



    public function getAjax($show_walk = 'show'){
        $term = $this->input->get('q');
        if ($term) {
            $this->db->where("(name LIKE '%" . $term . "%' OR telephone LIKE '%" . $term . "%' OR  concat(name, ' ', telephone) LIKE '%" . $term . "%')");
        }
        $this->db->select('id, name, telephone');
        $q = $this->db->get('clients');

        $data = array(); 
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $client) {
                $data[] = array('id' => $client->id, 'text' => "$client->name ". preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $client->telephone) );              
            } 
        } else {
           $data[] = array('id' => '0', 'text' => 'No Client Found');
        }
        echo json_encode($data);
    }
}   