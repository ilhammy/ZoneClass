<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Kelas_model');
	}
	public function index() {
		$data = array();
		$this->load->view('admin/top', $data);
		$this->load->view('admin/dash', $data);
		$this->load->view('admin/down', $data);
	}
	
	public function siswa() {
		$data['data_siswa'] = $this->Kelas_model->getAllSiswa();
		
		$this->load->view('admin/top', $data);
		$this->load->view('admin/siswa', $data);
		$this->load->view('admin/down', $data);
	}

}