<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelasm extends CI_Controller {

	function __construct() {
		parent::__construct();
		cekLogin();
		if (!isAdmin()) redirect();
		$this->load->model('Kelas_model');
		//$this->load->model('Materi_model');
		$this->load->model('Menu_model', 'Menu');
	}

	public function index() {
		$data['sb_menu'] = $this->Menu->getMenu();
		$data['data_kelas'] = $this->Kelas_model->getAllData();
		$data['data_kelas_pending'] = $this->Kelas_model->getPendingClass();

		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->terimaKelas($this->input->post('kelid'), $this->input->post('status'));
			return;
		}

		$this->load->view('admin/top', $data);
		$this->load->view('admin/kelas_manage', $data);
		$this->load->view('admin/down', $data);
	}

	public function link_kelas() {
		$data['sb_menu'] = $this->Menu->getMenu();
		$data['semuakelas'] = $this->Kelas_model->getEmptyLink(false);

		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			return;
		}

		$this->load->view('admin/top', $data);
		$this->load->view('admin/manage_link', $data);
		$this->load->view('admin/down', $data);
	}

	public function tambah_linkkelas() {
		$data['sb_menu'] = $this->Menu->getMenu();
		$data['semuakelas'] = $this->Kelas_model->getEmptyLink();

		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->session->set_flashdata('alert', $this->addLink());
			redirect('dashboard/manage_link/tambah');
			return;
		}

		$this->load->view('admin/top', $data);
		$this->load->view('admin/add_link', $data);
		$this->load->view('admin/down', $data);
	}

	private function addLink() {
		$this->form_validation->set_rules('kelas', 'Id Kelas', 'trim|required|integer');
		$this->form_validation->set_rules('link', 'Link', 'trim|required|valid_url');
		$id = $this->input->post('kelas');
		$url = $this->input->post('link');
		if ($this->form_validation->run() == FALSE){
			return validation_errors();
		}
		if ($this->Kelas_model->updateClassInfo($id, [
			'tentang' => trim($url)
		])) {
			return '<b>Berhasil</b> link telah dibuat';
		} else {
			return 'Terjadi kesalahan sistem';
		}
	}

	public function editLink() {
		if ($this->input->server('REQUEST_METHOD') !== 'POST') {
			echo simpleResponse(false, 'Invalid access');
			return;
		}
		
		$this->form_validation->set_rules('kelas', 'Id Kelas', 'trim|required|integer');
		$this->form_validation->set_rules('link', 'Link', 'trim|required|valid_url');
		$id = $this->input->post('kelas');
		$url = $this->input->post('link');
		if ($this->form_validation->run() == FALSE){
			echo simpleResponse(false, validation_errors());
			return;
		}
		if ($this->Kelas_model->updateClassInfo($id, [
			'tentang' => $url
		])) {
			echo simpleResponse(true, 'Berhasil, link telah diperbarui');
			return;
		} else {
			echo simpleResponse(false, 'Gagal memperbarui link');
			return;
		}
	}
	
	public function hapus_link() {
		if ($this->input->server('REQUEST_METHOD') !== 'POST') {
			echo simpleResponse(false, 'Invalid access');
			return;
		}
		$id = $this->input->post('kid');
		if (is_null($id)) {
			echo simpleResponse(false, 'Invalid params');
			return;
		}
		if ($this->Kelas_model->updateClassInfo($id, [
			'tentang' => null
		])) {
			echo simpleResponse(true, 'Berhasil');
			return;
		} else {
			echo simpleResponse(false, 'Terjadi kesalahan sistem');
			return;
		}
	}

	private function terimaKelas($id, $stat) {
		if (is_null($id) || is_null($stat)) {
			$this->session->set_flashdata('alert', 'Invalid opration');
			redirect('dashboard/kelola_kelas');
			return;
		}
		if ($this->Kelas_model->updateClassInfo($id, [
			'status' => $stat
		])) {
			$this->session->set_flashdata('alert', 'Berhasil! status kelas telah diubah');
		} else {
			$this->session->set_flashdata('alert', 'Terjadi kesalahan silahkan coba lagi');
		}
		redirect('dashboard/kelola_kelas');
	}

	public function hapus_kelas() {
		$sts = false;
		$msg = 'Form tidak lengkap!';
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->form_validation->set_rules('kid', 'Id Kelas', 'trim|required');
			if ($this->form_validation->run() !== false) {
				$kid = $this->input->post('kid', true);
				if ($this->Kelas_model->getSingle($kid) == null) {
					$msg = 'Kelas tidak ditemukan';
					echo json_encode(['status' => $sts, 'msg' => $msg]);
					return;
				}
				if ($this->Kelas_model->deleteById($kid)) {
					$sts = true;
					$msg = '<b>Berhasil!</b> kelas telah dihapus!';
				} else {
					$sts = false;
					$msg = '<b>Gagal!</b> Terjadi kesalahan, silahkan coba lagi';
				}
				echo json_encode(['status' => $sts, 'msg' => $msg]);
			} else {
				echo json_encode(['status' => $sts, 'msg' => $msg]);
			}
		} else {
			$msg = 'Invalid access';
			echo json_encode(['status' => $sts, 'msg' => $msg]);
		}
	}

}