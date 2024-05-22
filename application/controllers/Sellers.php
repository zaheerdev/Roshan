<?php

use function PHPSTORM_META\type;

defined('BASEPATH') or exit('No direct script access allowed');

class Sellers extends CI_Controller
{

	/**
	 * __construct
	 *
	 * @return void
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('seller_model');
		if (!$this->session->userdata('user_session')->logged_in) {
			redirect(BASE_URL . 'auth/login');
		}
	} //end function 

	public function add_seller()
	{
		$data['page_title'] = "Roshan | Add Seller";
		$this->load->view('admin_dashboard/seller/add_seller', $data);
	}

	public function save_seller()
	{
		$result = $this->seller_model->check_email(trim($this->input->post('email')));
		if ($result != null) {
			$this->session->set_flashdata('email_exist', "email already exist.");
			return redirect(BASE_URL . "sellers/add_seller");
		}
		// dd(gettype($result));
		// if($result->email)
		$data['page_title'] = "Roshan | Save Seller";
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required');


		if ($this->form_validation->run() == FALSE) {
			$this->load->view('admin_dashboard/seller/add_seller', $data);
		} else {
			$seller = array(
				"role_id" => 2,
				"name" => trim(html_escape($this->input->post('name', TRUE))),
				"email" => trim(html_escape(trim($this->input->post('email', TRUE)))),
				"password" => md5(trim(html_escape($this->input->post('password', TRUE)))),
			);
			if ($this->seller_model->save($seller)) {
				$this->session->set_flashdata('success', "seller added successfully.");
				return redirect(BASE_URL . "sellers/all_sellers");
			}
		}
	}

	public function all_sellers()
	{
		$data['page_title'] = "Roshan | All Sellers";
		$data['sellers'] = $this->seller_model->get_sellers();
		$this->load->view('admin_dashboard/seller/all_sellers', $data);
	}

	public function edit_seller($id)
	{
		$data['page_title'] = "Roshan | Edit Seller";
		$data['seller'] = $this->seller_model->edit($id);
		if ($data['seller'] == false) {
			$this->session->set_flashdata('seller404', "seller not found");
			return redirect(BASE_URL . '/sellers/all_sellers');
		} else {
			$this->load->view("admin_dashboard/seller/edit_seller", $data);
		}
	}

	public function update_seller($id)
	{
		$result = $this->seller_model->check_updated_email($id, trim($this->input->post('email')));
		if ($result != null) {
			$this->session->set_flashdata('email_exist', "email already exist.");
			return redirect(BASE_URL . "sellers/edit_seller/" . $id);
		}
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == FALSE) {
			$errors['errors'] = validation_errors();
			$this->session->set_flashdata($errors);
			return redirect(BASE_URL . 'sellers/edit_seller/' . $id);
		} else {
			$seller = array(
				"name" => trim(html_escape($this->input->post('name', TRUE))),
				"email" => trim(html_escape(trim($this->input->post('email', TRUE)))),
				"password" => md5(trim(html_escape($this->input->post('address', TRUE)))),
			);
			if ($this->seller_model->update($seller, $id)) {
				$this->session->set_flashdata('updated', "Seller Updated Successfully");
				return redirect(BASE_URL . "sellers/all_sellers");
			}
		}
	}

	public function delete_seller($id)
	{
		$seller['seller'] = $this->seller_model->delete($id);
		if ($seller['seller'] == false) {
			$this->session->set_flashdata('delete', "seller delete error ");
			return redirect(BASE_URL . '/sellers/all_sellers');
		} else {
			$this->session->set_flashdata('delete', "seller deleted successfully ");
			return redirect(BASE_URL . '/sellers/all_sellers');
		}
	}
	public function paid_amount($id, $filter = null)
	{

		
		if ($filter !== null) {
			$start = $this->input->post('start');
			$end = $this->input->post('end');
			$filter = $start."+".$end;
			// dd($filter);
			$data['id'] = $id;
			$data['page_title'] = "Roshan | Seller Paid Amount Details";
			$paid_amount = $this->seller_model->get_paid_details($id, $filter);
			$data['paid_amount'] = $paid_amount;
			// dd($result);
			$this->load->view('admin_dashboard/seller/paid_amount', $data);
		}

		$data['id'] = $id;
		$data['page_title'] = "Roshan | Seller Paid Amount Details";
		$paid_amount = $this->seller_model->get_paid_details($id, $filter);
		$data['paid_amount'] = $paid_amount;
		// dd($data);
		$this->load->view('admin_dashboard/seller/paid_amount', $data);
	}
}
