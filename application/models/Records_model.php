<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Records_model extends CI_Model
{
	public function get_records(){
		$this->db->select('or.order_id,users.name,ven.id,ven.vendor_name,pi.product_name,od.sub_total,od.discount,od.paid_amount,od.due_amount');
		$this->db->from('orders or');
		$this->db->join('users','users.id = or.user_id');
		$this->db->join('vendors ven','ven.id = or.vendor_id');
		$this->db->join('product_items pi','pi.id = or.product_id');
		$this->db->join('orders_delivered od','or.order_id = od.order_id');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
            // dd($result);
        } else {
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


}
