<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Records extends CI_Controller
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
	} //end function 

	public function index()
	{
		$data['page_title'] = "Roshan | Records";
		$data['records'] = $this->records_model->get_records();
		$this->load->view('admin_dashboard/record/records', $data);
	}

	public function due_payment()
	{
		$data['page_title'] = "Roshan | Due Payment";
		// $data['records'] = $this->records_model->get_records();
		$this->load->view('admin_dashboard/record/due-payment', $data);
	}

	// Function for getting amount details 
	public function get_amount_details()
	{
		$vendor_id = trim($this->input->post('vendor_id'));
		$details = $this->records_model->get_amount_details($vendor_id);
		if ($details) {
			$data = array(
				'details' => $details,
			);
			$this->load->view('admin_dashboard/record/amount_details', $data);
		} else {
			echo "<p class='p-3'>No info found with the given vendor ID.</p>";
		}
	}

	public function save_payment()
	{
		$vendor_id = $this->input->post('vendor_id');
		$order_id = $this->input->post('order_id');
		$paid_amount_percentage = $this->input->post('paid_amount_percentage');
		$details = $this->records_model->get_amount_details($vendor_id);

		$total_paid_amount = 0;
		$total_due_amount = 0;

		foreach ($details as $detail) {
			$order_id = $detail->order_id;
			$total_paid_amount = $detail->paid_amount +  $paid_amount_percentage;
			$total_due_amount = $detail->due_amount - $paid_amount_percentage;
			$this->records_model->update_order_payment($order_id, $total_paid_amount, $total_due_amount);
		}
	}
}
