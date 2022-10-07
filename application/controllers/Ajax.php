<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('Kelas_model');
	}

	public function homeUser() {
		$this->User_model->updateKelas();
		$data['data_kelas'] = $this->Kelas_model->getAllByUser($this->session->userdata('uid'));
		$this->load->view('user/dash', $data);
	}
	
	public function kelasUser() {
		$data['data_kelas'] = $this->Kelas_model->getAllData();
		$this->load->view('user/kelas', $data);
	}
	
	public function notifUser() {
		$this->load->view('user/notif');
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
		$uid = $this->session->userdata('uid');
		$isJoin = $this->Kelas_model->cekUserInClass($uid, $cid);
		$result = $this->Kelas_model->gabungKelas($uid, $cid, $isJoin);
		echo json_encode($result);
	}
	
}