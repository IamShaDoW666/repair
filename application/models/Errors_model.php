<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Errors_model extends CI_Model
{
	
    public function delete($id)
    {
        $this->db->where(array('id' => $id))->delete('reparation_errors');
    }


    public function add($data)
    {
        $this->db->insert('reparation_errors', $data);
        $id = $this->db->insert_id();
        $this->settings_model->addLog('add', 'error', $id, json_encode(array(
            'data'=>$data,
        )));
        return $id;
    }

   
    public function edit($id, $data)
    {
        $this->db->where('id', $id);
        if ($this->db->update('reparation_errors', $data)) {
            $this->settings_model->addLog('update', 'error', $id, json_encode(array(
                'data'=>$data,
            )));
            return TRUE;
        }else{
            return FALSE;
        }
    }
   
    public function find($id)
    {
        $data = array();
        $query = $this->db->get_where('reparation_errors', array('id' => $id));
        if ($query->num_rows() > 0) {
            $data = $query->row_array();
        }
        return $data;
    }


}
