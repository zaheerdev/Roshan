<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order_model extends CI_Model
{
	// get all orders
	public function get_all_orders()
	{
		$user_role = $this->session->userdata('user_session')->role_id;
		$user_id = $this->session->userdata('user_session')->id;
		$this->db->select("o.id,o.order_id,o.user_id,u.name as seller_name,v.vendor_name,p.product_name,o.quantity,o.total,co.order_id as c_id,co.created_at as c_time");
		$this->db->from("orders o");
		$this->db->join("users u", 'u.id = o.user_id');
		$this->db->join("vendors v", 'v.id = o.vendor_id');
		$this->db->join("cancel_order co", 'co.order_id = o.order_id', 'left');
		$this->db->join("product_items p", 'p.id = o.product_id');

		if ($user_role == 2) {
			$this->db->where("o.user_id", $user_id);
			// $this->db->group_by("o.order_id");
			return $this->db->get()->result();
		} else {
			// $this->db->group_by("o.order_id");
			return $this->db->get()->result();
		}
	}
	// get order by id
	public function get_order_by_id($order_id)
	{
		return $this->db->select('*')->from('orders')->where('order_id', $order_id)->get()->result();
	}
	// get order with user_id and order_id to confrim cancelation
	public function seller_cancel_confrim($user_id,$order_id){
		$result = $this->db->select('order_id')->from('orders')->where('user_id',$user_id)->where('order_id',$order_id)->get()->result();
		return $result;
	}
	// cancel order
	public function cancel_order($order)
	{
		$this->db->insert('cancel_order', $order);

		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	// public function check if order exist in cancelled
	public function if_cancelled($order_id)
	{
		$row = $this->db->select('*')->from('cancel_order')->where('order_id', $order_id)->get();
		if ($row->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	// delete cancelled order
	public function delete_cancelled_order($order_id)
	{

		$this->db->trans_start();

		$this->db->where('order_id', $order_id);
		$this->db->delete('orders');

		$this->db->where('order_id', $order_id);
		$this->db->delete('orders_delivered');

		$this->db->where('order_id', $order_id);
		$this->db->delete('cancel_order');

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			// Transaction failed
			return false;
		} else {
			// Transaction successful
			return true;
		}
		
	}
	// Getting product items 
	public function get_product_items()
	{
		if($this->session->userdata('user_session')->role_id == 2){
			$this->db->select('pi.id,pi.product_name,pi.price,pi.quantity,ss.quantity as asinged_quantity')->from('product_items pi');
			$this->db->join('seller_stock ss'," ss.product_id = pi.id");
			return $this->db->get()->result_array();
		}else{
			return $this->db->select('*')->from('product_items pi')->get()->result_array();
		}
		
		
		
		
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

	public function save_deliver_order($data)
	{
		$this->db->insert('orders_delivered', $data);
		return $this->db->insert_id();
	}

	public function get_records()
	{
		// return $this->db->select('*')->from('orders')
		// 		// ->join('users','users.id = orders.user_id','right')
		// 		// ->join('vendors','vendors.id = orders.vendor_id','right')
		// 		->get()->result();
		$this->db->select('or.order_id,users.name,ven.vendor_name,pi.product_name,od.sub_total,od.discount,od.paid_amount,od.due_amount');
		$this->db->from('orders or');
		$this->db->join('users', 'users.id = or.user_id');
		$this->db->join('vendors ven', 'ven.id = or.vendor_id');
		$this->db->join('product_items pi', 'pi.id = or.product_id');
		$this->db->join('orders_delivered od', 'or.order_id = od.order_id');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			// dd($result);
		} else {
			$result = null;
		}
		return $result;
	}

	public function get_deliverOrder_details($order_id)
	{
		$this->db->select("*,or.quantity as order_quantity");
		$this->db->from("orders or");
		$this->db->join('vendors ve', 'or.vendor_id = ve.id');
		$this->db->join('product_items pr', 'or.product_id = pr.id');
		$this->db->join('orders_delivered od', 'or.order_id = od.order_id');
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

	//get vendor id for generating pdf
	public function get_vendor_id($order_id)
	{
		return $this->db->select('vendor_id')->from('orders')->where('order_id', $order_id)->get()->row();
	}

	public function update_product_quantity($product_id, $quantity)
	{
		$current_quantity = $this->db->get_where('product_items', array('id' => $product_id))->row()->quantity;

		$new_quantity = $current_quantity - $quantity;

		$this->db->where('id', $product_id);
		$this->db->update('product_items', array('quantity' => $new_quantity));

		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function update_stock($product_id, $quantity, $user_id)
	{
		$stock_data = $this->db->get_where('seller_stock', array('product_id' => $product_id, 'user_id' => $user_id))->row();
		if ($stock_data) {
			$current_quantity = $this->db->get_where('seller_stock', array('product_id' => $product_id, 'user_id' => $user_id))->row()->quantity;
			$new_quantity = $current_quantity - $quantity;

			$this->db->where('product_id', $product_id);
			$this->db->where('user_id', $user_id);
			$this->db->update('seller_stock', array('quantity' => $new_quantity));

			if ($this->db->affected_rows() > 0) {
				return true;
			} else {
				return false;
			}
		}
	}

	public function get_product_quantity($product_id)
	{
		$this->db->select('quantity');
		$this->db->from('product_items');
		$this->db->where('id', $product_id);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row()->quantity;
		} else {
			return 0;
		}
	}
	public function get_seller_assinged_quantity($product_id)
	{
		$this->db->select('quantity');
		$this->db->from('seller_stock');
		$this->db->where('product_id', $product_id);
		$this->db->where('user_id', $this->session->userdata('user_session')->id);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row()->quantity;
		} else {
			return 0;
		}
	}
	// get sellers assinged products.
	// public function get_assinged_products(){
	// 	$this->db->select('*');
	//     $this->db->from('product_items pi');
	//     $this->db->join('seller_stock ss','pi.id = ss.product_id');
	//     $this->db->where('user_id', $this->session->userdata('user_session')->id);
	//     $query = $this->db->get()->result();
	// 	return $query;

	// }
}
