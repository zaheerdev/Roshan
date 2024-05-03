<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Dashboard_model
 */
class Dashboard_model extends CI_Model
{

    public function getTotalPaidAmount()
    {
        $query = $this->db->select_sum('paid_amount')
            ->get('orders_delivered');
        $result = $query->row();
        return $result->paid_amount;
    }

    public function getTotalDueAmount()
    {
        $query = $this->db->select_sum('due_amount')
            ->get('orders_delivered');
        $result = $query->row();
        return $result->due_amount;
    }

    public function getTotalExpenseAmount()
    {
        $query = $this->db->select_sum('amount')
            ->get('expenses');
        $result = $query->row();
        return $result->amount;
    }

    public function getTotalSales()
    {
        $query = $this->db->select_sum('net_total')
            ->get('orders_delivered');
        $result = $query->row();
        return $result->net_total;
    }
	// 
	public function monthlysale()
	{
		$this->db->select('EXTRACT(MONTH FROM created_at) AS month');
        $this->db->select('EXTRACT(YEAR FROM created_at) AS year');
        $this->db->select_sum('net_total', 'monthly_net_total');
        $this->db->select_sum('paid_amount', 'monthly_total_paid');
        $this->db->select_sum('due_amount', 'monthly_total_due');
        
        $this->db->from('orders_delivered');

        $this->db->where('YEAR(created_at)', date('Y'));
        
        // Group by month and year
        $this->db->group_by('month, year');
        
        // Order by year and month
        $this->db->order_by('year', 'ASC');
        $this->db->order_by('month', 'ASC');
        
        // Execute the query
        $query = $this->db->get()->result();
        
		$month = array();
		$net_total= array();
		$total_paid= array();
		$total_due= array();
		foreach($query as $q){
			array_push($month,$q->month);
			array_push($net_total,$q->monthly_net_total);
			array_push($total_paid,$q->monthly_total_paid);
			array_push($total_due,$q->monthly_total_due);

		}
		$arr['months'] = $month;
		$arr['monthly_net_total'] = $net_total;
		$arr['monthly_total_paid'] = $total_paid;
		$arr['monthly_total_due'] = $total_due;
		return $arr;
	}

    public function monthly_expenses()
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
		foreach($query as $q){
			array_push($month,$q->month);
			array_push($total_expenses,$q->monthly_total_expenses);

		}
		$arr['exp_months'] = $month;
		$arr['monthly_total_expenses'] = $total_expenses;
		return $arr;
	}
}//class end here
