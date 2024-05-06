<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product extends CI_Controller
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

	public function add_product()
	{
		$data['page_title'] = "Roshan | Add Product";
		$this->load->view('admin_dashboard/product/add_product', $data);
	}

	public function save_product()
	{
		$data['page_title'] = "Roshan | Add Product";
		$this->form_validation->set_rules('product_name', 'Product Name', 'required');
		$this->form_validation->set_rules('product_price', 'Price', 'required');
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('admin_dashboard/product/add_product', $data);
		}
		 else {
			$product = array(
				"product_name" => $this->input->post('product_name', TRUE),
				"price" => $this->input->post('product_price', TRUE)
			);
			if((int)$product['price'] <= 0)
			{
				$this->session->set_flashdata('price','Price must be greater than 0');
				$data['price'] = 'Price must be greater than 0';
				return redirect(BASE_URL.'product/add_product');
			}
			// dd(gettype((int)$product['price']));
			if ($this->product_model->save($product)) {
				$this->session->set_flashdata('success', "Product added successfully.");
				return redirect(BASE_URL . "product/all_products");
			}
		}
	}

	public function all_products()
	{
		$data['page_title'] = "Roshan | All Products";
		$data['products'] = $this->product_model->get_products();
		// dd($data['products']);
		$this->load->view('admin_dashboard/product/all_products', $data);
	}

	public function edit_product($id)
	{
		$data['page_title'] = "Roshan | Edit Product";
		$data['product'] = $this->product_model->edit($id);
		if ($data['product'] == false) {
			$this->session->set_flashdata('product404', "Product not found");
			return redirect(BASE_URL . '/product/all_products');
		} else {
			$this->load->view("admin_dashboard/product/edit_product", $data);
		}
	}

	public function update_product($id)
	{
		$this->form_validation->set_rules('product_name', 'Product Name', 'required');
		$this->form_validation->set_rules('product_price', 'Price', 'required');

		if ($this->form_validation->run() == FALSE) {
			$errors['errors'] = validation_errors();
			$this->session->set_flashdata($errors);
			return redirect(BASE_URL . 'product/edit_product/' . $id);
		} else {
			$product = array(
				"product_name" => $this->input->post('product_name', TRUE),
				"price" => $this->input->post('product_price', TRUE)
			);
			if((int)$product['price'] <= 0)
			{
				$this->session->set_flashdata('price','Price must be greater than 0');
				$data['price'] = 'Price must be greater than 0';
				return redirect(BASE_URL.'product/edit_product/'.$id);
			}
			if ($this->product_model->update($product, $id)) {
				$this->session->set_flashdata('updated', "Product Updated Successfully");
				return redirect(BASE_URL . "product/all_products");
			}
		}
	}

	public function delete_product($id)
	{
		$vendor['product'] = $this->product_model->delete($id);
		if ($vendor['product'] == false) {
			$this->session->set_flashdata('delete', "Product delete error ");
			return redirect(BASE_URL . '/product/all_products');
		} else {
			$this->session->set_flashdata('delete', "Product deleted successfully ");
			return redirect(BASE_URL . '/product/all_products');
		}
	}
}
