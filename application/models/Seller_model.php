<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Seller_model extends CI_Model
{
	// Getting Expenses
	private $user_id;
	public function __construct() {
		$this->setUserID();
	}
	public function setUserID(){
		$this->user_id = $this->session->userdata('user_session')->id;
	}
	public function get_sellers($user_role)
	{
		$this->db->select('id,name,email')->from('users');
		if($user_role == 2){
			$this->db->where('id',$this->user_id);
		}
		
		return $this->db->get()->result();
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
		$date = date('Y-m-d');
		$this->db->select('u.name,od.created_at');
		$this->db->select_sum('od.due_amount');
		$this->db->select_sum('od.paid_amount');
		$this->db->from('orders_delivered od');
		$this->db->join('users u', 'u.id = od.user_id');
		$this->db->where('od.user_id', $id);
		if ($filter !== null) {
			$filterdate = explode("-to-",$filter);
			$start_date = $filterdate[0];
			$end_date = $filterdate[1];
			$this->db->where('DATE(od.created_at) >=', $start_date);
			$this->db->where('DATE(od.created_at) <=', $end_date);
		}else{
			$this->db->where('DATE(od.created_at) >=', $date);
		}
		
		// dd($this->db->get()->result());
		return $this->db->get()->result();
		
	}
	public function get_assigned_stock($user_id){
		$this->db->select('ss.id,u.name,pi.product_name,ss.quantity');
		$this->db ->from('seller_stock ss');
		if($user_id != null){
			$this->db->where('ss.user_id', $user_id);
		}
		$this->db->join('users u','u.id = ss.user_id');
		$this->db->join('product_items pi','pi.id = ss.product_id');
		return $this->db->get()->result();
	}
}
