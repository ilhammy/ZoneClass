<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kelas_model extends CI_Model {

	private $tk = 'kelas';
	private $tku = 'kelas_user';
	
	public $create_rules = array(
		array(
			'field' => 'nama_kelas',
			'label' => 'Nama Kelas',
			'rules' => 'required|trim|min_length[5]|max_length[30]',
			'errors' => array(
				'required' => '%s kosong',
				'min_length' => '%s minimal %s karakter', 
				'max_length' => '%s maksimal %s karakter'
			)
		),
		array(
			'field' => 'des',
			'label' => 'Keterangan Singkat',
			'rules' => 'required|trim|min_length[5]|max_length[100]',
			'errors' => array(
				'required' => '%s kososng',
				'min_length' => '%s minimal %s karakter', 
				'max_length' => '%s maksimal %s karakter'
			),
		)
	);
	
	function addClass($data) {
		$this->db->insert($this->tk,$data);
    return ($this->db->affected_rows() != 1);
	}
	
	function updateClassInfo($kid, $data) {
		$this->db->update($this->tk, $data, ['id_kelas' => $kid]);
    return ($this->db->affected_rows() == 1);
	}

	function getAllData() {
		$q = $this->db->from($this->tk)
		->order_by('dibuat', 'desc')
		->where('status', 1)->get();
		return $q->result();
		//return $this->db->get($this->tk)->result();
	}

	function getAllByUser($uid) {
		$this->db->select('*');
		$this->db->from('kelas a');
		$this->db->join('kelas_user b', 'b.id_kelas=a.id_kelas', 'left');
		$this->db->where(['b.id_user' => $uid, 'status' => 1]);
		$this->db->order_by('b.bergabung', 'desc');
		$query = $this->db->get();
		return $query->result();
	}
	
	function getMyClass() {
		return $this->db->get_where($this->tk, [$this->tk . '.creator_id' => myUid(), 'status' => 1])->result();
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
		$this->db->order_by('bergabung');
		return $this->db->get()->result();
	}

	function getSingle($id) {
		return $this->db->get_where($this->tk, ['id_kelas' => $id])->row();
	}
	
	function isActiveClass($id) {
		return $this->db->get_where($this->tk, ['id_kelas' => $id, 'status' => 0])->row();
	}
	
	function getJoinDatr($id, $uid) {
		return $this->db->get_where($this->tku, ['id_kelas' => $id, 'id_user' => $uid])->row();
	}
	
	function cekUserInClass($uid, $clid) {
		$res = $this->db->get_where($this->tku, ['id_user' => $uid, 'id_kelas' => $clid])->row();
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