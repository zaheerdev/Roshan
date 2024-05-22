<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once FCPATH . 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class Records extends CI_Controller
{
	private $user_role;
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
		$this->load->helper('download');
		$this->setUserRole();
	} //end function 
	public function setUserRole(){
		$this->user_role = $this->session->userdata('user_session')->role_id;
	} 

	public function index()
	{
		
		$data['page_title'] = "Roshan | Records";
		if ($this->user_role == 2) {
			$data['records'] = $this->records_model->get_records($this->user_role);
			$this->load->view('admin_dashboard/record/records', $data);
		}else{
			$data['records'] = $this->records_model->get_records(null);
			$this->load->view('admin_dashboard/record/records', $data);
		}
	}

	public function due_payment($vendor_id = null)
	{
		$data['page_title'] = "Roshan | Due Payment";
		if (!is_null($vendor_id)) {
			$data['vendor_id'] = $vendor_id;
		}
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
		$this->form_validation->set_rules('paid_amount_percentage', 'Pay Amount', 'required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('pay_amount', validation_errors());
			return redirect(BASE_URL . 'records/due_payment/' . $this->input->post('vendor_id'));
		} else {
			$vendor_id = trim(html_escape($this->input->post('vendor_id')));
			$order_id = trim(html_escape($this->input->post('order_id')));
			$pay_amount = trim(html_escape($this->input->post('pay_amount')));
			$all_due_amount = trim(html_escape($this->input->post('due_amount')));
			$paid_amount_percentage = trim(html_escape($this->input->post('paid_amount_percentage')));
			$details = $this->records_model->get_amount_details($vendor_id);
			$total_paid_amount = 0;
			$total_due_amount = 0;
			$updated = false;
			if ((int)$pay_amount <= 0) {
				$this->session->set_flashdata('pay_amount', "Pay amount must be greter than 0");
				return redirect(BASE_URL . 'records/due_payment/' . $this->input->post('vendor_id'));
			}
			// if due amount 0 than redirect
			if ((int)$all_due_amount == 0) {
				$this->session->set_flashdata('pay_amount', "Due Amount is already paid.");
				return redirect(BASE_URL . 'records/due_payment/' . $this->input->post('vendor_id'));
			}
			foreach ($details as $detail) {

				$order_id = $detail->order_id;
				$amount_to_add_subtract = ($detail->due_amount * $paid_amount_percentage) / 100;
				if ($pay_amount <= $all_due_amount) {
					$total_paid_amount = $detail->paid_amount +  $amount_to_add_subtract;
					$total_due_amount = $detail->due_amount - $amount_to_add_subtract;
					$updated = $this->records_model->update_order_payment($order_id, $total_paid_amount, $total_due_amount);
				} else {
					$this->session->set_flashdata('exceed', 'Pay amount is more than due amount or due amount is 0');
					return redirect(BASE_URL . 'records/due_payment/' . $this->input->post('vendor_id'));
				}
			}
			if ($updated > 0) {
				$pdf_filename = $this->generate_payment_pdf($vendor_id);
				$filePath = BASE_URL . "/records/downloadPDF/" . $pdf_filename;
				// dd($pdf_filename);
				$this->session->set_flashdata('pay_amount', "Payment Added Successfully.");
				$this->session->set_flashdata('download_pdf', "<form action='{$filePath}'><input class='btn btn-success mb-2 rounded' type='submit' value='Download PDF'></form>");
				// return redirect(BASE_URL . 'records');
				return redirect(BASE_URL . 'records/due_payment/' . $vendor_id);
			}
		}
	} //ends function

	public function downloadPDF($pdf_filename)
	{
		force_download(FCPATH . 'assets/payment_invoices/' . $pdf_filename, null, TRUE);
	}
	// Function to share PDF via WhatsApp
	// public function share_payment_pdf($vendor_id)
	// {
	// 	$pdf_filename = $this->generate_payment_pdf($vendor_id);

	// 	// Share PDF via WhatsApp
	// 	$whatsapp_message = "Check out the vendor payment details in the following pdf link: " . BASE_URL . 'assets/payment_invoices/' . $pdf_filename;
	// 	$whatsapp_url = "https://api.whatsapp.com/send?text=" . urlencode($whatsapp_message);
	// 	redirect($whatsapp_url);
	// }

	// Function for generating payment pdf
	private function generate_payment_pdf($vendor_id)
	{
		$pdf_filename = 'vendor_' . $vendor_id . '_' . date('d/m/Y_His') . '.pdf';
		$pdf_path = FCPATH . 'assets/payment_invoices/' . $pdf_filename;

		// Check if the PDF file already exists
		if (file_exists($pdf_path)) {
			return $pdf_filename;
		}

		$data['payment_details'] = $this->records_model->get_payment_details($vendor_id);

		// dd($data['payment_details']);

		$html = $this->load->view('admin_dashboard/record/payment_invoice', $data, true);

		$options = new Options();

		$options->set('isHtml5ParserEnabled', true);
		$options->set('isRemoteEnabled', true);

		$dompdf = new Dompdf($options);

		$dompdf->loadHtml($html);

		$dompdf->setPaper('A4', 'portrait');

		$dompdf->render();

		$pdf_filename = 'vendor_' . $vendor_id . '__' . date('d-m-Y_His') . '.pdf';

		$output = $dompdf->output();

		file_put_contents(FCPATH . 'assets/payment_invoices/' . $pdf_filename, $output);

		return $pdf_filename;
	}
}
