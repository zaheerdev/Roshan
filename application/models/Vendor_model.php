<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vendor_model extends CI_Model
{
	// Getting Expenses
	public function get_vendors($user_id)
	{
		$this->db->select('*');
		$this->db->from('vendors');
		if($user_id != null){
			$this->db->where('user_id',$user_id);
		}
		return $this->db->get()->result();
	} // function ends

	public function save($vendor)
	{
		$this->db->insert('vendors', $vendor);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	} // function ends

	public function edit($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('vendors');
		if ($query) {
			return $query->row();
		} else {
			false;
		}
	} // function ends

	public function update($vendor, $id)
	{
		$this->db->where('id', $id);
		$query = $this->db->update('vendors', $vendor);
		if ($query) {
			return true;
		} else {
			return false;
		}
	} // function ends

	public function delete($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->delete('vendors');
		if ($query) {
			return true;
		} else {
			return false;
		}
	} // function ends
}
