<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Materi_model extends CI_Model
{
	public $tmk = "materi_kelas";
	public $tk = "kelas";

	public function addMateri($data) {
		$this->db->insert($this->tmk, $data);
		return ($this->db->affected_rows() == 1);
	}

	public function getByCreator($cid) {
		$q = $this->db
		->from($this->tmk.' a')
		->join($this->tk.' b', 'a.id_kelas=b.id_kelas', 'left')
		->where('b.creator_id', $cid)
		->order_by('waktu', 'desc')
		->get();
		return $q->result();
	}

	public function getByClass($kls, $order = 'desc') {
		$q = $this->db
		->from($this->tmk)
		->where('id_kelas', $kls)
		->order_by('waktu', $order)
		->get();
		return $q->result();
	}

	public function getById($id) {
		return $this->db->get_where($this->tmk, ['id' => $id])->row();
	}

	function updateData($id, $data) {
		$this->db->update($this->tmk, $data, ['id' => $id]);
		return ($this->db->affected_rows() == 1);
	}

	function deleteById($id) {
		$this->db->delete($this->tmk, ['id' => $id]);
		return ($this->db->affected_rows() == 1);
	}

	public function getAll() {
		$q = $this->db
		->from($this->tmk)
		->order_by('waktu', 'desc')
		->get();
		return $q->result();
	}

	function hitMateri($id) {
		$this->db->where('id', $id);
		$this->db->set('views', 'views+1', FALSE);
		$this->db->update($this->tmk);
	}

}