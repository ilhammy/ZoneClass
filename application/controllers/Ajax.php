<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Kelas_model');
		$this->load->model('Kun_model', 'Kun');
	}

	public function homeUser() {
		$this->User_model->updateKelas();
		$data['data_kelas'] = $this->Kelas_model->getAllData();
		$this->load->view('user/dash', $data);
	}

	public function kelasUser() {
		$data['data_kelas'] = $this->Kelas_model->getAllByUser($this->session->userdata('uid'));
		$this->load->view('user/kelas', $data);
	}

	public function kamusProduk() {
		$this->load->view('user/kamus-produk');
	}

	public function profileUser() {
		$this->load->view('user/profile');
	}

	public function materi() {
		$this->load->view('user/materi');
	}


	/* JOIN LEAVE CLASS */
	public function joinClass() {
		$cid = $this->input->post('classId', true);
		$kode = $this->input->post('code', true);
		$uid = myUid();

		if (is_null($kode)) {
			echo json_encode([
				'status' => false,
				'msg' => 'Kode undangan kosong'
			]);
			return;
		}

		$resCode = $this->Kun->cekKode($kode, $cid);
		if ($resCode === 0) {
			echo json_encode([
				'status' => false,
				'msg' => 'Kode undangan salah!'
			]);
			return;
		} else if ($resCode === 1) {
			echo json_encode([
				'status' => false,
				'msg' => 'Kode undangan kadaluwarsa!'
			]);
			return;
		}
		$kuota = $this->Kun->getKuota($kode, $cid);
		//die (var_dump($kuota));
		if ($kuota['used'] >= $kuota['max']) {
			echo json_encode([
				'status' => false,
				'msg' => 'Kode undangan sudah penuh!'
			]);
			return;
		}
		$this->Kun->updateUsed($kuota['id']);

		$kelasData = $this->Kelas_model->getSingle($cid);
		$this->Notif_model->push([
			'to' => 'all',
			'uid' => $kelasData->creator_id,
			'title' => 'Siswa Baru ['. $kelasData->nama_kelas . ']',
			'text' => '@' .$_SESSION['username']. ' telah bergabung ke kelas anda',
			'icon' => 'fa fa-user-plus',
			'type' => 'warning'
		]);
		$result = $this->Kelas_model->gabungKelas($uid, $cid, true);
		echo json_encode($result);
	}

	public function leaveClass() {
		$cid = $this->input->post('classId', true);
		$uid = myUid();
		$result = $this->Kelas_model->gabungKelas($uid, $cid, false);
		echo json_encode($result);
	}
	
	public function readNotif($id = null) {
		if (is_null($id)) die(false);
		die($this->Notif_model->readNotif($id));
	}

	/* CEK USERNAME */
	public function cekUsername($uname) {
		echo ($this->User_model->hasUsername($uname)) ? 'true' : 'false';
	}

	/* CEK EMAIL */
	public function cekEmail() {
		$em = base64_decode($this->input->get('mail'));
		echo ($this->User_model->hasEmail($em)) ? 'false' : 'true';
	}

}