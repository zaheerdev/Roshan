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
	private $user_role;
	private $user_id;
	function __construct()
	{
		parent::__construct();
		$this->load->model('seller_model');
		if (!$this->session->userdata('user_session')->logged_in) {
			redirect(BASE_URL . 'auth/login');
		}
		$this->user_role = $this->session->userdata('user_session')->role_id ?? '';
		$this->user_id = $this->session->userdata('user_session')->id ?? '';
	} //end function 

	public function add_seller()
	{
		if ($this->user_role == 1) {
			$data['page_title'] = "Roshan | Add Seller";
			$this->load->view('admin_dashboard/seller/add_seller', $data);
		} else {
			redirect(BASE_URL . 'dashboard');
		}
	}

	public function save_seller()
	{
		if ($this->user_role == 1) {
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
		} else {
			redirect(BASE_URL . 'dashboard');
		}
	}

	public function all_sellers()
	{
		$data['page_title'] = "Roshan | All Sellers";
		$data['user_role'] = $this->user_role;
		if ($this->user_role == 2) {
			$data['sellers'] = $this->seller_model->get_sellers($this->user_role);
			$this->load->view('admin_dashboard/seller/all_sellers', $data);
		} else {
			$data['sellers'] = $this->seller_model->get_sellers(null);
			$this->load->view('admin_dashboard/seller/all_sellers', $data);
		}
	}

	public function edit_seller($id)
	{
		if ($this->user_role == 1) {
			$data['page_title'] = "Roshan | Edit Seller";
			$data['seller'] = $this->seller_model->edit($id);
			if ($data['seller'] == false) {
				$this->session->set_flashdata('seller404', "seller not found");
				return redirect(BASE_URL . '/sellers/all_sellers');
			} else {
				$this->load->view("admin_dashboard/seller/edit_seller", $data);
			}
		} else {
			redirect(BASE_URL . 'dashboard');
		}
	}

	public function update_seller($id)
	{
		if ($this->user_role == 1) {
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
		} else {
			redirect(BASE_URL . 'dashboard');
		}
	}

	public function delete_seller($id)
	{
		if ($this->user_role == 1) {
			$seller['seller'] = $this->seller_model->delete($id);
			if ($seller['seller'] == false) {
				$this->session->set_flashdata('delete', "seller delete error ");
				return redirect(BASE_URL . '/sellers/all_sellers');
			} else {
				$this->session->set_flashdata('delete', "seller deleted successfully ");
				return redirect(BASE_URL . '/sellers/all_sellers');
			}
		} else {
			redirect(BASE_URL . 'dashboard');
		}
	}
	public function paid_amount($id, $filter = null)
	{

		if ($this->user_role == 1) {
			if ($filter !== null) {
				$start = $this->input->post('start');
				$end = $this->input->post('end');
				$filter = $start . "-to-" . $end;
				// dd($filter);
				$data['id'] = $id;
				$data['page_title'] = "Roshan | Seller Paid Amount Details";
				$data['user_role'] = $this->user_role;
				// not using yet
				// $paid_amount = $this->seller_model->get_paid_details($id, $filter);
				// $data['paid_amount'] = $paid_amount;
				$daily_orders = $this->seller_model->daily_delivered_orders($id, $filter);
				$data['daily_orders'] = $daily_orders;
				$data['filter'] = $filter;
				$data['collected_amount'] = $this->seller_model->get_collected_amount($id, $filter);
				$this->load->view('admin_dashboard/seller/paid_amount', $data);
			} else {
				$data['id'] = $id;
				$data['user_role'] = $this->user_role;
				$data['page_title'] = "Roshan | Seller Paid Amount Details";
				// not using this yet
				// $paid_amount = $this->seller_model->get_paid_details($id, $filter);
				// $data['paid_amount'] = $paid_amount;
				$daily_orders = $this->seller_model->daily_delivered_orders($id, $filter);
				$data['daily_orders'] = $daily_orders;
				$data['collected_amount'] = $this->seller_model->get_collected_amount($id, null);
				$this->load->view('admin_dashboard/seller/paid_amount', $data);
			}
		} elseif ($this->user_role == 2 && $this->user_id == $id) {
			if ($filter !== null) {
				$start = $this->input->post('start');
				$end = $this->input->post('end');
				$filter = $start . "-to-" . $end;
				// dd($filter);
				$data['id'] = $id;
				$data['page_title'] = "Roshan | Seller Paid Amount Details";
				$data['user_role'] = $this->user_role;
				// not using this yet
				// $paid_amount = $this->seller_model->get_paid_details($this->user_id, $filter);
				// $data['paid_amount'] = $paid_amount;
				$daily_orders = $this->seller_model->daily_delivered_orders($this->user_id, $filter);
				$data['daily_orders'] = $daily_orders;
				$data['filter'] = $filter;
				$data['collected_amount'] = $this->seller_model->get_collected_amount($this->user_id, $filter);
				$this->load->view('admin_dashboard/seller/paid_amount', $data);
			} else {
				$data['id'] = $id;
				$data['user_role'] = $this->user_role;
				$data['page_title'] = "Roshan | Seller Paid Amount Details";
				// not using yet
				// $paid_amount = $this->seller_model->get_paid_details($this->user_id, $filter);
				// $data['paid_amount'] = $paid_amount;
				$daily_orders = $this->seller_model->daily_delivered_orders($this->user_id, $filter);
				$data['daily_orders'] = $daily_orders;
				$data['collected_amount'] = $this->seller_model->get_collected_amount($this->user_id, null);
				$this->load->view('admin_dashboard/seller/paid_amount', $data);
			}
		} else {
			return redirect(BASE_URL . 'dashboard');
		}
	}
	public function getstockdetail($user_id = null)
	{

		if ($this->user_role == 2) {
			if ($user_id != null && $user_id == $this->user_id) {
				$data['page_title'] = "Roshan | Seller Stock";
				$data['stocks'] = $this->seller_model->get_assigned_stock($user_id);
				// dd($data['stocks']);
				$this->load->view('admin_dashboard/seller/seller_stock', $data);
			} else {
				redirect(BASE_URL . 'dashboard');
			}
		} else {
			// dd('inelse');
			if ($user_id != null) {
				// dd('in with userid');
				$data['page_title'] = "Roshan | Seller Stock";
				$data['stocks'] = $this->seller_model->get_assigned_stock($user_id);
				// dd($data['stocks']);
				$this->load->view('admin_dashboard/seller/seller_stock', $data);
			} else {
				// dd('in without userid');
				$data['page_title'] = "Roshan | Seller Stock";
				$data['stocks'] = $this->seller_model->get_assigned_stock(null);
				// dd($data['stocks']);
				$this->load->view('admin_dashboard/seller/seller_stock', $data);
			}
		}
		// dd($this->seller_model->get_assigned_stock(null));
	}
	public function edit_seller_stock($id)
	{
		if ($this->user_role == 1) {
			$data['page_title'] = "Roshan | Edit Seller Stock Quantity";
			$data['stock_detail'] = $this->seller_model->get_assinged_stock_of_seller($id);
			// dd($data['stock_detail']);
			$this->load->view('admin_dashboard/seller/edit_stock', $data);
		} else {
			return redirect(BASE_URL . 'dashboard');
		}
	}
	public function update_seller_stock($id)
	{
		$this->form_validation->set_rules('quantity', 'Quantity', 'required');
		if ($this->form_validation->run() == FALSE) {
			$errors['errors'] = validation_errors();
			$this->session->set_flashdata($errors);
			return redirect(BASE_URL . 'sellers/edit_seller_stock/' . $id);
		} else {
			if ($this->input->post('quantity') >= 0) {
				$quantity = array(
					"quantity" => trim(html_escape($this->input->post('quantity', TRUE))),

				);
				$updated = $this->seller_model->update_assinged_stock_of_seller($id, $quantity);
				if ($updated) {
					$errors['updated'] = "Quantity Updated Successfully";
					$this->session->set_flashdata($errors);
					return redirect(BASE_URL . 'sellers/getstockdetail');
				} else {
					$errors['again'] = "Please try again";
					$this->session->set_flashdata($errors);
					return redirect(BASE_URL . 'sellers/edit_seller_stock/' . $id);
				}
			} else {
				$errors['errors'] = "Quantity must be 0 or greater than 0";
				$this->session->set_flashdata($errors);
				return redirect(BASE_URL . 'sellers/edit_seller_stock/' . $id);
			}
		}
	}
}
