<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	function __construct() {
		parent::__construct();
		cekLogin();
		if (!isAdminGuru()) redirect();
		$this->load->model('Materi_model', 'Materi');
		$this->load->model('Kelas_model', 'Kelas');
		$this->load->model('Menu_model', 'Menu');
	}

	public function index($uid = null) {
		$data['sb_menu'] = $this->Menu->getMenu();
		$data['uid'] = ($uid == null) ? myUid() : base64url_decode($uid);
		$data['data_user'] = $this->User_model->getByUid($data['uid']);

		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			exit($this->updateRekening());
		}

		$this->load->view('admin/top', $data);
		$this->load->view('admin/profile', $data);
		$this->load->view('admin/down', $data);
	}

	private function updateRekening() {
		$this->form_validation->set_rules('rekening', 'Rekening', 'required|max_length[1000]');
		if ($this->form_validation->run() !== false) {
			if ($this->User_model->updateProfile([
				'rekening' => $this->input->post('rekening', true)
			])) {
				return simpleResponse(true, 'Rekening tersimpan!');
			} else {
				return simpleResponse(false, 'Gagal menyimpan!');
			}
		} else {
			return simpleResponse(false, 'Rekening tidak boleh kosong!');
		}
	}

}