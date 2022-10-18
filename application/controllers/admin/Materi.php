<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Materi extends CI_Controller {

	function __construct() {
		parent::__construct();
		cekLogin();
		if (!isAdminGuru()) redirect();
		$this->load->model('Materi_model', 'Materi');
		$this->load->model('Kelas_model', 'Kelas');
		$this->load->model('Menu_model', 'Menu');
	}

	public function index() {
		$data['sb_menu'] = $this->Menu->getMenu();
		$data['data_kelas'] = $this->Kelas->getMyClass();
		$data['kelas_terpilih'] = $this->input->get('kelas');

		$this->load->view('admin/top', $data);
		$this->load->view('admin/materi', $data);
		$this->load->view('admin/down', $data);
	}
	
	public function tambah_materi() {
		$data['sb_menu'] = $this->Menu->getMenu();
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->form_validation->set_rules('idkel', 'Id Kelas', 'trim|required');
			$this->form_validation->set_rules('title', 'Judul', 'trim|required');
			if ($this->form_validation->run() !== false) {
				$inti = array(
					'id_kelas' => $this->input->post('idKel'),
					'judul' => $this->input->post('title'),
					'teks' => $this->input->post('text'),
					'foto' => $this->input->post('image'),
					'link' => $this->input->post('link'),
					'youtube' => $this->input->post('youtube'),
					'waktu' => time()
				);
				if (true) {
					$this->session->set_flashdata('newclass', '<b>Berhasil!</b> sekarang kelas sedang dalama peninjauan.');
				} else {
					$this->session->set_flashdata('newclass', '<b>Gagal!</b> Terjadi kesalahan, silahkan coba lagi');
				}
				redirect('dashboard/kelas/tambah');
				return;
			}
		}
	}

}