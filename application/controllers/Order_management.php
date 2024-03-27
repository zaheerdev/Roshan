<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order_management extends CI_Controller
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

			$result = $this->order_model->processOrder($formData['vendorId'], $formData['productItems']);

			if ($result) {
				echo json_encode(array('success' => true, 'message' => 'Order processed successfully'));
			} else {
				echo json_encode(array('success' => false, 'error' => 'Failed to process order'));
			}
		} else {
			echo json_encode(array('success' => false, 'error' => 'Invalid request method'));
		}
	}
}
