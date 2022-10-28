<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kun_model extends CI_Model {

	private $tk = 'kode_undangan';

	public $create_rules = [
		[
			'field' => 'label',
			'label' => 'Label',
			'rules' => 'required|trim|max_length[50]',
			'errors' => [
				'required' => '%s kosong',
				'max_length' => '%s maksimal %s karakter'
			]
		],
		[
			'field' => 'kode',
			'label' => 'Kode',
			'rules' => 'required|trim|min_length[5]|max_length[20]',
			'errors' => [
				'required' => '%s tidak boleh kososng',
				'min_length' => '%s minimal %s karakter',
				'max_length' => '%s maksimal %s karakter',
			]
		],
		[
			'field' => 'kuota',
			'label' => 'Kuota',
			'rules' => 'required|trim',
			'errors' => [
				'required' => '%s tidak boleh kososng'
			]
		],
		[
			'field' => 'exp',
			'label' => 'Waktu Kadaluwarsa',
			'rules' => 'required|trim',
			'errors' => [
				'required' => '%s tidak boleh kososng',
			]
		]
	];

	function addCode($data) {
		$this->db->insert($this->tk, $data);
		return ($this->db->affected_rows() == 1);
	}

	function updateCode($id, $data) {
		$this->db->update($this->tk, $data, ['id' => $id]);
		return ($this->db->affected_rows() == 1);
	}

	function updateUsed($id) {
		$this->db->where('id', $id);
		$this->db->set('dipakai', 'dipakai+1', FALSE);
		$this->db->update($this->tk);
		return ($this->db->affected_rows() == 1);
	}
	
	function resetUsed($code) {
		$this->db->update($this->tk, ['dipakai' => 0], ['uid' => myUid()]);
		return ($this->db->affected_rows() == 1);
	}

	function deleteCode($id) {
		$this->db->delete($this->tk, ['id' => $id]);
		return ($this->db->affected_rows() == 1);
	}

	function getAllData($uid = null) {
		if (is_null($uid)) return $this->db->order_by('id', 'desc')->get($this->tk)->result();

		return $this->db
		->order_by('id', 'desc')
		->where('uid', $uid)
		->get($this->tk)
		->result();
		//return $this->db->get($this->tk)->result();
	}

	function getSingle($id) {
		return $this->db->get_where($this->tk, ['id' => $id])->row();
	}

	function cekKode($kode, $idc = null) {
		$r = null;
		if (is_null($idc)) {
			$r = $this->db->get_where($this->tk, ['kode' => $kode])->row();
		} else {
			$r = $this->db->get_where($this->tk, ['id_kelas' => $idc, 'kode' => $kode])->row();
		}

		if (!is_null($r)) {
			if (time() > $r->exp && $r->exp !== 0) return 1; // Kadaluwarsa
			return 2; //Siap
		} else {
			return 0; // Tidak ditemukan
		}
	}

	function getKuota($kode, $idc = null) {
		$r = null;
		if (is_null($idc)) {
			$r = $this->db->get_where($this->tk, ['kode' => $kode])->row();
		} else {
			$r = $this->db->get_where($this->tk, ['id_kelas' => $idc, 'kode' => $kode])->row();
		}

		if (is_null($r)) return null;
		return [
			'id' => intval($r->id),
			'max' => intval($r->kuota),
			'used' => intval($r->dipakai)
		];
	}

	function isUnique($kode) {
		$r = $this->db->get_where($this->tk, ['kode' => $kode])->row();
		return ($r) ? true : false;
	}

}