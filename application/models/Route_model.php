<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Route_model extends CI_Model
{
	// Getting vendors
	public function get_routes()
	{
		return $this->db->get('routes')->result();
	} // function ends

	public function save($route)
	{
		$this->db->insert('routes', $route);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	} // function ends

	public function edit($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('routes');
		if ($query) {
			return $query->row();
		} else {
			false;
		}
	} // function ends

	public function update($route, $id)
	{
		$this->db->where('id', $id);
		$query = $this->db->update('routes', $route);
		if ($query) {
			return true;
		} else {
			return false;
		}
	} // function ends

	public function delete($id)
	{

		$this->db->where('id', $id);
		$query = $this->db->delete('routes');
		// also delete from route_vendor table
		$this->db->where('route_id', $id);
		$query2 = $this->db->delete('route_vendor');

		if ($query && $query2) {
			return true;
		} else {
			return false;
		}
	} // function ends
	// insert assinged vendors in route_vendor table
	public function save_assinged_vendors($data_array)
	{
		$this->db->insert_batch('route_vendor', $data_array);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	// get vendors in specific route
	public function vendors_in_route($route_id)
	{
		$this->db->select('rv.id as route_vendor_id,v.vendor_name,v.business_name,v.address,v.phone_no,r.id as route_id,r.route');
		$this->db->from('route_vendor rv');
		$this->db->where('route_id', $route_id);

		// joins
		$this->db->join('vendors v', 'v.id = rv.vendor_id');
		$this->db->join('routes r', 'r.id = rv.route_id');

		return $this->db->get()->result();
	}
	// remove dukandar from route
	public function remove_vendor_from_route($r_v_id)
	{
		$this->db->where('id', $r_v_id);
		$query = $this->db->delete('route_vendor');
		if ($query) {
			return true;
		} else {
			return false;
		}
	}
	

}
