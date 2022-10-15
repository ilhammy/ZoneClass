<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Materi_model extends CI_Model
{
	public $tmk = "materi_kelas";
	public $tk = "kelas";

	public function getByCreator($cid) {
		$q = $this->db
		->from($this->tmk.' a')
		->join($this->tk.' b', 'a.id_kelas=b.id_kelas', 'left')
		->where('b.creator_id', $cid)
		->order_by('waktu', 'desc')
		->get();
		return $q->result();
	}
	
	public function getByClass($kls) {
		$q = $this->db
		->from($this->tmk)
		->where('id_kelas', $kls)
		->order_by('waktu', 'desc')
		->get();
		return $q->result();
	}
	
	public function getAll() {
		$q = $this->db
		->from($this->tmk)
		->order_by('waktu', 'desc')
		->get();
		return $q->result();
	}

}