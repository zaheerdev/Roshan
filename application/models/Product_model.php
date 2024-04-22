<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product_model extends CI_Model
{
	// Getting vendors
	public function get_products()
	{
		return $this->db->get('product_items')->result();
	} // function ends

	public function save($product)
	{
		$this->db->insert('product_items', $product);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	} // function ends

	public function edit($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('product_items');
		if ($query) {
			return $query->row();
		} else {
			false;
		}
	} // function ends

	public function update($product, $id)
	{
		$this->db->where('id', $id);
		$query = $this->db->update('product_items', $product);
		if ($query) {
			return true;
		} else {
			return false;
		}
	} // function ends

	public function delete($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->delete('product_items');
		if ($query) {
			return true;
		} else {
			return false;
		}
	} // function ends
}
