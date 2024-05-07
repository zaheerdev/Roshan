<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inventory_model extends CI_Model
{
	public function save($inventory)
	{
		$this->db->insert('inventories', $inventory);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	} // function ends
}
