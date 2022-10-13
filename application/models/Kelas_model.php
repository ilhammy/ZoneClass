<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kelas_model extends CI_Model {

	private $tk = 'kelas';
	private $tku = 'kelas_user';

	function getAllData() {
		$q = $this->db->from($this->tk)
		->order_by('dibuat', 'desc')->get();
		return $q->result();
		//return $this->db->get($this->tk)->result();
	}

	function getAllByUser($uid) {
		$this->db->select('*');
		$this->db->from('kelas a');
		$this->db->join('kelas_user b', 'b.id_kelas=a.id_kelas', 'left');
		$this->db->where('b.id_user', $uid);
		$this->db->order_by('b.bergabung', 'desc');
		$query = $this->db->get();
		return $query->result();
	}
	
	function getMyClass() {
		return $this->db->get_where($this->tk, [$this->tk . '.creator_id' => myUid()])->result();
	}
	
	function getAllSiswa($kid = null) {
		$this->db->select('a.username, a.user_id, a.role_id, b.id_kelas, c.*');
		$this->db->from('users a, kelas_user b');
		$this->db->join('profile c', 'c.uid=a.user_id', 'left');
		$this->db->where('a.role_id', '2');
		$this->db->group_by('user_id');
		if (!is_null($kid)) {
			$this->db->where('b.id_kelas', $kid);
		}
		$query = $this->db->get();
		return $query->result();
	}
	
	function getAllSiswaByKelas($kelas) {
		$this->db->select('*');
		$this->db->from($this->tku);
		$this->db->group_by('id_user');
		$this->db->where('id_kelas', '2');
		return $this->db->get()->result();
	}

	function getSingle($id) {
		return $this->db->get_where($this->tk, ['id_kelas' => $id])->row();
	}
	
	function getJoinDatr($id, $uid) {
		return $this->db->get_where($this->tku, ['id_kelas' => $id, 'id_user' => $uid])->row();
	}
	
	function cekUserInClass($uid, $clid) {
		$res = $this->db->get_where($this->tku, ['id_kelas' => $clid, 'id_user' => $uid])->result();
		return ($res) ? true : false;
	}

	function gabungKelas($uid, $kid, $gabung) {
		$result['status'] = false;
		$result['msg'] = 'Terjadi kesalahan sistem!';

		$data = [
			'id_user' => $uid,
			'id_kelas' => $kid,
			'bergabung' => time()
		];

		if (!$gabung) {
			$this->db->insert($this->tku, $data);
			if ($this->db->affected_rows()) $result['status'] = true;
		} else {
			$this->db->delete($this->tku, array('id_user' => $uid, 'id_kelas' => $kid));
			if ($this->db->affected_rows()) $result['status'] = true;
		}
		if ($result['status'] === true) $result['msg'] = 'oke';

		return $result;
	}

}