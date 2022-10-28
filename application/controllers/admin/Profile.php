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
		
		$this->load->view('admin/top', $data);
		$this->load->view('admin/profile', $data);
		$this->load->view('admin/down', $data);
	}
	
	/*public function tambah_materi() {
		$data['sb_menu'] = $this->Menu->getMenu();
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->form_validation->set_rules($this->Kelas_model->create_rules);
			if ($this->form_validation->run() !== false) {
				$inti = array(
					'id_kelas' => myUid(),
					'judul' => myUid(),
					'teks' => $this->input->post('nama_kelas'),
					'foto' => $this->input->post('nama_kelas'),
					'link' => $this->input->post('des'),
					'youtube' => $this->input->post('des'),
					'waktu' => time()
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
		$this->load->view('admin/add_materi', $data);
		$this->load->view('admin/down', $data);
	}*/

}