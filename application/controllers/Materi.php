<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Materi extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Kelas_model');
		$this->load->model('Materi_model');

		cekLogin();
		if (!isSiswa()) redirect('dashboard');
	}

	public function index($idkel) {
		$data['title'] = 'Materi';
		$data['kelid'] = intval(base64url_decode($idkel, false));
		$data['data_kelas'] = $this->Kelas_model->getSingle($data['kelid']);
		$data['data_materi'] = $this->Materi_model->getByClass($data['kelid'], 'asc');
		$data['nonav'] = true;

		$this->load->view('user/top', $data);
		$this->load->view('user/list-materi', $data);
		$this->load->view('user/down', $data);
	}

	public function open_materi($pos) {
		$pos = intval($pos) - 1;
		$materi = null;
		$data['kelid'] = intval(base64url_decode($this->uri->segment('2'), false));
		$data['allmateri'] = $this->Materi_model->getByClass($data['kelid'], 'asc');
		
		foreach ($data['allmateri'] as $key => $val) {
			if ($pos == $key) {
				$materi = $val;
				continue;
			}
		}
		
		$data['materi'] = $materi;
		$data['nonav'] = true;

		if (is_null($materi)) {
			show_404('', false);
			return;
		}
		$this->Materi_model->hitMateri($materi->id);

		$this->load->view('user/top', $data);
		$this->load->view('user/view-materi', $data);
		$this->load->view('user/down', $data);
	}

	public function sy($idMateri) {
		$data['title'] = 'Materi';
		$data['kelid'] = intval(base64_decode(urldecode($idkel), false));
		$data['data_kelas'] = $this->Kelas_model->getSingle($data['kelid']);
		$data['data_materi'] = $this->Materi_model->getByClass($data['kelid']);
		$data['nonav'] = true;

		$this->load->view('user/top', $data);
		$this->load->view('user/materi', $data);
		$this->load->view('user/down', $data);
	}

}