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
	} //end function 

	public function add_inventory()
	{
		$data['page_title'] = "Roshan | Add Inventory";
		$this->load->view('admin_dashboard/inventory/add_inventory', $data);
	}

	public function save_inventory()
	{
		$data['page_title'] = "Roshan | Add Inventory";
		$this->form_validation->set_rules('raw_material1', 'Raw Material1', 'required');
		$this->form_validation->set_rules('raw_material2', 'Raw Material2', 'required');
		$this->form_validation->set_rules('raw_material3', 'Raw Material3', 'required');
		$this->form_validation->set_rules('raw_material4', 'Raw Material4', 'required');
		$this->form_validation->set_rules('raw_material5', 'Raw Material5', 'required');
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('admin_dashboard/inventory/add_inventory', $data);
		}
		 else {
			$inventory = array(
                "user_id" => $this->session->userdata('user_session')->id,
				"raw_material1" => trim(html_escape($this->input->post('raw_material1', TRUE))),
				"raw_material2" => trim(html_escape($this->input->post('raw_material2', TRUE))),
				"raw_material3" => trim(html_escape($this->input->post('raw_material3', TRUE))),
				"raw_material4" => trim(html_escape($this->input->post('raw_material4', TRUE))),
				"raw_material5" => trim(html_escape($this->input->post('raw_material5', TRUE)))
			);
			if ($this->inventory_model->save($inventory)) {
				$this->session->set_flashdata('success', "Inventory added successfully.");
				return redirect(BASE_URL . "inventory/add_inventory");
			}
		}
	}
}
