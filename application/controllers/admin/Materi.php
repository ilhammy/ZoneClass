<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Materi extends CI_Controller {

	private $imgUrl = null;

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
		$data['data_kelas'] = $this->Kelas->getMyClass();
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$res = array();
			$this->form_validation->set_rules('idkel', 'Id Kelas', 'trim|required', array(
				'required' => 'Silahkan pilih kelas'
			));
			$this->form_validation->set_rules('title', 'Judul', 'trim|required', array(
				'required' => 'Judul kosong!'
			));
			$this->form_validation->set_rules('type', 'Tipe Postingan', 'trim|required');
			if ($this->form_validation->run() !== false) {
				$mode = $this->input->post('type');
				$isi = $this->cekIsiMateri($mode);

				if (!is_null($isi)) {
					echo simpleResponse(false, $isi);
					return;
				}

				$inti = array(
					'id_kelas' => $this->input->post('idkel'),
					'judul' => $this->input->post('title'),
					'teks' => $this->input->post('text'),
					'foto' => $this->imgUrl,
					'link' => $this->input->post('link'),
					'youtube' => getYoutubeId($this->input->post('ytb')),
					'waktu' => time()
				);

				if ($this->Materi->addMateri($inti) == true) {
					$res = array(
						'status' => true,
						'msg' => '<b>Berhasil!</b> materi telah dipublikasikan.'
					);
				} else {
					$res = array(
						'status' => false,
						'msg' => '<b>Gagal!</b> Terjadi kesalahan, silahkan coba lagi'
					);
				}
			} else {
				$res = array(
					'status' => false,
					'msg' => validation_errors()
				);
			}
			echo json_encode($res);
			return;
		}

		$this->load->view('admin/top', $data);
		if (sizeof($data['data_kelas']) == 0) {
			$data['msg'] = 'Anda belum memiliki kelas';
			$this->load->view('admin/msg', $data);
		} else {
			$this->load->view('admin/add_materi', $data);
		}
		$this->load->view('admin/down', $data);
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

	public function hapus() {
		if ($this->input->server('REQUEST_METHOD') !== 'POST') {
			echo simpleResponse(false, 'Invalid access');
			return;
		}
		$this->form_validation->set_rules('id', 'Materi', 'trim|integer', array(
			'integer' => 'Invalid data'
		));
		$idMateri = $this->input->post('id');
		if ($this->form_validation->run() === false) {
			echo simpleResponse(false, validation_errors());
			return;
		}
		if (is_null($this->Materi->getById($idMateri))) {
			echo simpleResponse(false, 'Materi tidak ditemukan');
			return;
		}
		if ($this->Materi->deleteById($idMateri)) {
			echo simpleResponse(true, 'Berhasil! materi telah dihapus');
			return;
		} else {
			echo simpleResponse(false, 'Terjadi kesalahan sistem');
			return;
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

	private function minChar($a, $b) {
		return (strlen($a) > $b);
	}

	private function isJson($string) {
		json_decode($string);
		return json_last_error() === JSON_ERROR_NONE;
	}

}