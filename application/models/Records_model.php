<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Records_model extends CI_Model
{
    public function get_records()
    {
        // $this->db->select('or.order_id,users.name,ven.id,ven.vendor_name,pi.product_name,od.sub_total,od.discount,od.paid_amount,od.due_amount');
        // $this->db->from('orders or');
        // $this->db->join('users', 'users.id = or.user_id');
        // $this->db->join('vendors ven', 'ven.id = or.vendor_id');
        // $this->db->join('product_items pi', 'pi.id = or.product_id');
        // $this->db->join('orders_delivered od', 'or.order_id = od.order_id');
        // $query = $this->db->get();
        // if ($query->num_rows() > 0) {
        //     $result = $query->result();
        //     // dd($result);
        // } else {
        //     $result = null;
        // }
        // return $result;

		//practice
		$this->db->select('o.vendor_id, v.vendor_name,u.name as user_name');
        $this->db->select_sum('od.sub_total', 'total_sub_total');
        $this->db->select_sum('od.discount', 'total_discount');
        $this->db->select_sum('od.net_total', 'total_net_total');
        $this->db->select_sum('od.paid_amount', 'total_paid_amount');
        $this->db->select_sum('od.due_amount', 'total_due_amount');
        // $this->db->select_sum('od.due_amount', 'total_due_amount');

        // From orders_delivered table
        $this->db->from('orders_delivered od');

        // Join with orders table to get vendor_id
        $this->db->join('orders o', 'o.order_id = od.order_id');
		// Join with vendors table to get vendor_name
		$this->db->join('vendors v', 'v.id = o.vendor_id');
		// Join with users table to get user_name
		$this->db->join('users u', 'u.id = od.user_id');

        // Group by vendor_id
        $this->db->group_by('o.vendor_id');

        // Execute the query
        $query = $this->db->get();
			// dd($query);
        // Check if query execution was successful
        if ($query) {
            // Return the result set as an array of associative arrays
            $result = $query->result();
			// dd($result);
        } else {
            // Query failed, return an empty array or handle the error accordingly
            $result = null;
        }
		return $result;
    }

    public function get_amount_details($vendor_id)
    {
        $this->db->select("*");
        $this->db->from("orders_delivered od");
        $this->db->join('orders or', 'or.order_id = od.order_id');
        $this->db->where("or.vendor_id", $vendor_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result();
        } else {
            $result = null;
        }
        return $result;
    } //function ends

    public function update_order_payment($order_id, $total_paid_amount, $total_due_amount)
    {
        $this->db->where('order_id', $order_id);
        $this->db->update('orders_delivered', array(
            'paid_amount' => $total_paid_amount,
            'due_amount' => $total_due_amount
        ));

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function get_payment_details($vendor_id)
    {
        $this->db->select("ve.*, od.net_total, SUM(od.due_amount) as total_due_amount, SUM(od.paid_amount) as total_paid_amount");
        $this->db->from("orders or");
        $this->db->join('vendors ve', 'or.vendor_id = ve.id');
        $this->db->join('orders_delivered od', 'or.order_id = od.order_id');
        $this->db->where("ve.id", $vendor_id);
        $this->db->group_by("ve.id"); 
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->row(); 
        } else {
            $result = null;
        }
        return $result;
    }
}
