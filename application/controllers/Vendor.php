<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vendor extends CI_Controller
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

		$this->load->model('order_model');
		$this->load->model('vendor_model');
	} //end function 

	public function addvendor()
	{
		$this->load->view('admin_dashboard/vendor/addvendor');
	}

	public function savevendor()
	{
		$this->load->library('form_validation');
		// $request = $this->input->post('submit',TRUE);

		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('bussiness','Bussiness Name','required');
		$this->form_validation->set_rules('address', 'Address', 'required');
		$this->form_validation->set_rules('phone', 'Phone', 'required');

		if($this->form_validation->run() == FALSE){
			$this->load->view('admin_dashboard/vendor/addvendor');
		}else{
			$vendor = array(
				"name"=> $this->input->post('name',TRUE),
				"business_name" => $this->input->post('bussiness',TRUE),
				"Address" => $this->input->post('address',TRUE),
				"Phone" => $this->input->post('phone',TRUE)
			);
			if($this->vendor_model->save($vendor)){
				$this->session->set_flashdata('success',"vendor added successfully.");
				return redirect(BASE_URL."vendor/allvendors");
			}
		}

	}

	public function allvendors()
	{
		$data['vendors'] = $this->vendor_model->get_vendors();
		$this->load->view('admin_dashboard/vendor/vendors',$data);
	}

	public function editvendor($id){
		// $this->load->view('admin_dashboard/vendor/editvendor',$id);
		$vendor['vendor'] = $this->vendor_model->edit($id);
		if($vendor['vendor'] == false){
			$this->session->set_flashdata('vendor404',"Vendor not found");
			return redirect(BASE_URL.'/vendor/allvendors');
		}else{
			$this->load->view("admin_dashboard/vendor/editvendor",$vendor);
		}
	}
	public function updatevendor($id){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('bussiness','Bussiness Name','required');
		$this->form_validation->set_rules('address', 'Address', 'required');
		$this->form_validation->set_rules('phone', 'Phone', 'required');

		if($this->form_validation->run() == FALSE){
			$errors['errors'] = validation_errors();
			$this->session->set_flashdata($errors);
			return redirect(BASE_URL.'vendor/editvendor/'.$id);
		}else{
			$vendor = array(
				"name"=> $this->input->post('name',TRUE),
				"business_name" => $this->input->post('bussiness',TRUE),
				"Address" => $this->input->post('address',TRUE),
				"Phone" => $this->input->post('phone',TRUE)
			);
			if($this->vendor_model->update($vendor,$id)){
				$this->session->set_flashdata('updated',"Vendor Updated Successfully");
				return redirect(BASE_URL."vendor/allvendors");
			}
		}

	}
	public function deletevendor($id){
		// dd($id);
		// $this->load->view('admin_dashboard/vendor/editvendor',$id);

		$vendor['vendor'] = $this->vendor_model->delete($id);
		if($vendor['vendor'] == false){
			$this->session->set_flashdata('delete',"Vendor delete error ");
			return redirect(BASE_URL.'/vendor/allvendors');
		}else{
			$this->session->set_flashdata('delete',"Vendor deleted successfully ");
			return redirect(BASE_URL.'/vendor/allvendors');
		}
		
	}

	

	

	
}
