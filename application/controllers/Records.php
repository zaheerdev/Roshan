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
<<<<<<< HEAD
		$data['page_title'] = "Roshan | Records";
		$data['records'] = $this->records_model->get_records();
=======
		$data['page_title'] = "Roshan | Records";
		$data['records'] = $this->order_model->get_records();
>>>>>>> 8cf7d241b968d94a19a34dc3347217c0df15699f
		$this->load->view('admin_dashboard/record/records',$data);
	}
}
