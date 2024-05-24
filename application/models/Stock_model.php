<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stock_model extends CI_Model
{
	// Getting Expenses
	private $user_id;
	public function __construct()
	{
		$this->setUserID();
	}
	public function setUserID()
	{
		$this->user_id = $this->session->userdata('user_session')->id;
	}
	public function get_sellers($user_role)
	{
		$this->db->select('id,name,email')->from('users');
		if ($user_role == 2) {
			$this->db->where('id', $this->user_id);
		}

		return $this->db->get()->result();
	} // function ends

	public function save($stock)
	{
		$this->db->where('product_id', $stock['product_id']);
		$this->db->where('user_id', $stock['user_id']);
		$query = $this->db->get('seller_stock');
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$new_quantity = $row->quantity + $stock['quantity'];
			$this->db->where('product_id', $stock['product_id']);
			$this->db->where('user_id', $stock['user_id']);
			return $this->db->update('seller_stock', array('quantity' => $new_quantity));
		} else {
			$this->db->insert('seller_stock', $stock);
			if ($this->db->affected_rows() > 0) {
				return true;
			} else {
				return false;
			}
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
	public function checkIfassigned($user_id, $product_id)
	{
		return $this->db->where('user_id', $user_id)
			->where('product_id', $product_id)
			->get('seller_stock')->row();
	}
}
