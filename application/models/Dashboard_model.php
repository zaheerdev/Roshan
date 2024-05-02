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
		// return $query = $this->db->select('created_at,net_total')->from('orders_delivered')->get()->result();
		$this->db->select('EXTRACT(MONTH FROM created_at) AS month');
        $this->db->select('EXTRACT(YEAR FROM created_at) AS year');
        $this->db->select_sum('net_total', 'monthly_net_total');
        
        // From your_table_name
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
		foreach($query as $q){
			array_push($month,$q->month);
			array_push($net_total,$q->monthly_net_total);

		}
		$arr['months'] = $month;
		$arr['monthly_net_total'] = $net_total;
		return $arr;
	}
}//class end here
