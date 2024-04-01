<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Utility_model extends CI_Model
{

    public function get_order_product_details($product_id)
    {
        $this->db->select("*");
        $this->db->from("product_items");
        $this->db->where("id", $product_id);
        $query = $this->db->get();
        // print_r($this->db->last_query());
        // exit;
        if ($query->num_rows() > 0) {
            $result = $query->row();
        } else {
            $result = null;
        }
        return $result;
    } // function ends

    public function get_order_vendor_details($vendor_id)
    {
        $this->db->select("*");
        $this->db->from("vendors");
        $this->db->where("id", $vendor_id);
        $query = $this->db->get();
        // print_r($this->db->last_query());
        // exit;
        if ($query->num_rows() > 0) {
            $result = $query->row();
        } else {
            $result = null;
        }
        return $result;
    } // function ends
}
