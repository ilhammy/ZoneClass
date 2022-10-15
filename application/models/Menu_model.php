<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model
{
	public $tm = "menu_sidebar";

	public function getMenu() {
		$this->db->from($this->tm);
		if ($this->session->userdata('role_id') != 0) $this->db->where('role_id', 'all');
		$this->db->order_by('position');
		return $this->db->get()->result();
	}

}