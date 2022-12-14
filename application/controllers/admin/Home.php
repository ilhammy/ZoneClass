<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct() {
		parent::__construct();
		cekLogin();
		if (!isAdminGuru()) redirect();
		$this->load->model('Kelas_model');
		$this->load->model('Materi_model');
		$this->load->model('Note_model', 'NM');
		$this->load->model('Menu_model', 'Menu');
	}

	public function index() {
		$siswa = array();
		foreach ($this->Kelas_model->getMyClass() as $i) {
			foreach ($this->Kelas_model->getAllSiswaByKelas($i->id_kelas) as $usr) {
				$ud = $this->User_model->getByUid($usr->id_user);
				if (!is_null($ud)) {
					array_push($siswa, $ud);
					$this->User_model->updateKelas($ud->uid);
				}
			}
		}

		$data = array(
			'sb_menu' => $this->Menu->getMenu(),
			'siswaku' => my_array_unique($siswa),
			'materiku' => $this->Materi_model->getByCreator(myUid()),
			'mynotes' => $this->NM->getAll()
		);
		$this->load->view('admin/top', $data);
		$this->load->view('admin/dash', $data);
		$this->load->view('admin/down', $data);
	}

	public function kelas() {
		$data['sb_menu'] = $this->Menu->getMenu();
		$data['data_kelas'] = $this->Kelas_model->getMyClass();
		$data['data_kelas_pending'] = $this->Kelas_model->getPendingClass((isAdmin()) ? null : myUid());

		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->terimaKelas($this->input->post('kelid'), $this->input->post('status'));
			return;
		}

		$this->load->view('admin/top', $data);
		$this->load->view('admin/kelas', $data);
		$this->load->view('admin/down', $data);
	}

	private function terimaKelas($id, $stat) {
		if (is_null($id) || is_null($stat)) {
			$this->session->set_flashdata('alert', 'Invalid opration');
			redirect('dashboard/kelas');
			return;
		}
		if ($this->Kelas_model->updateClassInfo($id, [
			'status' => $stat
		])) {
			$this->session->set_flashdata('alert', 'Berhasil! status kelas telah diubah');
		} else {
			$this->session->set_flashdata('alert', 'Terjadi kesalahan silahkan coba lagi');
		}
		redirect('dashboard/kelas');
	}

	public function detail_kelas($idkes) {
		$data['sb_menu'] = $this->Menu->getMenu();
		$data['data_kelas'] = $this->Kelas_model->getSingle($idkes);
		$data['data_siswa'] = $this->Kelas_model->getAllSiswaByKelas($idkes);
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->form_validation->set_rules($this->Kelas_model->create_rules);
			if ($this->form_validation->run() !== false) {
				$inti = [
					'nama_kelas' => $this->input->post('nama_kelas'),
					'hasAkses' => $this->input->post('hasAkses') == 'ya' ? true : false
				];
				if ($this->Kelas_model->updateClassInfo($idkes, $inti)) {
					$this->session->set_flashdata('alert_s', '<b>Berhasil!</b> Perubahan tersimpan.');
				} else {
					$this->session->set_flashdata('alert', '<b>Gagal!</b> Terjadi kesalahan, silahkan coba lagi ' . $msg);
				}
				redirect('dashboard/kelas/' . $idkes);
				return;
			}
		}

		$this->load->view('admin/top', $data);
		if (is_null($data['data_kelas'])) {
			$data['msg'] = 'Kelas yang anda maksud tidak ditemukan';
			$this->load->view('admin/msg', $data);
		} else if ($data['data_kelas']->creator_id !== myUid() && !isAdmin()) {
			$data['msg'] = 'Akses tidak diizinkan';
			$this->load->view('admin/msg', $data);
		} else {
			$this->load->view('admin/detail_kelas', $data);
		}
		$this->load->view('admin/down', $data);
	}

	public function tambah_kelas() {
		$data['sb_menu'] = $this->Menu->getMenu();
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->form_validation->set_rules($this->Kelas_model->create_rules);
			if ($this->form_validation->run() !== false) {
				$inti = array(
					'creator_id' => myUid(),
					'nama_kelas' => $this->input->post('nama_kelas'),
					'hasAkses' => $this->input->post('hasAkses') == 'ya' ? true : false,
					'tentang' => null, 
					'dibuat' => time()
				);
				if ($this->Kelas_model->addClass($inti)) {
					$this->session->set_flashdata('newclass', '<b>Berhasil!</b> sekarang kelas sedang dalam peninjauan.');
				} else {
					$this->session->set_flashdata('newclass', '<b>Gagal!</b> Terjadi kesalahan, silahkan coba lagi');
				}
				redirect('dashboard/kelas/tambah');
				return;
			}
		}

		$this->load->view('admin/top', $data);
		$this->load->view('admin/add_kelas', $data);
		$this->load->view('admin/down', $data);
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

	public function siswa() {
		$data['sb_menu'] = $this->Menu->getMenu();
		$data['data_kelas'] = $this->Kelas_model->getMyClass();

		$siswa = array();
		foreach ($this->Kelas_model->getMyClass() as $i) {
			foreach ($this->Kelas_model->getAllSiswaByKelas($i->id_kelas) as $usr) {
				$ud = $this->User_model->getByUid($usr->id_user);
				if (!is_null($ud)) {
					array_push($siswa, $ud);
					$this->User_model->updateKelas($ud->uid);
				}
			}
		}
		$data['data_siswa'] = my_array_unique($siswa);

		$this->load->view('admin/top', $data);
		$this->load->view('admin/siswa', $data);
		$this->load->view('admin/down', $data);
	}
	
	public function hapus_siswa($uid) {
		$data['sb_menu'] = $this->Menu->getMenu();
		$data['uid'] = $uid;
		//$data['semuakelas'] = isAdmin() ? $this->Kelas_model->getAllData() : $this->Kelas_model->getMyClass();
		$data['siswa'] = $this->User_model->getByUid($uid);
		if (is_null($data['siswa'])) {
			$data['msg'] = 'Siswa tidak ditemukan';
			$this->load->view('admin/top', $data);
			$this->load->view('admin/msg', $data);
			$this->load->view('admin/down', $data);
			return;
		}
		$allKelas = [];
		foreach (json_decode($data['siswa']->kelas) as $val) {
			$k = $this->Kelas_model->getSingle($val);
			if ($k) {
				if ($k->creator_id == myUid() || isAdmin()) array_push($allKelas, $k);
			}
		}
		$data['semuakelas'] = $allKelas;
		
		$this->load->view('admin/top', $data);
		$this->load->view('admin/delsiswa', $data);
		$this->load->view('admin/down', $data);
	}

	public function kickSiswa() {
		$res = false;
		if ($this->input->server('REQUEST_METHOD') !== 'POST') {
			die('Invalid access');
		}
		if (is_null($this->input->post('uid', true))) {
			die('invalid parameter');
		}
		if (!is_null($this->input->post('kelas', true))) {
			$res = $this->Kelas_model->kickSiswa($this->input->post('kelas', true), $this->input->post('uid', true));
		} else {
			$res = $this->Kelas_model->kickSiswaFromMyAllClass($this->input->post('uid', true));
		}
		if ($res) {
			$this->session->set_flashdata('alert', '<b>Berhasil!</b> siswa telah dikeluarkan');
		} else {
			$this->session->set_flashdata('alert', '<b>Gagal!</b> Terjadi kesalahan, silahkan coba lagi');
		}
		redirect('dashboard/siswa/hapus/'. $this->input->post('uid', true));
	}

}