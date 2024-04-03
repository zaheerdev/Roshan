<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

	/**
	 * __construct
	 *
	 * @return void
	 */
	function __construct()
	{
		parent::__construct();
	} //end function

	/**
	 * login
	 *
	 * @return void
	 */
	public function login()
	{
		// if already logged in
		if (@$this->session->userdata('user_session')->logged_in) {
			redirect(BASE_URL . 'dashboard');
		}
		//end

		$data['page_title'] = "Roshan | Login";

		$this->form_validation->set_rules('login_as', 'Login As', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('auth/index', $data);
		} else {

			$login_as = $this->input->post('login_as');
			$email = $this->input->post('email');
			$password = md5($this->input->post('password'));

			$role_id_exists = $this->auth_model->check_user_role($email, $login_as);

			if ($role_id_exists) {
				$response = $this->auth_model->login($email, $password);
				if ($response) {
					$response->logged_in = true;
					$this->session->set_userdata('user_session', $response);

					if ($login_as  == 1) {
						redirect(BASE_URL . 'dashboard');
					} elseif ($login_as  == 2) {
						redirect(BASE_URL . 'dashboard');
					} else {
						redirect(BASE_URL . 'dashboard');
					}
				} else {
					$this->session->set_flashdata('login_failed', 'Please login with correct email & password');
					redirect(BASE_URL . 'auth/login');
				}
			} else {
				$this->session->set_flashdata('login_failed', 'Invalid user role');
				redirect(BASE_URL . 'auth/login');
			}
		}
	} //function end

	/**
	 * logout
	 *
	 * @return void
	 */
	public function logout()
	{
		unset($_SESSION['user_session']);
		redirect(BASE_URL . 'auth/login');
	} //function end
}
