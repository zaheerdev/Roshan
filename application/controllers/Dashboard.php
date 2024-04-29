<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
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
		$data['page_title'] = "Roshan | Dashboard";
		$user_role = $this->session->userdata('user_session')->role_id;
		$data['total_paid_amount'] = $this->dashboard_model->getTotalPaidAmount();
		$data['total_due_amount'] = $this->dashboard_model->getTotalDueAmount();
		$data['total_expense_amount'] = $this->dashboard_model->getTotalExpenseAmount();
		$data['total_sales'] = $this->dashboard_model->getTotalSales();
		if($user_role == 1):
			$this->load->view('admin_dashboard/index', $data);
		else:
			$this->load->view('sales_dashboard/index', $data);
		endif;
	}
}
