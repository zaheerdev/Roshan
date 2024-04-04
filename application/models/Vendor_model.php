<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vendor_model extends CI_Model
{
    // Getting vendors
    public function get_vendors()
    {
        return $this->db->get('vendors')->result_array();
    } // function ends
    public function save($vendor)
    {
        $this->db->insert('vendors',$vendor);
		if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    } // function ends

	public function edit($id){
		$this->db->where('id',$id);
		$query = $this->db->get('vendors');
		if($query){
			return $query->row();
		}else{
			false;
		}
	}
	public function update($vendor,$id){
		$this->db->where('id',$id);
		$query = $this->db->update('vendors',$vendor);
		if($query){
			return true;
		}else{
			return false;
		}
	}
	public function delete($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->delete('vendors');
		if($query){
			return true;
		}else{
			return false;
		}
		
	}
}
