<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Materi_model extends CI_Model
{
	public $tmk = "materi_kelas";

	public function getByClass($kls) {
		$q = $this->db
		->from($this->tmk)
		->where('id_kelas', $kls)
		->order_by('waktu', 'desc')
		->get();
		return $q->result();
	}

}