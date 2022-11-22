<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catatan extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Note_model', 'NM');
		$this->load->model('Menu_model', 'Menu');

		cekLogin();
		if (!isAdminGuru()) redirect('dashboard');
	}

	//if (!$this->input->is_ajax_request()) {

	public function baru() {
		$data['sb_menu'] = $this->Menu->getMenu();
		
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			echo $this->createNote(true);
			return;
		}
		
		$this->load->view('admin/top', $data);
		$this->load->view('admin/note-editor', $data);
		$this->load->view('admin/down', $data);
	}
	
	public function edit_note($id = null) {
		$data['sb_menu'] = $this->Menu->getMenu();
		$data['note_id'] = intval(base64url_decode($id));
		
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			echo $this->createNote(false);
			return;
		}
		$data['catatan'] = $this->NM->getSingle($data['note_id']);
		$data['editMode'] = true;
		if (is_null($data['catatan'])) {
			show_404('', false);
			return;
		}
		
		$this->load->view('admin/top', $data);
		$this->load->view('admin/note-editor', $data);
		$this->load->view('admin/down', $data);
	}
	
	private function createNote($create = true) {
		$this->form_validation->set_rules($this->NM->create_rules);

		if ($this->form_validation->run() == false) {
			return simpleResponse(false, validation_errors());
		}
		if (is_null(myUid())) {
			return simpleResponse(false, 'Invalid access');
		}
		$judul = htmlspecialchars($this->input->post('title', true));
		$isi = $this->input->post('text', true);
		$id = $this->input->post('note_id', TRUE);
		
		if (!$create) {
			$hasil = $this->NM->update($id, [
				'title' => $judul,
				'text' => $isi,
				'time' => time()
			]);
		} else {
			$hasil = $this->NM->add([
				'title' => $judul,
				'text' => $isi,
				'user' => myUid(),
				'time' => time()
			]);
		}
		
		if ($hasil) {
			return simpleResponse(true, 'Catatan tersimpan');
		} else {
			return simpleResponse(false, 'Gagal menyimpan catatan');
		}
	}
	
	public function delNote() {
		$id = $this->input->post('note_id', TRUE);
		
		if ($this->input->server('REQUEST_METHOD') !== 'POST') {
			exit(simpleResponse(false, 'invalid access'));
		}
		if (is_null($id)) {
			exit(simpleResponse(false, 'invalid target'));
		}
		
		$hasil = $this->NM->delete($id);
		if ($hasil) {
			exit(simpleResponse(true, 'Catatan dihapus'));
		} else {
			exit(simpleResponse(false, 'Gagal menghapus catatan'));
		}
	}

}