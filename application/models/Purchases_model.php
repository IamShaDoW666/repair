<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Purchases_model extends CI_Model
{

    function __construct() {
        parent::__construct();
    }


    public function getAllCompanies($group_name) {
        $q = $this->db->get('suppliers');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getCompanyByID($id) {
        $q = $this->db->get_where('suppliers', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getTaxRateByID($id) {
        $q = $this->db->get_where('tax_rates', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
    
    public function getUser($id = NULL) {
        if (!$id) {
            $id = $this->session->userdata('user_id');
        }
        $q = $this->db->get_where('users', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
    
    public function getPurchaseCount()
    {
        $this->db->from('purchases');
        return $this->db->count_all_results()+1;
    }
    
     public function getReference() {
        
        $prefix = $this->controller->mSettings->purchase_prefix;
        $ref_no = (!empty($prefix)) ? $prefix . '/' : '';
        $seq_number = $this->getPurchaseCount();

        if ($this->controller->mSettings->reference_format == 1) {
            $ref_no .= date('Y') . "/" . sprintf("%04s", $seq_number);
        } elseif ($this->controller->mSettings->reference_format == 2) {
            $ref_no .= date('Y') . "/" . date('m') . "/" . sprintf("%04s", $seq_number);
        } elseif ($this->controller->mSettings->reference_format == 3) {
            $ref_no .= sprintf("%04s", $seq_number);
        } else {
            $ref_no .= sprintf("%04s", $seq_number);
        }

        return $ref_no;
    }

    public function getSupplierSuggestions($term, $limit = 10)
    {
        $this->db->select("id, (CASE WHEN company = '-' THEN name ELSE CONCAT(company, ' (', name, ')') END) as text", FALSE);
        $this->db->where(" (id LIKE '%" . $term . "%' OR name LIKE '%" . $term . "%' OR company LIKE '%" . $term . "%' OR email LIKE '%" . $term . "%' OR phone LIKE '%" . $term . "%') ");
        $q = $this->db->get('suppliers', $limit);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }

            return $data;
        }
    }

    public function getAllTaxRates() {
        $q = $this->db->get('tax_rates');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getProductNames($term, $limit = 5)
    {
        $this->db->where("type = 'standard' AND (name LIKE '%" . $term . "%' OR code LIKE '%" . $term . "%' OR  concat(name, ' (', code, ')') LIKE '%" . $term . "%')");
        $this->db->limit($limit);
        $q = $this->db->where('isDeleted != ', 1)->get('inventory');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getAllProducts()
    {
        $q = $this->db->where('isDeleted != ', 1)->get('products');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

   public function getProductByID($id) {
        $q = $this->db->get_where('inventory', array('id' => $id, 'isDeleted' => 0), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }


 

    public function getProductByCode($code)
    {
        $q = $this->db->get_where('inventory', array('code' => $code, 'isDeleted' => 0), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

 

    public function getAllPurchases()
    {
        $q = $this->db->get('purchases');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }

    public function getAllPurchaseItems($purchase_id)
    {
        $this->db->select('purchase_items.*, tax_rates.code as tax_code, tax_rates.name as tax_name, tax_rates.rate as tax_rate, inventory.details as details')
            ->join('inventory', 'inventory.id=purchase_items.product_id', 'left')
            ->join('tax_rates', 'tax_rates.id=purchase_items.tax_rate_id', 'left')
            ->group_by('purchase_items.id')
            ->order_by('id', 'asc');
        $q = $this->db->get_where('purchase_items', array('purchase_id' => $purchase_id));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getItemByID($id)
    {
        $q = $this->db->get_where('purchase_items', array('id' => $id), 1);
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

    
    public function getPurchaseByID($id)
    {
        $q = $this->db->get_where('purchases', array('id' => $id));
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
    public function getProductQtyByID($id)
    {
        $q = $this->db->get_where('inventory', array('id' => $id, 'isDeleted' => 0), 1);
        if ($q->num_rows() > 0) {
            return $q->row()->quantity;
        }
        return FALSE;
    }
    public function addPurchase($data, $items)
    {

        if ($this->db->insert('purchases', $data)) {
            $purchase_id = $this->db->insert_id();
            foreach ($items as $item) {
                $item['purchase_id'] = $purchase_id;
                $this->db->insert('purchase_items', $item);
                if ($this->controller->mSettings->update_cost) {
                    $this->db->update('inventory', array('cost' => $item['unit_cost']), array('id' => $item['product_id']));
                }

                if ($data['status'] == 'received') {
                    $quantity_balance = (int) $this->getProductQtyByID($item['product_id']);
                    $new_qty = (int) $item['quantity'];

                    $total = $quantity_balance + $new_qty;
                    $this->db->where('id', $item['product_id']);
                    $this->db->update('inventory', array('quantity' => $total));
                }
            }



            $this->settings_model->addLog('add', 'purchase', $purchase_id, json_encode(array(
                'data' => $data,
                'items' => $items,
            )));
            return true;
        }
        return false;
    }

    public function updatePurchase($id, $data, $items = array())
    {
        $opurchase = $this->getPurchaseByID($id);
        $oitems = $this->getAllPurchaseItems($id);

        if ($this->db->update('purchases', $data, array('id' => $id)) && $this->db->delete('purchase_items', array('purchase_id' => $id))) {
            $purchase_id = $id;
            foreach ($items as $item) {
                $item['purchase_id'] = $id;
                $this->db->insert('purchase_items', $item);
                if ($data['status'] == 'received') {
                    $quantity_balance = (int) $this->getProductQtyByID($item['product_id']);
                    $new_qty = (int) $item['quantity'];

                    $total = abs($quantity_balance) + $new_qty;
                    $this->db->where('id', $item['product_id']);
                    $this->db->update('inventory', array('quantity' => $total));
                }
            }


            $this->settings_model->addLog('update', 'purchase', $purchase_id, json_encode(array(
                'data' => $data,
                'items' => $items,
            )));
            return true;
        }

        return false;
    }

    public function deletePurchase($id)
    {
        $purchase = $this->getPurchaseByID($id);
        $purchase_items = $this->getAllPurchaseItems($id);

        if ($this->db->delete('purchase_items', array('purchase_id' => $id)) && $this->db->delete('purchases', array('id' => $id))) {
            if ($purchase->status == 'received') {
                redirect('panel/purchases');
            }
             $this->settings_model->addLog('delete', 'purchase', $id, json_encode(array(
                'data' => $purchase,
                'items' => $purchase_items,
            )));
            $this->syncQuantity(NULL, $purchase_items);
            return true;
        }
        return FALSE;
    }
    public function syncQuantity($purchase_id = NULL, $oitems = NULL, $product_id = NULL) {
        if ($purchase_id) {

            $purchase_items = $this->getAllPurchaseItems($purchase_id);
            foreach ($purchase_items as $item) {
                $this->syncProductQty($item->product_id);
            }

        } elseif ($oitems) {
            foreach ($oitems as $item) {
                if (isset($item->product_type)) {
                    if ($item->product_type == 'standard') {
                        return $this->syncProductQty($item->product_id);
                    } 
                } else {
                    return $this->syncProductQty($item->product_id);
                }
            }

        } elseif ($product_id) {
            $this->syncProductQty($product_id);
        }
    }

    private function getBalanceQuantity($product_id) {
        $this->db->select('SUM(COALESCE(quantity_balance, 0)) as stock', False);
        $this->db->where('product_id', $product_id)->where('quantity_balance !=', 0);
        $this->db->group_start()->where('status', 'received')->group_end();
        $q = $this->db->get('purchase_items');
        if ($q->num_rows() > 0) {
            $data = $q->row();
            return $data->stock;
        }
        return 0;
    }
    public function syncProductQty($product_id) {
        $balance_qty = $this->getBalanceQuantity($product_id);

        if ($this->db->update('inventory', array('quantity' => ($balance_qty) ), array('id' => $product_id))) {
            return TRUE;
        }
        return FALSE;
    }

    public function updateAVCO($data)
    {
        $this->syncProductQty($data['product_id']);
    }

}
