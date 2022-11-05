<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Notif_model extends CI_Model {

	private $tn = 'notifikasi';

	function push($data, $mail = false) {
		$d = [
			'target' => $data['to'],
			'user' => $data['uid'],
			'title' => $data['title'],
			'content' => $data['text'],
			'icon' => $data['icon'],
			'type' => $data['type'],
			'time' => time()
		];
		$this->db->insert($this->tn, $d);
		return ($this->db->affected_rows() > 0);
	}

	function update($id, $data) {
		$this->db->update($this->tn, $data, ['id' => $id]);
		return ($this->db->affected_rows() == 1);
	}

	function getForAll() {
		return $this->db->order_by('time', 'desc')
		->where('target', 'all')
		->get($this->tn)
		->result();
	}

	function getForAdmin() {
		return $this->db->order_by('time', 'desc')
		->where('target', 'admin')
		->or_where('target', 'all')
		->get($this->tn)
		->result();
	}

	function getForGuru() {
		return $this->db->order_by('time', 'desc')
		->where('target', 'guru')
		->or_where('target', 'all')
		->get($this->tn)
		->result();
	}

	function getForSiswa() {
		return $this->db->order_by('time', 'desc')
		->where('target', 'siswa')
		->or_where('target', 'all')
		->get($this->tn)
		->result();
	}

	function getSingle($id) {
		return $this->db->get_where($this->tn, ['id' => $id])->row();
	}

	function readNotif($id) {
		return $this->update($id, ['isRead' => true]);
	}

	function getUnread($type = 'all') {
		if ($type == 'all') {
			$data = $this->getForAll();
		} else if ($type == 'admin') {
			$data = $this->getForAdmin();
		} else if ($type == 'guru') {
			$data = $this->getForGuru();
		} else if ($type == 'siswa') {
			$data = $this->getForSiswa();
		}

		if (sizeof($data) == 0) return [];
		$out = [];
		foreach ($data as $val) {
			if (!($val->user !== myUid() || $val->user !== -1)) continue;
			array_push($out, $val);
		}
		return $out;
	}

}