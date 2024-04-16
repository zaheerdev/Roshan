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
		$data['page_title'] = "Roshan | Revords";
		$this->load->view('admin_dashboard/record/records',$data);
	}
}
