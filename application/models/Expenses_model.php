<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Expenses_model extends CI_Model
{
	// Getting vendors
	public function get_expenses()
	{
		return $this->db->get('expenses')->result();
	} // function ends

	public function save($vendor)
	{
		$this->db->insert('expenses', $vendor);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	} // function ends

	public function edit($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('expenses');
		if ($query) {
			return $query->row();
		} else {
			false;
		}
	} // function ends

	public function update($vendor, $id)
	{
		$this->db->where('id', $id);
		$query = $this->db->update('expenses', $vendor);
		if ($query) {
			return true;
		} else {
			return false;
		}
	} // function ends

	public function delete($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->delete('expenses');
		if ($query) {
			return true;
		} else {
			return false;
		}
	} // function ends
}
