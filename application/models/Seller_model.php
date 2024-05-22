<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Seller_model extends CI_Model
{
	// Getting Expenses
	public function get_sellers()
	{
		return $this->db->select('id,name,email')->from('users')->where('role_id', 2)->get()->result();
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
		$result = $this->db->select('email')->from('users')->where('email', $email)->get()->row();
		return $result;
	}
	// check updated email exist
	public function check_updated_email($id, $email)
	{
		$check_email = $this->db->select('email')->from('users')
			->where_not_in('id', $id)
			->where('email', $email)
			->get()->row();
		return $check_email;
	}
	public function get_paid_details($id, $filter)
	{
		// daily paid amount
		// $start_date = '2024-04-21';
		// $end_date = '2024-05-31';
		$this->db->select('u.name');
		$this->db->select_sum('od.due_amount');
		$this->db->select_sum('od.paid_amount');
		$this->db->from('orders_delivered od');
		$this->db->join('users u', 'u.id = od.user_id');
		$this->db->where('od.user_id', $id);
		if ($filter !== null) {
			$filterdate = explode("+",$filter);
			$start_date = $filterdate[0];
			$end_date = $filterdate[1];
			// dd($filterdate);
			$this->db->where('DATE(od.created_at) >=', $start_date);
			$this->db->where('DATE(od.created_at) <=', $end_date);
		}else{
			$this->db->where('DATE(od.created_at)', date('Y-m-d'));
		}
		return $this->db->get()->result();
		// return dd($this->db->get_compiled_select());//->result();
		// if ($filter == null) {
		// 	return $daily = $this->db->select('u.name')
		// 		->select_sum('od.due_amount')
		// 		->select_sum('od.paid_amount')
		// 		->from('orders_delivered od')
		// 		->join('users u', 'u.id = od.user_id')
		// 		->where('od.user_id', $id)
		// 		->where('DATE(od.created_at) >=', $start_date)
		// 		->where('DATE(od.created_at) <=', $end_date)
		// 		->get()->result();
		// }
		// Return the result as an associative array
	}
}
