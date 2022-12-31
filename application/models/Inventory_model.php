<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inventory_model extends CI_Model
{
    
    public function getModelNameByID($id)
    {
        $q = $this->db->get_where('models', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row()->name;
        }
        return FALSE;
    }

    public function addProduct($data)
    {
        if ($this->db->insert('inventory', $data)) {
            $id = $this->db->insert_id();

            $this->settings_model->addLog('add', 'product', $id, json_encode(array(
                'data' => $data,
            )));
            return true;
        }
    }
    public function deleteProduct($id)
    {
        $this->db->where('id', $id);
        if ($this->db->update('inventory', array('isDeleted' => 1))) {
            $this->settings_model->addLog('delete', 'product', $id, json_encode(array(
                'data' => $product,
            )));
            return true;
        }
        return FALSE;
    }

    public function getProductByID($id)
    {
        $q = $this->db->get_where('inventory', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
    public function updateProduct($id, $data)
    {
        if ($this->db->update('inventory', $data, array('id' => $id))) {
             $this->settings_model->addLog('update', 'product', $id, json_encode(array(
                'data' => $data,
            )));
            return true;
        } else {
            return false;
        }
    }
    
    public function getProductNames($term, $limit = 5, $model_id = FALSE) {
        $this->db->select('*')
            ->where("(" . $this->db->dbprefix('inventory') . ".name LIKE '%" . $term . "%' OR code LIKE '%" . $term . "%'  OR code LIKE '%" . $term . "%' OR
                concat(" . $this->db->dbprefix('inventory') . ".name, ' (', code, ')') LIKE '%" . $term . "%')")->where('isDeleted !=', 1);
            if ($model_id) {
               $this->db->where('model_id', $model_id);
            }
            $this->db->group_by('inventory.id')->limit($limit);

        $q = $this->db->get('inventory');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
    public function getSuppliers()
    {
        $data = array();
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('suppliers');
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
        }

        return $data;
    }
    public function delete_supplier($id)
    {
        $this->settings_model->addLog('delete', 'supplier', $id, json_encode(array(
        )));
        $this->db->delete('suppliers', array('id' => $id));
    }


    public function insert_supplier($data)
    {
        $this->db->insert('suppliers', $data);
        $id = $this->db->insert_id();

        $this->settings_model->addLog('add', 'supplier', $id, json_encode(array(
            'data' => $data,
        )));

        return $id;
    }

    
    public function find_supplier($id)
    {
        $data = array();
        $query = $this->db->get_where('suppliers', array('id' => $id));
        if ($query->num_rows() > 0) {
            $data = $query->row_array();
        }

        return $data;
    }

    
    public function edit_supplier($id, $data)
    {
        
        $this->db->where('id', $id);
        if ($this->db->update('suppliers', $data)) {
            $this->settings_model->addLog('update', 'supplier', $id, json_encode(array(
                'data' => $data,
            )));
            return TRUE;
        }else{
            return FALSE;
        }
        

    }

    
    public function getModels()
    {
        $data = array();
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('models');
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
        }

        return $data;
    }
    public function delete_model($id)
    {
        $this->db->delete('models', array('id' => $id));
        $this->settings_model->addLog('delete', 'model', $id, json_encode(array(
            'data' => $data,
        )));
    }

    
    public function insert_model($data)
    {
        $this->db->insert('models', $data);
        $id = $this->db->insert_id();

        $this->settings_model->addLog('add', 'model', $id, json_encode(array(
            'data' => $data,
        )));

        return $id;
    }

    

    public function find_model($id)
    {
        $query = $this->db->where('id', $id)->get('models');
        if ($query->num_rows() > 0) {
            $data = $query->row();
            return $data;
        }
        return false;
    }

    public function find_manufacturer($id)
    {
        $query = $this->db->where('id', $id)->get('models');
        if ($query->num_rows() > 0) {
            $data = $query->row();
            return $data;
        }
        return false;
    }

    public function edit_model($id, $data)
    {
        
        $this->db->where('id', $id);
        if ($this->db->update('models', $data)) {
            $this->settings_model->addLog('update', 'model', $id, json_encode(array(
                'data' => $data,
            )));
            return TRUE;
        }else{
            return FALSE;
        }
        

    }


    public function getSubCategories($parent_id) {
        $this->db->select('id as id, name as text')
        ->where('parent_id', $parent_id)->order_by('name');
        $q = $this->db->get("categories");
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getManufacturerByName($name)
    {
        $name = strtolower($name);
        $q = $this->db
            ->where('parent_id', 0)
            ->where('LOWER(`name`)', ($name))
            ->get('models');

        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getModelByName($name)
    {
        $name = strtolower($name);
        $q = $this->db
            ->where('parent_id !=', 0)
            ->where('LOWER(`name`)', ($name))
            ->get('models');

        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }


    public function addManufacturer($data)
    {
        $q = $this->db->insert('models', $data);
         $id = $this->db->insert_id();

        $this->settings_model->addLog('add', 'manufacturer', $id, json_encode(array(
            'data' => $data,
        )));
        return $id;
    }

    public function delete_manufacturer($id)
    {
        $q = $this->db->where('parent_id', $id)->get('models');
        if ($q->num_rows() > 0) {
            return false;
        }else{
            $this->db->delete('models', array('id'=>$id));
            $this->settings_model->addLog('delete', 'manufacturer', $id, json_encode(array(
            )));
            return true;
        }
    }
       
       
    public function getPurchaseItems($purchase_id)
    {
        $q = $this->db->get_where('purchase_items', array('purchase_id' => $purchase_id));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
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

    public function getCategoryByID($id)
    {
        $q = $this->db->get_where('categories', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getTaxRateByName($name)
    {
        $q = $this->db->get_where('tax_rates', array('name' => $name), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }


    public function getProductByCode($code)
    {
        $q = $this->db->get_where('inventory', array('code' => $code), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }


    public function add_products($products = array())
    {
        if (!empty($products)) {
            foreach ($products as $product) {
                if ($this->db->insert('inventory', $product)) {
                    $product_id = $this->db->insert_id();
                }
            }
            return true;
        }
        return false;
    }
    public function getSupplierByName($name)
    {
        $name = strtolower($name);
        $q = $this->db
            ->where('LOWER(`name`)', ($name))
            ->get('suppliers');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

     public function getModelByNameC($name)
    {
        $name = strtolower($name);
        $q = $this->db
            ->where('LOWER(`name`)', ($name))
            ->get('models');

        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }



}
