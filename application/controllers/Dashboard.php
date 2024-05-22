<?php

use function PHPSTORM_META\type;

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
		// $user_id = $this->session->userdata('user_session')->id;
		$data['user_role'] = $user_role;
		if ($user_role == 2) {
			$data['total_paid_amount'] = $this->dashboard_model->getTotalPaidAmount($user_role);
			$data['total_due_amount'] = $this->dashboard_model->getTotalDueAmount($user_role);
			// $data['total_expense_amount'] = $this->dashboard_model->getTotalExpenseAmount();
			$data['total_sales'] = $this->dashboard_model->getTotalSales($user_role);

			$result = $this->dashboard_model->monthlysale($user_role);
			$data['months'] = $result['months'];
			$data['monthly_net_total'] = $result['monthly_net_total'];
			$data['monthly_total_paid'] = $result['monthly_total_paid'];
			$data['monthly_total_due'] = $result['monthly_total_due'];
		} else {
			$data['total_paid_amount'] = $this->dashboard_model->getTotalPaidAmount(null);
			$data['total_due_amount'] = $this->dashboard_model->getTotalDueAmount(null);
			$data['total_expense_amount'] = $this->dashboard_model->getTotalExpenseAmount(null);
			$data['total_sales'] = $this->dashboard_model->getTotalSales(null);
			
			$result = $this->dashboard_model->monthlysale(null);
			$data['months'] = $result['months'];
			$data['monthly_net_total'] = $result['monthly_net_total'];
			$data['monthly_total_paid'] = $result['monthly_total_paid'];
			$data['monthly_total_due'] = $result['monthly_total_due'];

			$total_expenses = $this->dashboard_model->monthly_expenses(null);
			$data['monthly_total_expenses'] = $total_expenses['monthly_total_expenses'];
		}
		// dd($data);
		// $data['total_paid_amount'] = $this->dashboard_model->getTotalPaidAmount(null);
		// $data['total_due_amount'] = $this->dashboard_model->getTotalDueAmount(null);
		// $data['total_expense_amount'] = $this->dashboard_model->getTotalExpenseAmount(null);
		// $data['total_sales'] = $this->dashboard_model->getTotalSales(null);

		// $result = $this->dashboard_model->monthlysale();
		// $data['months'] = $result['months'];
		// $data['monthly_net_total'] = $result['monthly_net_total'];
		// $data['monthly_total_paid'] = $result['monthly_total_paid'];
		// $data['monthly_total_due'] = $result['monthly_total_due'];

		// $total_expenses = $this->dashboard_model->monthly_expenses();
		// $data['monthly_total_expenses'] = $total_expenses['monthly_total_expenses'];

		if ($user_role == 1) :
			$this->load->view('admin_dashboard/index', $data);
		else :
			$this->load->view('admin_dashboard/index', $data);
		endif;
	}
}
