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
	);

	function addClass($data) {
		$this->db->insert($this->tk, $data);
		return ($this->db->affected_rows() == 1);
	}

	function updateClassInfo($kid, $data) {
		$this->db->update($this->tk, $data, ['id_kelas' => $kid]);
		return ($this->db->affected_rows() == 1);
	}

	function deleteById($kid) {
		$this->db->delete($this->tk, ['id_kelas' => $kid]);
		return ($this->db->affected_rows() == 1);
	}

	function getAllData() {
		$q = $this->db
		->select('a.*, b.uid, b.fullname AS pengurus, b.whatsapp AS kontak')
		->from($this->tk . ' a')
		->join('profile b', 'b.uid=a.creator_id')
		->order_by('a.dibuat', 'desc')
		->where('a.status', 1)->get();
		return $q->result();
		//return $this->db->get($this->tk)->result();
	}
	
	function getEmptyLink($isEmpty = true) {
		$op = $isEmpty ? '' : ' !=';
		$q = $this->db
		->select('a.*, b.uid, b.fullname AS pengurus, b.whatsapp AS kontak')
		->from($this->tk . ' a')
		->join('profile b', 'b.uid=a.creator_id')
		->order_by('a.dibuat', 'desc')
		->where('a.tentang' . $op, null)
		->where('a.status', 1)->get();
		return $q->result();
		//return $this->db->get($this->tk)->result();
	}

	function getAllByUser($uid) {
		$this->db->select('a.*, b.*, c.uid, c.fullname AS pengurus');
		$this->db->from('kelas a');
		$this->db->join('kelas_user b', 'b.id_kelas=a.id_kelas', 'left');
		$this->db->join('profile c', 'c.uid=a.creator_id');
		$this->db->where(['b.id_user' => $uid, 'status' => 1]);
		$this->db->order_by('b.bergabung', 'desc');
		$query = $this->db->get();
		return $query->result();
	}

	function getMyClass($uid = null) {
		$uid = (is_null($uid)) ? myUid() : $uid;
		return $this->db->get_where($this->tk, ['creator_id' => myUid(), 'status' => 1])->result();
	}

	function getPendingClass($uid = null) {
		if (is_null($uid)) {
			return $this->db
			->order_by('dibuat', 'DESC')
			->get_where($this->tk, ['status !=' => 1])
			->result();
		} else {
			return $this->db
			->order_by('dibuat', 'DESC')
			->get_where($this->tk, ['creator_id' => $uid, 'status !=' => 1])
			->result();
		}
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
		$this->db->where('id_kelas', $kelas);
		$this->db->order_by('bergabung');
		return $this->db->get()->result();
	}

	function getSingle($id) {
		return $this->db
		->select('a.*, b.uid, b.fullname AS pengurus, b.whatsapp AS kontak')
		->from($this->tk . ' a')
		->join('profile b', 'b.uid=a.creator_id')
		->where('id_kelas', $id)
		->get()->row();
	}

	function isActiveClass($id) {
		return $this->db->get_where($this->tk, ['id_kelas' => $id, 'status' => 1])->row();
	}

	function isMyClass($id) {
		return $this->db->get_where($this->tk, ['id_kelas' => $id, 'creator_id' => myUid()])->row();
	}

	function getJoinDatr($id, $uid) {
		return $this->db->get_where($this->tku, ['id_kelas' => $id, 'id_user' => $uid])->row();
	}

	function cekUserInClass($uid, $clid) {
		$res = $this->db->get_where($this->tku, ['id_user' => $uid, 'id_kelas' => $clid])->row();
		return ($res) ? true : false;
	}

	function kickSiswaFromMyAllClass($sid) {
		foreach ($this->getMyClass() as $val) {
			$this->db->delete($this->tku, ['id_user' => $sid, 'id_kelas' => $val->id_kelas]);
		}
		$this->User_model->updateKelas($sid);
	}

	function gabungKelas($uid, $kid, $gabung) {
		$result['status'] = false;
		$result['msg'] = 'Terjadi kesalahan sistem!';

		$data = [
			'id_user' => $uid,
			'id_kelas' => $kid,
			'bergabung' => time()
		];

		if ($gabung === true) {
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