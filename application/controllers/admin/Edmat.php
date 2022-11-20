<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edmat extends CI_Controller {

	private $imgUrl = null;

	function __construct() {
		parent::__construct();
		cekLogin();
		if (!isAdminGuru()) redirect();
		$this->load->model('Materi_model', 'Materi');
		$this->load->model('Kelas_model', 'Kelas');
		$this->load->model('Menu_model', 'Menu');
	}

	public function index($param) {
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->update_materi($param);
			return;
		}

		$msg = null;
		$idMateri = base64url_decode($param);
		$mtri = $this->Materi->getById($idMateri);
		$data['sb_menu'] = $this->Menu->getMenu();
		$data['idmat'] = $idMateri;
		$data['mtri'] = $mtri;

		if (is_null($mtri)) {
			$msg = 'Kelas yang anda maksud tidak ditemukan';
		}
		if ($this->Kelas->isMyClass($mtri->id_kelas)) {
			$msg = 'Anda tidak berhak mengelola materi ini';
		}
		$data['tipePost'] = $this->tipeMateri($mtri);

		$this->load->view('admin/top', $data);
		$this->load->view('admin/edit_materi', $data);
		$this->load->view('admin/down', $data);
	}

	public function update_materi($param) {
		$data['sb_menu'] = $this->Menu->getMenu();

		$res = array();
		$this->form_validation->set_rules('idMateri', 'Id Materi', 'trim|required', array(
			'required' => 'Id Materi Kosong!'
		));
		$this->form_validation->set_rules('title', 'Judul', 'trim|required', array(
			'required' => 'Judul kosong!'
		));
		$this->form_validation->set_rules('type', 'Tipe Postingan', 'trim|required');
		if ($this->form_validation->run() == false) {
			$isOk = false;
			$msg = validation_errors();
		}
		$mode = $this->input->post('type');
		$isi = $this->cekIsiMateri($mode);

		if (!is_null($isi)) {
			$this->session->set_flashdata('alert', $isi);
			redirect('dashboard/materi/edit/'. $param);
			return;
		}

		$inti = array(
			'judul' => $this->input->post('title'),
			'teks' => $this->input->post('text'),
			'foto' => $this->imgUrl,
			'link' => $this->input->post('link'),
			'youtube' => getYoutubeId($this->input->post('ytb')),
		);

		if ($this->Materi->updateData($this->input->post('idMateri'), $inti)) {
			$this->session->set_flashdata('alert', '<b>Berhasil!</b> materi telah diupdate.');
		} else {
			$this->session->set_flashdata('alert', '<b>Gagal!</b> Terjadi kesalahan, silahkan coba lagi');
		}
		redirect('dashboard/materi/edit/'. $param);
	}

	private function do_upload() {
		if (empty($_FILES['image']['name'])) return 'Pilih gambar untuk diposting!';
		$config['upload_path'] = "./assets/img/uploads"; //path folder file upload
		$config['allowed_types'] = 'gif|jpg|png|jpeg'; //type file yang boleh di upload
		$config['max_size'] = 6144; //enkripsi file name upload
		$config['encrypt_name'] = TRUE; //enkripsi file name upload

		$this->load->library('upload', $config); //call library upload
		if ($this->upload->do_upload("image")) {
			//upload file
			$data = array('upload_data' => $this->upload->data()); //ambil file name yang diupload
			$image = $data['upload_data']['file_name']; //set file name ke variable $image
			$this->imgUrl = base_url('assets/img/uploads/'). $image;
			return null;
		} else {
			return 'Gagal Upload File!';
		}
	}

	private function cekIsiMateri($mode) {
		switch ($mode) {
			case 1:
				return ($this->minChar($this->input->post('text'), 5)) ? null : 'Teks minimal 5 karakter';
			case 2:
				if ($this->isJson($this->input->post('link'))) {
					$jsn = json_decode($this->input->post('link'), true);
					return (sizeof($jsn) !== 0) ? null : 'Minimal 1 link';
				}
				return 'Konten yang anda masukan tidak sesuai';
			case 3:
				return (getYoutubeId($this->input->post('ytb')) == null) ? 'Url video tidak valid' : null;
			case 4:
				return $this->do_upload();
			default:
				return 'Tipe postingan salah!';
		}
	}

	private function tipeMateri($data) {
		if (!is_null($data->teks)) return 1;
		if (!is_null($data->link)) return 2;
		if (!is_null($data->youtube)) return 3;
		if (!is_null($data->foto)) return 4;
		return 1;
	}

	private function minChar($a, $b) {
		return (strlen($a) > $b);
	}

	private function isJson($string) {
		json_decode($string);
		return json_last_error() === JSON_ERROR_NONE;
	}

}