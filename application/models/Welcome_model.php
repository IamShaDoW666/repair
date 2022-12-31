<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome_model extends CI_Model
{
        
    public function __construct()
    {
        parent::__construct();
    }
    public function getReparationCount()
    {
        $this->db->from('reparation');
        return $this->db->count_all_results();
    }
    public function getClientCount()
    {
        $this->db->from('clients');
        return $this->db->count_all_results();
    }
    public function getStockCount()
    {
        $this->db->where('isDeleted != ', 1)->from('inventory');
        return $this->db->count_all_results();
    }

   
}
