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
				if (!is_null($ud)) {
					array_push($siswa, $ud);
					$this->User_model->updateKelas($ud->uid);
				}
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
	
	public function detail_kelas($idkes) {
		$data['sb_menu'] = $this->Menu->getMenu();
		$data['data_kelas'] = $this->Kelas_model->getSingle($idkes);
		$data['data_siswa'] = $this->Kelas_model->getAllSiswaByKelas($idkes);
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->form_validation->set_rules($this->Kelas_model->create_rules);
			if ($this->form_validation->run() !== false) {
				$inti = array(
					'nama_kelas' => $this->input->post('nama_kelas'),
					'tentang' => $this->input->post('des')
				);
				if ($this->Kelas_model->updateClassInfo($idkes, $inti)) {
					$this->session->set_flashdata('alert', '<b>Berhasil!</b> Perubahan tersimpan.');
				} else {
					$this->session->set_flashdata('alert', '<b>Gagal!</b> Terjadi kesalahan, silahkan coba lagi');
				}
				redirect('dashboard/kelas/' . $idkes);
				return;
			}
		}

		$this->load->view('admin/top', $data);
		$this->load->view('admin/detail_kelas', $data);
		$this->load->view('admin/down', $data);
	}

	public function tambah_kelas() {
		$data['sb_menu'] = $this->Menu->getMenu();
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->form_validation->set_rules($this->Kelas_model->create_rules);
			if ($this->form_validation->run() !== false) {
				$inti = array(
					'creator_id' => myUid(),
					'nama_kelas' => $this->input->post('nama_kelas'),
					'tentang' => $this->input->post('des'),
					'dibuat' => time()
				);
				if ($this->Kelas_model->addClass($inti)) {
					$this->session->set_flashdata('newclass', '<b>Berhasil!</b> sekarang kelas sedang dalama peninjauan.');
				} else {
					$this->session->set_flashdata('newclass', '<b>Gagal!</b> Terjadi kesalahan, silahkan coba lagi');
				}
				redirect('dashboard/kelas/tambah');
				return;
			}
		}

		$this->load->view('admin/top', $data);
		$this->load->view('admin/add_kelas', $data);
		$this->load->view('admin/down', $data);
	}

	public function siswa() {
		$data['sb_menu'] = $this->Menu->getMenu();

		$siswa = array();
		foreach ($this->Kelas_model->getMyClass() as $i) {
			foreach ($this->Kelas_model->getAllSiswaByKelas($i->id_kelas) as $usr) {
				$ud = $this->User_model->getByUid($usr->id_user);
				if (!is_null($ud)) {
					array_push($siswa, $ud);
					$this->User_model->updateKelas($ud->uid);
				}
			}
		}
		$data['data_siswa'] = my_array_unique($siswa);

		$this->load->view('admin/top', $data);
		$this->load->view('admin/siswa', $data);
		$this->load->view('admin/down', $data);
	}

}