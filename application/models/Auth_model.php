<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Auth_model
 */
class Auth_model extends CI_Model
{

    /**
     * login
     *
     * @param  mixed $email
     * @param  mixed $password
     * @return void
     */
    public function login($email, $password)
    {

        $this->db->select("*");
        $this->db->where("(email = '$email' AND password = '$password')");
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            $results = $query->row();
        } else {
            $results =  false;
        }
        return $results;
    } // function ends

    // checking user role
    public function check_user_role($email, $role_id) {
        $this->db->select('role_id');
        $this->db->from('users');
        $this->db->where('email', $email);
        $this->db->where('role_id', $role_id);
        $query = $this->db->get();
        return $query->num_rows() > 0;
    } // function ends

}//class end here