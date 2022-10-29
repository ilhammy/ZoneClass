<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	private $imgUrl = null;

	function __construct() {
		parent::__construct();
		cekLogin();
		if (!isAdmin()) redirect();
		$this->load->model('Materi_model', 'Materi');
		$this->load->model('Kelas_model', 'Kelas');
		$this->load->model('Menu_model', 'Menu');
	}

	public function index($param = null) {
		$pilter = roleNameToId($param);
		$data['sb_menu'] = $this->Menu->getMenu();
		$data['users'] = $this->User_model->getAll($pilter);
		$data['pilter'] = $pilter;

		$this->load->view('admin/top', $data);
		$this->load->view('admin/users', $data);
		$this->load->view('admin/down', $data);
	}

	public function removeUser() {
		if ($this->input->server('REQUEST_METHOD') !== 'POST') {
			echo simpleResponse(false, 'Invalid access');
			return;
		}
		$this->form_validation->set_rules('diu', 'User', 'trim|integer|required', array(
			'integer' => 'Invalid data'
		));
		$diu = $this->input->post('diu');
		if ($this->form_validation->run() === false) {
			echo simpleResponse(false, validation_errors());
			return;
		}
		if (!$this->User_model->deleteById($diu)) {
			echo simpleResponse(false, 'Terjadi kelaslahan, user tidak ditemukan');
			return;
		}

		echo simpleResponse(true, 'User berhasil dihapus');
	}
	
	public function toggleUser() {
		if ($this->input->server('REQUEST_METHOD') !== 'POST') {
			echo simpleResponse(false, 'Invalid access');
			return;
		}
		$this->form_validation->set_rules('diu', 'User', 'trim|integer|required', array(
			'integer' => 'Invalid data'
		));
		$this->form_validation->set_rules('tats', 'Target', 'trim|integer|required', array(
			'integer' => 'Invalid data'
		));
		$diu = $this->input->post('diu');
		$stat = $this->input->post('tats');
		if ($this->form_validation->run() === false) {
			echo simpleResponse(false, validation_errors());
			return;
		}
		if (!$this->User_model->updateUserData(['isActive' => $stat], $diu)) {
			echo simpleResponse(false, 'Terjadi kelaslahan, user tidak ditemukan');
			return;
		}

		echo simpleResponse(true, 'Berhasil');
	}

}