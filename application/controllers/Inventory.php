<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inventory extends CI_Controller
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
		if ($this->session->userdata('user_session')->role_id != 1) {
			redirect(BASE_URL . 'auth/login');
		}
	} //end function 

	public function inventory()
	{
		$data['page_title'] = "Roshan | Inventory";
		$data['raw_items'] = $this->inventory_model->get_raw_items();
		$this->load->view('admin_dashboard/inventory/inventory', $data);
	}

	public function add_product_inventory()
	{
		$data['page_title'] = "Roshan | Add Product Inventory";
		$data['product_items'] = $this->order_model->get_product_items();
		$this->load->view('admin_dashboard/inventory/add_product_inventory', $data);
	}

	public function save_product_inventory()
	{
		$data['page_title'] = "Roshan | Add Inventory";
		$this->form_validation->set_rules('product_id', 'Product ID', 'required');
		$this->form_validation->set_rules('quantity', 'Product Quantity', 'required');
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('admin_dashboard/inventory/inventory', $data);
		}
		 else {
			$product_id = trim(html_escape($this->input->post('product_id', TRUE)));
			$inventory = array(
				"quantity" => trim(html_escape($this->input->post('quantity', TRUE)))
			);
			if ($this->inventory_model->save_product_inventory($inventory, $product_id)) {
				$this->session->set_flashdata('success', "Product  quantity added successfully.");
				return redirect(BASE_URL . "inventory/inventory");
			}
		}
	}

	public function add_raw_inventory()
	{
		$data['page_title'] = "Roshan | Add Raw Inventory";
		$data['raw_items'] = $this->inventory_model->get_raw_items();
		$this->load->view('admin_dashboard/inventory/add_raw_inventory', $data);
	}

	public function save_raw_inventory()
	{
		$data['page_title'] = "Roshan | Add Raw Inventory";
		$this->form_validation->set_rules('material_id', 'Raw Material ID', 'required');
		$this->form_validation->set_rules('quantity', 'Raw Material Quantity', 'required');
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('admin_dashboard/inventory/inventory', $data);
		}
		 else {
			$material_id = trim(html_escape($this->input->post('material_id', TRUE)));
			$inventory = array(
				"quantity" => trim(html_escape($this->input->post('quantity', TRUE)))
			);
			if ($this->inventory_model->save_raw_inventory($inventory, $material_id)) {
				$this->session->set_flashdata('success', "Raw Material quantity added successfully.");
				return redirect(BASE_URL . "inventory/inventory");
			}
		}
	}
}
