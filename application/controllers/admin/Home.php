<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct() {
		parent::__construct();
		cekLogin();
		if (!isAdminGuru()) redirect();
		$this->load->model('Kelas_model');
		$this->load->model('Menu_model', 'Menu');
	}
	public function index() {
		$siswa = array();
		foreach ($this->Kelas_model->getMyClass() as $i) {
			foreach ($this->Kelas_model->getAllSiswaByKelas($i->id_kelas) as $usr) {
				$ud = $this->User_model->getByUid($usr->id_user);
				if (!is_null($ud)) array_push($siswa, $ud);
			}
		}
		$data = array(
			'sb_menu' => $this->Menu->getMenu(), 
			'siswaku' => my_array_unique($siswa)
		);
		$this->load->view('admin/top', $data);
		$this->load->view('admin/dash', $data);
		$this->load->view('admin/down', $data);
	}

	public function kelas() {
		$data['sb_menu'] = $this->Menu->getMenu();
		$data['data_kelas'] = $this->Kelas_model->getMyClass();

		$this->load->view('admin/top', $data);
		$this->load->view('admin/kelas', $data);
		$this->load->view('admin/down', $data);
	}

	public function siswa() {
		$data['sb_menu'] = $this->Menu->getMenu();

		$siswa = array();
		foreach ($this->Kelas_model->getMyClass() as $i) {
			foreach ($this->Kelas_model->getAllSiswaByKelas($i->id_kelas) as $usr) {
				$ud = $this->User_model->getByUid($usr->id_user);
				if (!is_null($ud)) array_push($siswa, $ud);
			}
		}
		$data['data_siswa'] = my_array_unique($siswa);

		$this->load->view('admin/top', $data);
		$this->load->view('admin/siswa', $data);
		$this->load->view('admin/down', $data);
	}

}