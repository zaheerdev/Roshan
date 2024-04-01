<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends CI_Controller
{

	/**
	 * __construct
	 *
	 * @return void
	 */
	function __construct()
	{
		parent::__construct();

		if (!$this->session->userdata('user_session')->logged_in) {
			redirect(BASE_URL . 'auth/login');
		}

		$this->load->model('order_model');
		$this->load->model('vendor_model');
	} //end function 

	public function book_order()
	{
		$data['vendors'] = $this->vendor_model->get_vendors();
		$data['product_items'] = $this->order_model->get_product_items();
		$this->load->view('admin_dashboard/order/book_order', $data);
	}

	public function save_order()
	{
		if ($this->input->server('REQUEST_METHOD') === 'POST') {

			$post_data = file_get_contents("php://input");

			$formData = json_decode($post_data, true);

			$order_id = sprintf('%04d', mt_rand(1, 9999));

			while ($this->order_model->isOrderIdExists($order_id)) {
				$order_id = sprintf('%04d', mt_rand(1, 9999));
			}

			$result = $this->order_model->processOrder($formData['vendorId'], $formData['productItems'], $order_id);

			if ($result) {
				echo json_encode(array('success' => true, 'message' => 'Order processed successfully'));
			} else {
				echo json_encode(array('success' => false, 'error' => 'Failed to process order'));
			}
		} else {
			echo json_encode(array('success' => false, 'error' => 'Invalid request method'));
		}
	}

	public function deliver_order()
	{
		$this->load->view('admin_dashboard/order/deliver_order');
	}

	public function get_order_details() {
        $order_id = $this->input->post('order_id');
        $order_details = $this->order_model->getOrderDetails($order_id);

        if ($order_details) {
            $data = array(
                'order_details' => $order_details,
            );
            $this->load->view('admin_dashboard/order/order_details', $data);
        } else {
            echo "No order found with the given ID.";
        }
    }
}
