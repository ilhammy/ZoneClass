<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invite extends CI_Controller {

	function __construct() {
		parent::__construct();
		cekLogin();
		if (!isAdminGuru()) redirect();
		$this->load->model('Kun_model', 'Kun');
		$this->load->model('Kelas_model', 'Kelas');
		$this->load->model('Menu_model', 'Menu');
	}

	public function index() {
		$data['sb_menu'] = $this->Menu->getMenu();
		$data['alldata'] = $this->Kun->getAllData();
		$data['kelasku'] = $this->Kelas->getMyClass();
		$data['mydata'] = $this->Kun->getAllData(myUid());

		$this->load->view('admin/top', $data);
		$this->load->view('admin/invite_page', $data);
		$this->load->view('admin/down', $data);
	}

	public function edit($param) {}

	public function aturUlang() {
		if ($this->input->server('REQUEST_METHOD') !== 'POST') {
			echo 'Invalid access';
			return;
		}
		if ($this->input->post('kjkl') == null) {
			echo 'Invalid parameter';
			return;
		}

		if ($this->Kun->resetUsed($this->input->post('kjkl'))) {
			echo json_encode([
				'status' => true,
				'msg' => 'Ok'
			]);
			return;
		}
		echo json_encode([
			'status' => false,
			'msg' => 'Terjadi kesalahan silahkan coba lagi'
		]);
	}
	
	public function delCode() {
		if ($this->input->server('REQUEST_METHOD') !== 'POST') {
			echo 'Invalid access';
			return;
		}
		if ($this->input->post('kjkll') == null) {
			echo 'Invalid parameter';
			return;
		}
		if ($this->input->post('udi') == null) {
			echo 'Invalid parameter';
			return;
		}

		if ($this->Kun->deleteCode($this->input->post('kjkll'))) {
			echo json_encode([
				'status' => true,
				'msg' => 'Ok'
			]);
			return;
		}
		echo json_encode([
			'status' => false,
			'msg' => 'Terjadi kesalahan silahkan coba lagi'
		]);
	}

	public function tambahKode() {
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->form_validation->set_rules($this->Kun->create_rules);
			if ($this->form_validation->run() !== false) {
				$forReg = ($this->input->post('forRegist') !== null);
				$inti = array(
					'uid' => myUid(),
					'label' => $this->input->post('label'),
					'kode' => $this->input->post('kode'),
					'kuota' => $this->input->post('kuota'),
					'exp' => $this->formatExp($this->input->post('exp'))
				);
				if (!$forReg) $inti['id_kelas'] = $this->input->post('kelas');

				if ($this->Kun->addCode($inti)) {
					$this->session->set_flashdata('alert', '<b>Berhasil!</b> kode undangan baru telah ditambahkan.');
				} else {
					$this->session->set_flashdata('alert', '<b>Gagal!</b> Terjadi kesalahan, silahkan coba lagi');
				}
				redirect('dashboard/invite');
				return;
			}
			$this->session->set_flashdata('alert', validation_errors());
			redirect('dashboard/invite');
			return;
		} else {
			echo 'Access denied';
		}
	}

	function formatExp($day) {
		$a = 86400 * $day;
		return time() + $a;
	}

}