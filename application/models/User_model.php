<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {
	
	private $tu = 'users';
	private $tp = 'profile';
	
	public function getUserData($uid, $key) {
		$res = $this->db->get_where($this->tu, ['user_id' => $uid])->row_array();
		if ($res) return $res[$key];
		$this->db->close();
		return null;
	}
	
	public function getProfile($uid, $key) {
		$res = $this->db->get_where($this->tp, ['uid' => $uid])->row_array();
		if ($res) return $res[$key];
		$this->db->close();
		return null;
	}
	
}
