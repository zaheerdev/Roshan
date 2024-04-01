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
    public function processOrder($vendor_id, $productItems, $order_id)
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
            return true;
        } else {
            return false;
        }
    } // function ends

    public function isOrderIdExists($order_id)
    {
        $query = $this->db->get_where('orders', array('order_id' => $order_id));
        return ($query->num_rows() > 0);
    }

    public function getOrderDetails($order_id)
    {
        $this->db->select("*");
        $this->db->from("orders or");
        $this->db->join('vendors ve', 'or.vendor_id = ve.id');
        $this->db->join('product_items pr', 'or.product_id = pr.id');
        $this->db->where("or.order_id", $order_id);
        $query = $this->db->get();
        // print_r($this->db->last_query());
        // exit;
        if ($query->num_rows() > 0) {
            $result = $query->result();
        } else {
            $result = null;
        }
        return $result;

    } //function ends
}
