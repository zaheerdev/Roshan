<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Expenses extends CI_Controller
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

	public function add_expense()
	{
		$data['page_title'] = "Roshan | Add Expense";
		$this->load->view('admin_dashboard/expenses/add_expense', $data);
	}

	public function save_expense()
	{
		$data['page_title'] = "Roshan | Add Expense";
		$this->form_validation->set_rules('expense_name', 'Expense Name', 'required');
		$this->form_validation->set_rules('category', 'Category', 'required');
		$this->form_validation->set_rules('date', 'Date', 'required');
		$this->form_validation->set_rules('amount', 'Amount', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('admin_dashboard/expenses/add_expense', $data);
		} else {
			$vendor = array(
				"expense_name" => $this->input->post('expense_name', TRUE),
				"category" => $this->input->post('category', TRUE),
				"date" => $this->input->post('date', TRUE),
				"amount" => $this->input->post('amount', TRUE)
			);
			if((int)$vendor['amount'] <= 0)
			{
				$this->session->set_flashdata('amount','Amount must be greater than 0');
				$data['price'] = 'Price must be greater than 0';
				return redirect(BASE_URL.'expenses/add_expense');
			}
			if ($this->expenses_model->save($vendor)) {
				$this->session->set_flashdata('success', "Expense added successfully.");
				return redirect(BASE_URL . "expenses/all_expenses");
			}
		}
	}

	public function all_expenses()
	{
		$data['page_title'] = "Roshan | All Expenses";
		$data['expenses'] = $this->expenses_model->get_expenses();
		$this->load->view('admin_dashboard/expenses/all_expenses', $data);
	}

	public function edit_expense($id)
	{
		$data['page_title'] = "Roshan | Edit Expense";
		$data['expense'] = $this->expenses_model->edit($id);
		if ($data['expense'] == false) {
			$this->session->set_flashdata('expense404', "Expense not found");
			return redirect(BASE_URL . '/expenses/all_expenses');
		} else {
			$this->load->view("admin_dashboard/expenses/edit_expense", $data);
		}
	}

	public function update_expense($id)
	{
		$this->form_validation->set_rules('expense_name', 'Expense Name', 'required');
		$this->form_validation->set_rules('category', 'Category', 'required');
		$this->form_validation->set_rules('date', 'Date', 'required');
		$this->form_validation->set_rules('amount', 'Amount', 'required');

		if ($this->form_validation->run() == FALSE) {
			$errors['errors'] = validation_errors();
			$this->session->set_flashdata($errors);
			return redirect(BASE_URL . 'expenses/edit_expense/' . $id);
		} else {
			$expense = array(
				"expense_name" => $this->input->post('expense_name', TRUE),
				"category" => $this->input->post('category', TRUE),
				"date" => $this->input->post('date', TRUE),
				"amount" => $this->input->post('amount', TRUE)
			);
			if ($this->expenses_model->update($expense, $id)) {
				$this->session->set_flashdata('updated', "Expense Updated Successfully");
				return redirect(BASE_URL . "expenses/all_expenses");
			}
		}
	}

	public function delete_expense($id)
	{
		$vendor['expense'] = $this->expenses_model->delete($id);
		if ($vendor['expense'] == false) {
			$this->session->set_flashdata('delete', "Expense delete error ");
			return redirect(BASE_URL . '/expenses/all_expenses');
		} else {
			$this->session->set_flashdata('delete', "Expense deleted successfully ");
			return redirect(BASE_URL . '/expenses/all_expenses');
		}
	}
}
