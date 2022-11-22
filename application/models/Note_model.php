<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Note_model extends CI_Model {

	private $tn = 'notes';
	
	public $create_rules = [
		[
			'field' => 'title',
			'label' => 'Judul Catatan',
			'rules' => 'required|min_length[2]|max_length[100]',
			'errors' => [
				'required' => '%s tidak boleh kosong',
				'min_length' => '%s minimal %s karakter',
				'max_length' => '%s maksimal %s karakter'
			]
		],
		[
			'field' => 'text',
			'label' => 'Isi Catatan',
			'rules' => 'required|max_length[1000]',
			'errors' => [
				'required' => '%s tidak boleh kosong',
				'max_length' => '%s maksimal %s karakter'
			]
		]
	];

	function add($data) {
		$this->db->insert($this->tn, $data);
		return ($this->db->affected_rows() == 1);
	}
	
	function update($id, $data) {
		$this->db->update($this->tn, $data, ['id' => $id]);
		return ($this->db->affected_rows() == 1);
	}
	
	function delete($id) {
		$this->db->delete($this->tn, ['id' => $id, 'user' => myUid()]);
		return ($this->db->affected_rows() == 1);
	}

	function getAll() {
		return $this->db->order_by('time', 'desc')
		->where('user', myUid())
		->get($this->tn)
		->result();
	}

	function getSingle($id) {
		return $this->db->get_where($this->tn, ['id' => $id, 'user' => myUid()])->row();
	}

}