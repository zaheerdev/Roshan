<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Routes extends CI_Controller
{

	/**
	 * __construct
	 *
	 * @return void
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('route_model');
		$this->load->model('vendor_model');
		if (!$this->session->userdata('user_session')->logged_in) {
			redirect(BASE_URL . 'auth/login');
		}
		if ($this->session->userdata('user_session')->role_id != 1) {
			redirect(BASE_URL . 'dashboard');
		}
	} //end function 

	public function add_route()
	{
		$data['page_title'] = "Roshan | Add Route";
		$this->load->view('admin_dashboard/route/add_route', $data);
	}

	public function save_route()
	{
		$data['page_title'] = "Roshan | Save Route";
		$this->form_validation->set_rules('name', 'Route Name', 'required');
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('admin_dashboard/route/add_route', $data);
		} else {
			$route = array(
				"route" => trim(html_escape($this->input->post('name', TRUE)))
			);

			if ($this->route_model->save($route)) {
				$this->session->set_flashdata('success', "Route added successfully.");
				return redirect(BASE_URL . "routes/all_routes");
			}
		}
	}

	public function all_routes()
	{
		$data['page_title'] = "Roshan | All Routes";
		$data['routes'] = $this->route_model->get_routes();
		// dd($data['products']);
		$this->load->view('admin_dashboard/route/all_routes', $data);
	}

	public function edit_route($id)
	{
		$data['page_title'] = "Roshan | Edit Product";
		$data['route'] = $this->route_model->edit($id);
		if ($data['route'] == false) {
			$this->session->set_flashdata('route404', "Route not found");
			return redirect(BASE_URL . 'routes/all_routes');
		} else {
			$this->load->view("admin_dashboard/route/edit_route", $data);
		}
	}

	public function update_route($id)
	{
		$this->form_validation->set_rules('name', 'Route Name', 'required');


		if ($this->form_validation->run() == FALSE) {
			$errors['errors'] = validation_errors();
			$this->session->set_flashdata($errors);
			return redirect(BASE_URL . 'routes/edit_route/' . $id);
		} else {
			$route = array(
				"route" => trim(html_escape($this->input->post('name', TRUE)))
			);

			if ($this->route_model->update($route, $id)) {
				$this->session->set_flashdata('updated', "Route Updated Successfully");
				return redirect(BASE_URL . "routes/all_routes");
			}
		}
	}

	public function delete_route($id)
	{
		$route['route'] = $this->route_model->delete($id);
		if ($route['route'] == false) {
			$this->session->set_flashdata('delete', "Route delete error ");
			return redirect(BASE_URL . 'routes/all_routes');
		} else {
			$this->session->set_flashdata('delete', "Route deleted successfully ");
			return redirect(BASE_URL . 'routes/all_routes');
		}
	}

	// assign vendors to to route
	public function assign_vendor($id)
	{
		$data['page_title'] = "Roshan | Assign dukandars";
		$data['route_id'] = $id;
		$data['vendors'] = $this->vendor_model->get_vendors(null);
		$this->load->view("admin_dashboard/route/assign_vendor", $data);
	}
	// save assinged vendors to route
	public function save_assigned_vendors($route_id)
	{
		$data_array = array();
		$vendor_ids = $this->input->post('vendors');
		if (empty($vendor_ids)) {
			$errors['errors'] = "Please select dukandar you want to assign";
			$this->session->set_flashdata($errors);
			return redirect(BASE_URL . 'routes/assign_vendor/' . $route_id);
		} else {
			for ($i = 0; $i < count($vendor_ids); $i++) {
				$data = array(
					'route_id' => $route_id,
					'vendor_id' => $vendor_ids[$i]
				);
				array_push($data_array, $data);
			}
			if ($this->route_model->save_assinged_vendors($data_array)) {
				$this->session->set_flashdata('success', "Route was assinged successfully");
				return redirect(BASE_URL . 'routes/all_routes');
			} else {
				$this->session->set_flashdata('route404', "Something went wrong please try again");
				return redirect(BASE_URL . 'routes/all_routes');
			}
		}
	}
	// view vendors in specific route
	public function vendors_list($route_id)
	{
		$data['page_title'] = "Roshan | Dukandar list";
		$data['vendors'] = $this->route_model->vendors_in_route($route_id);
		// dd($data['vendors']);
		$this->load->view('admin_dashboard/route/vendor_list', $data);
	}

	// remove vendor from route
	public function delete_from_route($r_v_id,$route_id)
	{
		$this->route_model->remove_vendor_from_route($r_v_id);
		$this->session->set_flashdata('success', "Dukandar removed from route successfully");
		return redirect(BASE_URL . 'routes/vendors_list/'.$route_id);
	}

	
}
