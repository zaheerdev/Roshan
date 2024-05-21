<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inventory_model extends CI_Model
{
	
	public function save_product_inventory($inventory, $product_id)
    {
        $this->db->where('id', $product_id);
        $query = $this->db->get('product_items');

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $new_quantity = $row->quantity + $inventory['quantity'];

            $this->db->where('id', $product_id);
            return $this->db->update('product_items', array('quantity' => $new_quantity));
        } else {
            $inventory['id'] = $product_id;
            return $this->db->insert('product_items', $inventory);
        }
    }

    // Getting product items 
    public function get_raw_items()
    {
        return $this->db->get('raw_materials')->result_array();
    } // function ends

    public function save_raw_inventory($inventory, $material_id)
    {
        $this->db->where('id', $material_id);
        $query = $this->db->get('raw_materials');

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $new_quantity = $row->quantity + $inventory['quantity'];

            $this->db->where('id', $material_id);
            return $this->db->update('raw_materials', array('quantity' => $new_quantity));
        } else {
            $inventory['id'] = $material_id;
            return $this->db->insert('raw_materials', $inventory);
        }
    }
}
