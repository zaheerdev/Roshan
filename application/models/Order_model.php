<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order_model extends CI_Model
{
    // Getting product items 
    public function get_product_items()
    {
        return $this->db->get('product_items')->result_array();
    } // function ends

    /**
     * processOrder
     *
     * @param  mixed $vendor_id
     * @param  mixed $productItems
     * @return void
     */
    public function process_order($vendor_id, $productItems, $order_id)
    {
        $orders_data = array();

        foreach ($productItems as $item) {
            $order_data = array(
                'vendor_id' => $vendor_id,
                'order_id'  => $order_id,
                'product_id' => $item['productId'],
                'quantity' => $item['quantity'],
                'total' => $item['total'],
                'user_id' => $this->session->userdata('user_session')->id
            );
            $orders_data[] = $order_data;
        }

        $this->db->insert_batch('orders', $orders_data);

        if ($this->db->affected_rows() > 0) {
            $response = [
                'order_id' => $order_id,
                'status' => true,
                "data" => null,
                'message' => "order created successfully."
            ];
        } else {
            $response = [
                'status' => false,
                "data" => null,
                'message' => "Some error occurred during order Creation. Please try again."
            ];
        }
        return $response;
    } // function ends

    public function isOrderIdExists($order_id)
    {
        $query = $this->db->get_where('orders', array('order_id' => $order_id));
        return ($query->num_rows() > 0);
    }

    public function get_order_details($order_id)
    {
        $this->db->select("*");
        $this->db->from("orders or");
        $this->db->join('vendors ve', 'or.vendor_id = ve.id');
        $this->db->join('product_items pr', 'or.product_id = pr.id');
        // $this->db->join('orders_delivered od', 'or.order_id = od.order_id');
        $this->db->where("or.order_id", $order_id);
        $query = $this->db->get();
        // print_r($this->db->last_query());
        // exit;
        if ($query->num_rows() > 0) {
            $result = $query->result();
            // dd($result);
        } else {
            $result = null;
        }
        return $result;
    } //function ends

    public function save_deliver_order($data) {
        $this->db->insert('orders_delivered', $data);
        return $this->db->insert_id();
    }

	public function get_records(){
		// return $this->db->select('*')->from('orders')
		// 		// ->join('users','users.id = orders.user_id','right')
		// 		// ->join('vendors','vendors.id = orders.vendor_id','right')
		// 		->get()->result();
		$this->db->select('or.order_id,users.name,ven.vendor_name,pi.product_name,od.sub_total,od.discount,od.paid_amount,od.due_amount');
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
}
