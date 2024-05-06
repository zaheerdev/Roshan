<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Seller_model extends CI_Model
{
	// Getting Expenses
	public function get_sellers()
	{
		return $this->db->select('id,name,email')->from('users')->where('role_id',2)->get()->result();
	} // function ends

	public function save($seller)
	{
		$this->db->insert('users', $seller);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	} // function ends

	public function edit($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('users');
		if ($query) {
			return $query->row();
		} else {
			false;
		}
	} // function ends

	public function update($seller, $id)
	{
		// check if changed email exists
		$this->db->where('id', $id);
		$query = $this->db->update('users', $seller);
		if ($query) {
			return true;
		} else {
			return false;
		}
	} // function ends

	public function delete($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->delete('users');
		if ($query) {
			return true;
		} else {
			return false;
		}
	} // function ends

	// check email exists
	public function check_email($email)
	{
		$result = $this->db->select('email')->from('users')->where('email',$email)->get()->row();
		return $result;
	}
	// check updated email exist
	public function check_updated_email($id,$email){
		$check_email = $this->db->select('email')->from('users')
						->where_not_in('id',$id)
						->where('email',$email)
						->get()->row();
		return $check_email;
	}
}
