<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct() {
		parent::__construct();
		cekLogin(); 
		if (!isAdminSiswa()) redirect('dashboard');
	}

	public function index() {
		$data['title'] = 'Beranda';
		if (!is_null($this->input->post('upload_prof'))) {
			$this->session->set_flashdata('alert', $this->uploadProfile());
			redirect();
			return;
		}
		
		$this->load->view('user/top');
		$this->load->view('user/main', $data);
		$this->load->view('user/down');
	}

	private function uploadProfile() {
		$oldFoto = profileValue('foto');
		if (strpos($oldFoto, 'default') !== false) $oldFoto = null;
		
		$config['upload_path'] = 'assets/img/avatar'; // folder upload
		$config['allowed_types'] = 'jpg|jpeg|JPG|JPEG'; // jenis file
		$config['max_size'] = 300000;
		$config['encrypt_name'] = true;
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('fileFoto')) {
			return "showMsg('error', 'Gagal mengupload foto anda');";
			// echo var_dump($this->upload->display_errors());
		} else {
			$file = $this->upload->data();
			$namaFile = $file['file_name'];
			$res = $this->User_model->updateFoto('/assets/img/avatar/'.$namaFile);
			if ($res) {
				if (!is_null($oldFoto)) @unlink('.' .$oldFoto);
				return "showMsg('success', 'Berhasil ubah foto anda!');";
			}
			return "showMsg('error', 'Gagal mengganti foto!');";
		}
	}

}