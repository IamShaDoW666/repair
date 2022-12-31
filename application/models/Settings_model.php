<?php

/*
|--------------------------------------------------------------------------
| Setting model file
|--------------------------------------------------------------------------
| 
*/

class Settings_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

	/*------------------------------------------------------------------------
	| GET THE LANGUAGE
	| @return Language slug
	|--------------------------------------------------------------------------*/
    public function get_language()
    {
        $data = array();
        $q = $this->db->get('settings');
        if ($q->num_rows() > 0) {
            return $q->row();
        }

        return FALSE;
    }
    


    public function getTaxRates()
    {
        $data = array();
        $query = $this->db->get('tax_rates');
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
        }

        return $data;
    }
    
    public function getTaxRateByID($id)
    {
        $q = $this->db->get_where('tax_rates', array('id' => $id));
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

	/*------------------------------------------------------------------------
	| GET SETTING LIST
	| @return Variable with setting
	|--------------------------------------------------------------------------*/
    public function getSettings()
    {
        $data = array();
        $q = $this->db->get('settings');
        if ($q->num_rows() > 0) {
            return $q->row();
        }

        return FALSE;
    }

	/*------------------------------------------------------------------------
	| UPDATE SETTING
	| @param title, lang, disclaimer, admin username, admin password, sms services used, skebby username, skebby password, skebby name, skebby method, showcredit [1/0],
	| currency, invoice name, invoice mail, invoice address, invoice phone, invoice VAT, invoice type [EU/US], tax amount, category
	|--------------------------------------------------------------------------*/
    public function update_settings($data = NULL)
    {
        if ($data) {
            $this->db->update('settings', $data);
            return true;
        }
    }
	
	
	
  /*------------------------------------------------------------------------
	| SAVE THE LOGO IN THE DB
	-------------------------------------------------------------------------*/
    public function update_logo($logo)	
    {
        $data = array(
            'logo' => $logo,
        );
        $this->db->update('settings', $data);
    }


    public function get_total_qty_alerts() {
        $this->db->where('quantity < alert_quantity', NULL, FALSE)->where('isDeleted != ', 1)->where('alert_quantity >', 0);
        return $this->db->count_all_results('inventory');
    }

      public function getParentCategories()
    {
        $this->db->where('parent_id', NULL)->or_where('parent_id', 0);
        $q = $this->db->get("categories");
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getCategoryByID($id)
    {
        $q = $this->db->get_where("categories", array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getCategoryByCode($code)
    {
        $q = $this->db->get_where('categories', array('code' => $code), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function addCategory($data)
    {
        if ($this->db->insert("categories", $data)) {
            return true;
        }
        return false;
    }

    public function addCategories($data)
    {
        if ($this->db->insert_batch('categories', $data)) {
            return true;
        }
        return false;
    }

    public function updateCategory($id, $data = array())
    {
        if ($this->db->update("categories", $data, array('id' => $id))) {
            return true;
        }
        return false;
    }

    public function deleteCategory($id)
    {
        if ($this->db->delete("categories", array('id' => $id))) {
            return true;
        }
        return FALSE;
    }

    public function getSubCategories($parent_id) {
        $this->db->where('parent_id', $parent_id)->order_by('name');
        $q = $this->db->get("categories");
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return [];
    }
    public function getAllCategories() {
        $this->db->where('parent_id', NULL)->or_where('parent_id', 0)->order_by('name');
        $q = $this->db->get("categories");
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return [];
    }

     public function getAllSuppliers() {
        $q = $this->db->get("suppliers");
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return [];
    }

    

    public function getGroupPermissions($id)
    {
        $q = $this->db->get_where('permissions', array('group_id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->result_array();
        }
        return FALSE;
    }


    public function getGroupPermissionsByGroupID($id)
    {
        $q = $this->db->get_where('permissions', array('group_id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
    
    public function updatePermissions($id, $data = array())
    {
        $this->db->where(array('group_id' => $id));
        if ($this->db->update('permissions', $data)) {
            return true;
        }
        return false;
    }

    public function getGroupByID($id)
    {
        $q = $this->db->get_where('groups', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

     /*------------------------------------------------------------------------
    | Check User Group
    | @return GroupRow
    |--------------------------------------------------------------------------*/
    public function checkGroupUsers($id)
    {
        $q = $this->db->get_where("users_groups", array('group_id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
    /*------------------------------------------------------------------------
    | Delete User Group
    | @return true/false
    |--------------------------------------------------------------------------*/
    public function deleteGroup($id)
    {
        if ($this->db->delete('groups', array('id' => $id))) {
            $this->db->delete('permissions', array('group_id'=>$id));
            return true;
        }
        return FALSE;
    }
    /*------------------------------------------------------------------------
    | Get User Groups
    | @return GroupResult
    |--------------------------------------------------------------------------*/
    public function getGroups()
    {
        $this->db->where('id >', 1);
        $q = $this->db->get('groups');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
    
    /*------------------------------------------------------------------------
    | getRepairStatuses
    |--------------------------------------------------------------------------*/
    public function getRepairStatuses()
    {
        $q = $this->db->order_by('position', 'ASC')->get('status');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function countRepairStatuses()
    {
        $count = $this->db->count_all_results('status');
        return $count+1;
    }

    public function verifyStatusDelete($id)
    {
        $this->db->where('status', $id);
        $q = $this->db->get('reparation');
        if ($q->num_rows() > 0) {
            return FALSE;
        }
        return TRUE;
    }
    public function getStatusByID($id) {
        $this->db->where('id', $id);
        $q = $this->db->select('*')->get('status');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
    public function getAllClients()
    {
        $q = $this->db->get_where('clients');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return array();
    }

    public function getAllManufacturers()
    {
        $data = array();
        $q = $this->db->where('parent_id', null)->or_where('parent_id', 0)->get('models');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }


    public function getSMSGatewaysDP()
    {
        $data = array();
        $q = $this->db->get('sms_gateways');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[$row->id] = $row->name;
            }
        }
        return $data;
    }



    public function getSMSGatewayByID($id)
    {
        $data = array();
        $q = $this->db->where('id', $id)->get('sms_gateways');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return False;
    }

    
    public function getClientsByIDs($ids = array()) {
        if (empty($ids)) {
            return array(); 
        }
        $q = $this->db->where_in('id', $ids)->get('clients');
        if ($q->num_rows() > 0) {
            return $q->result_array();
        }
        return array();

    }

     public function getClientByID($id) {
        $q = $this->db->where('id', $id)->get('clients');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    
   public function getActiveStatuses($completed)
    {
        $this->db->reset_query();
        
        $status = array();
        $q2 = $this->db
            ->where('completed', $completed)
            ->get('status');
        if ($q2->num_rows() > 0) {
            foreach ($q2->result() as $row) {
                $status[] = $row->id;
            }
        }
        return $status;
    }


    public function addLog($action, $model, $item_id = null, $details= null, $amount = null) {
        $data = array(
            'action' => $action,
            'model' => $model,
            'link_id' => $item_id,
            'user_id' => $this->session->userdata( 'user_id' ) ? $this->session->userdata( 'user_id' ) : 0,
            'date' => date('Y-m-d H:i:s'),
            'ip_addr' => $this->input->ip_address(),
            'details' => $details,
            'amount' => $amount,
        );
        $this->db->insert('activity_log', $data);
        return $this->db->insert_id();
    }


     public function getAllErrors() {
        $q = $this->db->get("reparation_errors");
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getDateFormats()
    {
        $q = $this->db->get('date_format');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
     public function getDateFormat($id) {
        $q = $this->db->get_where('date_format', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
}

