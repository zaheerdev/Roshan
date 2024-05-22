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
	private $user_id;
	private $user_role;
	function __construct()
	{
		
		parent::__construct();

		if (!$this->session->userdata('user_session')->logged_in) {
			redirect(BASE_URL . 'auth/login');
		}
		$this->load->helper('download');
		$this->setUserData();
	} //end function 
	public function setUserData(){
		$this->user_id = $this->session->userdata('user_session')->id;
		$this->user_role = $this->session->userdata('user_session')->role_id;
	}

	// Function for booking order
	public function book_order()
	{
		if ($this->user_role == 1) {
			$data['page_title'] = "Roshan | Book Order";
			$data['vendors'] = $this->vendor_model->get_vendors(null);
			$data['product_items'] = $this->order_model->get_product_items();
			$this->load->view('admin_dashboard/order/book_order', $data);
		} else {
			$data['page_title'] = "Roshan | Book Order";
			$data['vendors'] = $this->vendor_model->get_vendors($this->user_id);
			$data['product_items'] = $this->order_model->get_product_items();
			$this->load->view('admin_dashboard/order/book_order', $data);
		}
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
				foreach ($formData['productItems'] as $item) {
					$this->order_model->update_product_quantity($item['productId'], $item['quantity']);
				}
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
		$options->set('isRemoteEnabled', true);

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
	public function deliver_order($order_id = null)
	{
		$data['page_title'] = "Roshan | Deliver Order";
		// dd($order_id);
		if (!empty($order_id)) {
			$data['order_id'] = $order_id;
			$this->load->view('admin_dashboard/order/deliver_order', $data);
		} else {
			$this->load->view('admin_dashboard/order/deliver_order', $data);
		}
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
		$order_id = trim(html_escape($this->input->post('order_id')));
		$sub_total = round((float)trim(html_escape($this->input->post('total'))));
		$discount_percentage = round((float)trim(html_escape($this->input->post('discount'))));
		$paid_amount = round((float)trim(html_escape($this->input->post('paid_amount'))));
		$due_amount = round((float)trim(html_escape($this->input->post('due_amount'))));
		$net_total = round((float)trim(html_escape($this->input->post('net_total'))));


		// Calculate due amount if it's not provided in the form
		if (empty($due_amount)) {
			$discount_amount = round(($sub_total * $discount_percentage) / 100);
			$net_total = round($sub_total - $discount_amount);
			$due_amount = round($net_total - $paid_amount);
		}

		if ($paid_amount > $net_total) {
			$this->session->set_flashdata('error', "The paid amount exceeds the net total value.");
			redirect(BASE_URL . 'order/deliver_order/' . $order_id);
		}

		$data = array(
			'order_id' => $order_id,
			'sub_total' => $sub_total,
			'discount' => $discount_percentage,
			'net_total' => $net_total,
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

		// redirect($_SERVER['HTTP_REFERER']);
		redirect(BASE_URL . 'order/preview_deliver_order/' . $order_id);
	}

	// Function for view the order details
	public function preview_deliver_order($order_id)
	{
		$order_details = $this->order_model->get_deliverOrder_details($order_id);

		$vendor_id = $this->order_model->get_vendor_id($order_id)->vendor_id;
		$pdf_filename = $this->generate_d_order_pdf($order_id, $vendor_id);

		if ($order_details) {
			$data = array(
				'page_title' => "Roshan | Preview Deliver Order",
				'order_details' => $order_details,
				'pdf_filename' => $pdf_filename
			);
			$this->load->view('admin_dashboard/order/deliver_order_preview', $data);
		} else {
			echo "No order found with the given ID.";
		}
	}

	// Function to share PDF via WhatsApp
	// public function deliver_order_pdf($order_id)
	// {
	// 	$vendor_id = $this->order_model->get_vendor_id($order_id)->vendor_id;

	// 	$pdf_filename = $this->generate_d_order_pdf($order_id,$vendor_id);

	// 	force_download(FCPATH . 'assets/delivered_invoices/vendor-'.$vendor_id.'/' .$pdf_filename,null,TRUE);

	// }

	// Function for generating deliver order pdf
	private function generate_d_order_pdf($order_id, $vendor_id)
	{
		$pdf_filename = 'order_' . $order_id . '.pdf';
		$pdf_path = FCPATH . 'assets/delivered_invoices/vendor-' . $vendor_id . '/' . $pdf_filename;

		// Check if the PDF file already exists
		if (file_exists($pdf_path)) {
			return $pdf_filename;
		}

		$data['order_details'] = $this->order_model->get_deliverOrder_details($order_id);

		$html = $this->load->view('admin_dashboard/order/deliver_invoice', $data, true);

		$options = new Options();

		$options->set('isHtml5ParserEnabled', true);
		$options->set('isRemoteEnabled', true);

		$dompdf = new Dompdf($options);

		$dompdf->loadHtml($html);

		$dompdf->setPaper('A4', 'portrait');

		$dompdf->render();

		$pdf_filename = 'order_' . $order_id . '.pdf';

		$output = $dompdf->output();

		if (is_dir(FCPATH . 'assets/delivered_invoices/vendor-' . $vendor_id)) {
			file_put_contents(FCPATH . 'assets/delivered_invoices/vendor-' . $vendor_id . '/' . $pdf_filename, $output);
		} else {
			mkdir(FCPATH . 'assets/delivered_invoices/vendor-' . $vendor_id);
			file_put_contents(FCPATH . 'assets/delivered_invoices/vendor-' . $vendor_id . '/' . $pdf_filename, $output);
		}

		return $pdf_filename;
	}
}
