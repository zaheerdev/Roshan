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
		$user_role = $this->session->userdata('user_session')->role_id;
		if($user_role == 1):
			$this->load->view('admin_dashboard/index');
		else:
			$this->load->view('sales_dashboard/index');
		endif;
	}
}
