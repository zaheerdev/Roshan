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
	} //end function 

	public function book_order()
	{
		$this->load->view('admin_dashboard/order/book_order');
	}
}
