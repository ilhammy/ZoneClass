<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Materi_model extends CI_Model
{
	public $tmk = "materi_kelas";

	public function getByClass($kls) {
		return $this->db->get_where($this->tmk, ['id_kelas' => $kls])->result();
	}

}