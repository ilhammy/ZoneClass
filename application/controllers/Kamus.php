<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kamus extends CI_Controller {

	function __construct() {
		parent::__construct();
		//$this->load->model('Kamus_model');

		cekLogin();
		if (!isSiswa()) redirect('dashboard');
	}

	public function list($id) {
		$data['title'] = 'Materi';
		$data['kamid'] = intval(base64url_decode($id, false));
		$data['nonav'] = true;

		$this->load->view('user/top', $data);
		$this->load->view('user/kamus-list', $data);
		$this->load->view('user/down', $data);
	}

}