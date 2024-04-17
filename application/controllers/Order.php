<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once FCPATH . 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

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
	} //end function 

	// Function for booking order
	public function book_order()
	{
		$data['page_title'] = "Roshan | Book Order";
		$data['vendors'] = $this->vendor_model->get_vendors();
		$data['product_items'] = $this->order_model->get_product_items();
		$this->load->view('admin_dashboard/order/book_order', $data);
	}

	// Function for saving order
	public function save_order()
	{
		if ($this->input->server('REQUEST_METHOD') === 'POST') {

			$post_data = file_get_contents("php://input");

			$formData = json_decode($post_data, true);

			$order_id = sprintf('%04d', mt_rand(1, 9999));

			while ($this->order_model->isOrderIdExists($order_id)) {
				$order_id = sprintf('%04d', mt_rand(1, 9999));
			}

			$result = $this->order_model->process_order($formData['vendorId'], $formData['productItems'], $order_id);

			if ($result) {
				echo json_encode(array('success' => true, 'order_id' => $order_id, 'message' => 'Order processed successfully'));
			} else {
				echo json_encode(array('success' => false, 'error' => 'Failed to process order'));
			}
		} else {
			echo json_encode(array('success' => false, 'error' => 'Invalid request method'));
		}
	}

	// Function for view the order details
	public function preview_order($order_id)
	{
		$order_details = $this->order_model->get_order_details($order_id);
		// dd($order_details);
		if ($order_details) {
			$data = array(
				'page_title' => "Roshan | Preview Order",
				'order_details' => $order_details,
			);
			$this->load->view('admin_dashboard/order/preview_order', $data);
		} else {
			echo "No order found with the given ID.";
		}
	}

	// Function to share PDF via WhatsApp
	public function share_pdf($order_id)
	{
		$pdf_filename = $this->generate_pdf($order_id);

		// Share PDF via WhatsApp
		$whatsapp_message = "Check out the order details in the following pdf link: " . BASE_URL . 'assets/invoices/' . $pdf_filename;
		$whatsapp_url = "https://api.whatsapp.com/send?text=" . urlencode($whatsapp_message);
		redirect($whatsapp_url);
	}

	// Function for generating pdf
	private function generate_pdf($order_id)
	{
		$pdf_filename = 'order_' . $order_id . '.pdf';
		$pdf_path = FCPATH . 'assets/invoices/' . $pdf_filename;

		// Check if the PDF file already exists
		if (file_exists($pdf_path)) {
			return $pdf_filename;
		}

		$data['order_details'] = $this->order_model->get_order_details($order_id);

		$html = $this->load->view('admin_dashboard/order/invoice', $data, true);

		$options = new Options();

		$options->set('isHtml5ParserEnabled', true);

		$dompdf = new Dompdf($options);

		$dompdf->loadHtml($html);

		$dompdf->setPaper('A4', 'portrait');

		$dompdf->render();

		$pdf_filename = 'order_' . $order_id . '.pdf';

		$output = $dompdf->output();

		file_put_contents(FCPATH . 'assets/invoices/' . $pdf_filename, $output);

		return $pdf_filename;
	}

	// Function for delivering order 
	public function deliver_order()
	{
		$data['page_title'] = "Roshan | Deliver Order";
		$this->load->view('admin_dashboard/order/deliver_order', $data);
	}

	// Function for getting order details 
	public function get_order_details()
	{
		$order_id = trim($this->input->post('order_id'));
		$order_details = $this->order_model->get_order_details($order_id);
		// dd($order_details);
		if ($order_details) {
			$data = array(
				'order_details' => $order_details,
			);
			$this->load->view('admin_dashboard/order/order_details', $data);
		} else {
			echo "<p class='p-3'>No order found with the given order ID.</p>";
		}
	}

	// Function for saving deliver order
	public function save_deliver_order()
	{
		$order_id = $this->input->post('order_id');
		$sub_total = $this->input->post('total');
		$discount_percentage = $this->input->post('discount');
		$paid_amount = $this->input->post('paid_amount');
		$due_amount = $this->input->post('due_amount');

		// Calculate due amount if it's not provided in the form
		if (empty($due_amount)) {
			$discount_amount = ($sub_total * $discount_percentage) / 100;
			$net_total = $sub_total - $discount_amount;
			$due_amount = $net_total - $paid_amount;
		}

		$data = array(
			'order_id' => $order_id,
			'sub_total' => $sub_total,
			'discount' => $discount_percentage,
			'paid_amount' => $paid_amount,
			'due_amount' => $due_amount,
			'user_id' => $this->session->userdata('user_session')->id
		);
		$deliver_order_id = $this->order_model->save_deliver_order($data);

		if ($deliver_order_id) {
			$this->session->set_flashdata('toast_message', 'Order delivered successfully');
		} else {
			$this->session->set_flashdata('toast_message', 'Error occurred while saving delivery order');
		}

		redirect($_SERVER['HTTP_REFERER']);
	}
}
