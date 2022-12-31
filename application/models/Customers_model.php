<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customers_model extends CI_Model
{
	
    public function getClients()
    {
        $data = array();
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('clients');
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
        }

        return $data;
    }
    public function delete_clients($id)
    {
        $this->db->delete('clients', array('id' => $id));
    }


    public function insert_client($data)
    {
        $this->db->insert('clients', $data);
        $id = $this->db->insert_id();
        
        $this->settings_model->addLog('add', 'customer', $id, json_encode(array(
            'data'=>$data,
        )));
        return $id;
    }

   
    public function edit_client($id, $data)
    {
        $this->db->where('id', $id);
        if ($this->db->update('clients', $data)) {
             $this->settings_model->addLog('update', 'customer', $id, json_encode(array(
                'data'=>$data,
            )));
            return TRUE;
        }else{
            return FALSE;
        }
    }
 
    public function find_customer($id)
    {
        $data = array();
        $query = $this->db->get_where('clients', array('id' => $id));
        if ($query->num_rows() > 0) {
            $data = $query->row_array();
        }

        return $data;
    }


    public function getCustomerByEmail($id)
    {
        $query = $this->db->get_where('clients', array('email' => $id));
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }


	
     public function addCustomers($data) {
        $this->db->insert_batch('clients', $data);
        $this->settings_model->addLog('add-batch', 'customer', $id, json_encode(array(
            'data'=>$data,
        )));
        return TRUE;
    }
}
