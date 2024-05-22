<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Dashboard_model
 */
class Dashboard_model extends CI_Model
{
	private $user_id;
	
	public function setUserId(){
		$this->user_id = $this->session->userdata('user_session')->id ?? '';
	}
	public function getTotalPaidAmount($user_role)
	{
		$this->setUserId();
		$this->db->select_sum('paid_amount');
		if ($user_role != null) {
			$this->db->where('user_id', $this->user_id);
		}
		$query = $this->db->get('orders_delivered');
		$result = $query->row();
		// dd($result);
		return $result->paid_amount;
	}

	public function getTotalDueAmount($user_role)
	{
		$this->db->select_sum('due_amount');
		if ($user_role != null) {
			$this->db->where('user_id', $this->user_id);
		}
		$query = $this->db->get('orders_delivered');
		$result = $query->row();
		return $result->due_amount;
	}

	public function getTotalExpenseAmount($user_role)
	{
		$query = $this->db->select_sum('amount')
			->get('expenses');
		$result = $query->row();
		return $result->amount;
	}

	public function getTotalSales($user_role)
	{
		$this->db->select_sum('net_total');
		if ($user_role != null) {
			$this->db->where('user_id', $this->user_id);
		}
		$query = $this->db->get('orders_delivered');
		$result = $query->row();
		return $result->net_total;
	}
	// 
	public function monthlysale($user_role)
	{
		$this->db->select('EXTRACT(MONTH FROM created_at) AS month');
		$this->db->select('EXTRACT(YEAR FROM created_at) AS year');
		$this->db->select_sum('net_total', 'monthly_net_total');
		$this->db->select_sum('paid_amount', 'monthly_total_paid');
		$this->db->select_sum('due_amount', 'monthly_total_due');
		
		$this->db->from('orders_delivered');
		
		$this->db->where('YEAR(created_at)', date('Y'));
		if($user_role == 2){
			$this->db->where('user_id', $this->user_id);
		}
		// Group by month and year
		$this->db->group_by('month, year');

		// Order by year and month
		$this->db->order_by('year', 'ASC');
		$this->db->order_by('month', 'ASC');

		// Execute the query
		$query = $this->db->get()->result();

		$month = array();
		$net_total = array();
		$total_paid = array();
		$total_due = array();
		foreach ($query as $q) {
			array_push($month, $q->month);
			array_push($net_total, $q->monthly_net_total);
			array_push($total_paid, $q->monthly_total_paid);
			array_push($total_due, $q->monthly_total_due);
		}
		$arr['months'] = $month;
		$arr['monthly_net_total'] = $net_total;
		$arr['monthly_total_paid'] = $total_paid;
		$arr['monthly_total_due'] = $total_due;
		return $arr;
	}

	public function monthly_expenses($user_role)
	{
		$this->db->select('EXTRACT(MONTH FROM created_at) AS month');
		$this->db->select('EXTRACT(YEAR FROM created_at) AS year');
		$this->db->select_sum('amount', 'monthly_total_expenses');

		$this->db->from('expenses');

		$this->db->where('YEAR(created_at)', date('Y'));

		// Group by month and year
		$this->db->group_by('month, year');

		// Order by year and month
		$this->db->order_by('year', 'ASC');
		$this->db->order_by('month', 'ASC');

		// Execute the query
		$query = $this->db->get()->result();
		// dd($query);

		$month = array();
		$total_expenses = array();
		foreach ($query as $q) {
			array_push($month, $q->month);
			array_push($total_expenses, $q->monthly_total_expenses);
		}
		$arr['exp_months'] = $month;
		$arr['monthly_total_expenses'] = $total_expenses;
		return $arr;
	}
}//class end here
