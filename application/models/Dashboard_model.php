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
}//class end here