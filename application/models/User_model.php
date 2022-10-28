<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {

	private $tu = 'users';
	private $tp = 'profile';

	public $prof_rules = array(
		array(
			'field' => 'fname',
			'label' => 'Nama Lengkap',
			'rules' => 'trim|required|min_length[5]|max_length[30]',
			'errors' => array(
				'required' => 'Nama Lengkap kosong',
				'min_length' => 'Minimal 5 karakter',
				'max_length' => 'Maksimal 32 karakter!'
			)
		),
		array(
			'field' => 'kel',
			'label' => 'Jenis Kelamin',
			'rules' => 'trim|required|in_list[Pria,Wanita]',
			'errors' => array(
				'required' => 'Jenis Kelamin kosong',
			),
		),
		array(
			'field' => 'ttl',
			'label' => 'Tanggal Lahir',
			'rules' => 'trim|required',
			'errors' => array(
				'required' => 'Tanggal Lahir kosong',
			),
		),
		array(
			'field' => 'whatsapp',
			'label' => 'No WhatsApp',
			'rules' => 'trim|required',
			'errors' => array(
				'required' => '%s kosong',
			),
		)
	);

	public function getAll($by = null) {
		if (is_null($by)) {
			return $this->db
			->join($this->tp, 'profile.uid = users.user_id', 'left')
			->get($this->tu)->result();
		} else if ($by === 3) {
			return $this->db
			->join($this->tp, 'profile.uid = users.user_id', 'left')
			->get_where($this->tu, ['isActive' => 0])->result();
		} else {
			return $this->db
			->join($this->tp, 'profile.uid = users.user_id', 'left')
			->get_where($this->tu, ['role_id' => $by])->result();
		}
	}

	public function getUserData($uid, $key) {
		$res = $this->db->get_where($this->tu, ['user_id' => $uid])->row_array();
		if ($res) return $res[$key];
		return null;
	}

	public function getProfile($uid, $key) {
		$res = $this->db->get_where($this->tp, ['uid' => $uid])->row_array();
		if ($res) return $res[$key];
		return null;
	}

	public function getByUid($uid) {
		$this->db->from($this->tu);
		$this->db->join($this->tp, 'profile.uid = users.user_id', 'left');
		$this->db->where('user_id', $uid);
		return $this->db->get()->row();
	}

	public function hasUsername($u) {
		$res = $this->db->get_where($this->tu, ['username' => $u])->row();
		if ($res) return true;
		return false;
	}

	public function hasEmail($e) {
		$res = $this->db->get_where($this->tu, ['email' => $e])->row();
		if ($res) return true;
		return false;
	}

	public function updateUserData($data, $uid = null) {
		if (is_null($uid)) $uid = myUid();
		$this->db->update($this->tu, $data, array('user_id' => $uid));
		return ($this->db->affected_rows() > 0);
	}

	public function updateProfile($data, $uid = null) {
		if (is_null($uid)) $uid = myUid();
		$this->db->update($this->tp, $data, array('uid' => $uid));
		return ($this->db->affected_rows() > 0);
	}

	public function updateFoto($url = null) {
		if (is_null($url)) return false;
		$data['foto'] = $url;
		$this->db->update($this->tp, $data, array('uid' => myUid()));
		return ($this->db->affected_rows() > 0);
	}

	public function hasProfile() {
		return $this->db->table_exists($this->tp);
	}

	public function updateKelas($uid = null) {
		if (is_null($uid)) $uid = myUid();
		$d = $this->db->get_where('kelas_user', ['id_user' => $uid])->result();
		$new = array();
		foreach ($d as $val) {
			$k = $this->db->get_where('kelas', ['id_kelas' => $val->id_kelas, 'status' => 1])->row();
			if ($k) array_push($new, intval($val->id_kelas));
		}
		$data = array(
			'kelas' => json_encode($new)
		);
		$this->db->update($this->tp, $data, array('uid' => $uid));
	}

}