<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model
{
	public $tm = "menu_sidebar";

	public function getMenu() {
		$q = $this->db
		->from($this->tm)
		->where('role_id', $this->myRole())
		->order_by('position')
		->get();
		return $q->result();
	}

	function myRole() {
		switch ($this->session->userdata('role_id')) {
			case 0:
				return 'admin';
			case 1:
				return 'all';
			default:
				return null;
		}
	}

}