<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vendor_model extends CI_Model
{
    // Getting vendors
    public function get_vendors()
    {
        return $this->db->get('vendors')->result_array();
    } // function ends
}
