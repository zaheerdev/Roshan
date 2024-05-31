<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vendor extends CI_Controller
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
		$this->user_id = $this->session->userdata('user_session')->id ?? '';
		$this->user_role = $this->session->userdata('user_session')->role_id ?? '';
	} //end function 

	public function add_vendor()
	{
		$data['page_title'] = "Roshan | Add Vendor";
		$this->load->view('admin_dashboard/vendor/add_vendor', $data);
	}

	public function save_vendor()
	{
		$data['page_title'] = "Roshan | Add Vendor";
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('bussiness', 'Bussiness Name', 'required');
		$this->form_validation->set_rules('address', 'Address', 'required');
		$this->form_validation->set_rules('phone', 'Phone', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('admin_dashboard/vendor/add_vendor', $data);
		} else {
			$vendor = array(
				"user_id" => $this->user_id,
				"vendor_name" => trim(html_escape($this->input->post('name', TRUE))),
				"business_name" => trim(html_escape($this->input->post('bussiness', TRUE))),
				"address" => trim(html_escape($this->input->post('address', TRUE))),
				"phone_no" => trim(html_escape($this->input->post('phone', TRUE)))
			);
			if ($this->vendor_model->save($vendor)) {
				$this->session->set_flashdata('success', "Vendor added successfully.");
				return redirect(BASE_URL . "vendor/all_vendors");
			}
		}
	}

	public function all_vendors()
	{
		if($this->user_role == 1){
			$data['page_title'] = "Roshan | All Vendors";
			$data['vendors'] = $this->vendor_model->get_vendors(null);
			$this->load->view('admin_dashboard/vendor/all_vendors', $data);
		}else{
			$data['page_title'] = "Roshan | All Vendors";
			$data['vendors'] = $this->vendor_model->get_vendors($this->user_id);
			$this->load->view('admin_dashboard/vendor/all_vendors', $data);
		}
		
	}

	public function edit_vendor($id)
	{
		if($this->user_role == 1){
			$data['page_title'] = "Roshan | Edit Vendor";
		$data['vendor'] = $this->vendor_model->edit($id);
		if ($data['vendor'] == false) {
			$this->session->set_flashdata('vendor404', "Vendor not found");
			return redirect(BASE_URL . '/vendor/all_vendors');
		} else {
			$this->load->view("admin_dashboard/vendor/edit_vendor", $data);
		}
		}else{
			return redirect(BASE_URL . '/vendor/all_vendors');
		}
	}

	public function update_vendor($id)
	{
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('bussiness', 'Bussiness Name', 'required');
		$this->form_validation->set_rules('address', 'Address', 'required');
		$this->form_validation->set_rules('phone', 'Phone', 'required');

		if ($this->form_validation->run() == FALSE) {
			$errors['errors'] = validation_errors();
			$this->session->set_flashdata($errors);
			return redirect(BASE_URL . 'vendor/edit_vendor/' . $id);
		} else {
			$vendor = array(
				"vendor_name" => trim(html_escape($this->input->post('name', TRUE))),
				"business_name" => trim(html_escape($this->input->post('bussiness', TRUE))),
				"address" => trim( html_escape($this->input->post('address', TRUE))),
				"phone_no" => trim(html_escape($this->input->post('phone', TRUE)))
			);
			if ($this->vendor_model->update($vendor, $id)) {
				$this->session->set_flashdata('updated', "Vendor Updated Successfully");
				return redirect(BASE_URL . "vendor/all_vendors");
			}
		}
	}

	public function delete_vendor($id)
	{
		if($this->user_role == 1){
			$vendor['vendor'] = $this->vendor_model->delete($id);
		if ($vendor['vendor'] == false) {
			$this->session->set_flashdata('delete', "Vendor delete error ");
			return redirect(BASE_URL . '/vendor/all_vendors');
		} else {
			$this->session->set_flashdata('delete', "Vendor deleted successfully ");
			return redirect(BASE_URL . '/vendor/all_vendors');
		}
		}else{
			return redirect(BASE_URL . 'vendor/all_vendors');
		}
		
	}
}
