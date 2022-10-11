<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Materi extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('Kelas_model');
		$this->load->model('Materi_model');
		
		cekLogin();
		if (!isAdminSiswa()) redirect('dashboard');
	}

	public function index($idkel) {
		$data['title'] = 'Materi';
		$data['kelid'] = intval(base64_decode(urldecode($idkel), false));
		$data['data_kelas'] = $this->Kelas_model->getSingle($data['kelid']);
		$data['data_materi'] = $this->Materi_model->getByClass($data['kelid']);
		$data['nonav'] = true;
		
		$this->load->view('user/top', $data);
		$this->load->view('user/materi', $data);
		$this->load->view('user/down', $data);
	}
	
}