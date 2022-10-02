<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kelas_model extends CI_Model {

	private $tk = 'kelas';
	private $tku = 'kelas_user';

	function getAllData() {
		return $this->db->get($this->tk)->result();
	}

	function getAllByUser($uid) {
		$this->db->select('*');
		$this->db->from('kelas a');
		$this->db->join('kelas_user b', 'b.id_kelas=a.id_kelas', 'left');
		$this->db->where('b.id_user', $uid);
		$query = $this->db->get();
		return $query->result();
	}

	function getSingle($id) {
		return $this->db->get_where($this->tk, ['id_kelas' => $id])->row();
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