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

	public function hasProfile() {
		return $this->db->table_exists($this->tp);
	}

	public function updateKelas($uid = null) {
		if (is_null($uid)) $uid = myUid();
		$d = $this->db->get_where('kelas_user', ['id_user' => $uid])->result();
		$new = array();
		foreach ($d as $val) {
			array_push($new, intval($val->id_kelas));
		}
		$data = array(
			'kelas' => json_encode($new)
		);
		$this->db->update($this->tp, $data, array('uid' => $uid));
	}

}