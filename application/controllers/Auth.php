<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	private $idKun = null;

	function __construct() {
		parent::__construct();
		$this->load->model('Auth_model');
		$this->load->model('Kun_model', 'Kun');
		$this->load->config('globals');
		$this->load->config('email');
	}

	public function index() {
		if ($this->session->has_userdata('uid')) redirect((isAdminGuru()) ? 'dashboard' : '');
		//if ($this->input->post('login') !== null) $this->cek_login();
		$this->load->view('auth/head');
		$this->load->view('auth/home');
		$this->load->view('auth/foot');
	}

	public function special_regist() {
		if ($this->session->has_userdata('uid')) redirect((isAdminGuru()) ? 'dashboard' : '');
		//if ($this->input->post('login') !== null) $this->cek_login();
		$this->load->view('auth/head');
		$this->load->view('auth/reg_guru');
		$this->load->view('auth/foot');
	}

	public function register() {
		//die(json_encode($this->input->post()));
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			echo json_encode($this->cek_regist());
			return;
		}
		echo json_encode(array(
			'status' => false,
			'text' => 'Akses tidak diizinkan'
		));
	}

	public function lost_password() {
		if ($this->input->post('lpass') !== null) $this->lpass();

		$data['title'] = "Lupa Kata Sandi";
		$this->load->view('auth/head', $data);
		$this->load->view('auth/lpass');
		$this->load->view('auth/foot');
	}

	public function logout() {
		$to = array('uid', 'username', 'token', 'role_id');
		$this->session->unset_userdata($to);
		session_destroy();
		redirect('auth');
	}

	public function login() {
		$this->form_validation->set_rules($this->Auth_model->log_rules);

		if ($this->form_validation->run() !== false) {
			$data['username'] = htmlspecialchars($this->input->post('username', TRUE));
			$data['password'] = $this->input->post('password', TRUE);

			$hasil = $this->Auth_model->cek_user($data);
			if ($hasil) {
				if (password_verify($data['password'], $hasil['password'])) {

					if (!$hasil['isActive']) {
						$this->session->set_flashdata('auth_msg', '<div class="mt-1 mb-2 alert alert-warning"><strong>Oops!</strong> Akun anda belum aktif, silahkan tunggu sampai akun anda diaktifkan atau hubungi admin</div>');
						redirect('auth');
						return;
					}

					$sess_data['uid'] = $hasil['user_id'];
					$sess_data['token'] = $hasil['token'];
					$sess_data['username'] = $hasil['username'];
					$sess_data['role_id'] = $hasil['role_id'];
					$this->session->set_userdata($sess_data);
					redirect(($hasil['role_id'] !== 2) ? 'dashboard' : '');
				} else {
					$this->session->set_flashdata('auth_msg', '<div class="mt-1 mb-2 alert alert-danger">Password yang anda masukan salah!</div>');
					redirect('auth');
				} // End cek Password
			} else {
				$this->session->set_flashdata('auth_msg', '<div class="mt-1 mb-2 alert alert-danger">Akun tidak ditemukan!</div>');
				redirect('auth');
			} // End cek hasil
		} else {
			$this->session->set_flashdata('auth_msg', '<div class="mt-1 mb-2 alert alert-danger">'. validation_errors() .'</div>');
			redirect('auth');
			//$this->index();
		} // End validasi
	}

	private function cek_regist() {
		$this->form_validation->set_rules($this->Auth_model->reg_rules);
		if ($this->form_validation->run() !== false) {
			$guru = (!is_null($this->input->post('is_guru')));
			$regCode = $this->input->post('reg_code');

			if (!is_null($regCode)) {
				$rc = $this->validateInviteCode($regCode);
				if (!$rc['status']) return $rc;
			}

			$inti = [
				'username' => htmlspecialchars($this->input->post('username', true)),
				'email' => $this->input->post('email', true),
				'password' => password_hash($this->input->post('password', true),
					PASSWORD_DEFAULT),
				'role_id' => ($guru) ? 1 : 2,
				'isActive' => true,
				'status' => 0,
				'token' => guidv4()
			];
			$prof = [
				'fullname' => $this->input->post('fullname', true),
				'foto' => (!$guru) ? '/assets/img/default-siswa.png' : '/assets/img/default-guru.png',
				'kelamin' => 'Pria',
				'whatsapp' => formatHp($this->input->post('what', true)),
				'kelas' => '[]',
				'tgl_lahir' => 0,
				'regTime' => time()
			];
			$status = $this->Auth_model->createUser($inti,
				$prof);

			if ($status !== true) {
				$this->Kun->updateUsed($this->idKun);
				return array (
					'status' => false,
					'text' => 'Terjadi kesalahan silahkan coba lagi!'
				);
			} else {
				return array (
					'status' => true,
					'text' => 'OK'
				);
			}
		} else {
			return array (
				'status' => false,
				'text' => validation_errors()
			);
		}
	}

	function lpass() {
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('tkn', 'Email', 'trim|required');

		if ($this->form_validation->run() !== false) {
			$hasil = $this->Auth_model->getByEmail($this->input->post('email', true));
			if ($hasil) {
				$token = $this->Auth_model->insertToken($hasil['user_id']);
				$qstring = base64url_encode($token);
				$url = base_url('reset_password/token/' . $qstring);
				$link = '<a href="' . $url . '">' . $url . '</a>';

				$msg = '';
				$msg .= '<strong>Hai, anda menerima email ini karena ada permintaan untuk memperbaharui
                 password anda.</strong><br>';
				$msg .= '<strong>Silakan klik link ini:</strong> ' . $link;

				$this->email->from($this->config->item('smtp_user'), $this->config->item('web_name'));
				$this->email->to($hasil['email']);
				$this->email->subject('Reset Kata Sandi');
				$this->email->message($msg);

				if ($this->email->send()) {
					$this->session->set_flashdata('auth_msg', 'Berhasil! silahkan periksa email anda');
					redirect('auth/lost_password');
				} else {
					if (!$this->config->item('web_devmode')) {
						$this->session->set_flashdata('auth_msg', 'Terjadi kesalahan sistem, silahkan coba lagi nanti');
					} else {
						$this->session->set_flashdata('auth_msg', $this->email->print_debugger());
					}
					redirect('auth/lost_password');
				}
			} else {
				$this->session->set_flashdata('auth_msg', 'Email tidak terdaftar!');
				redirect('auth/lost_password');
			}
		}
	}

	function validateInviteCode($code) {
		$resCode = $this->Kun->cekKode($code);
		if ($resCode === 0) {
			return [
				'status' => false,
				'text' => 'Kode undangan salah!'
			];
		} else if ($resCode === 1) {
			return [
				'status' => false,
				'text' => 'Kode undangan kadaluwarsa!'
			];
		}

		$kuota = $this->Kun->getKuota($code);
		if ($kuota['used'] >= $kuota['max']) {
			return [
				'status' => false,
				'text' => 'Kode undangan sudah penuh!'
			];
		}

		$this->idKun = $kuota['id'];
		return [
			'status' => true,
			'text' => $kuota['id']
		];
	}

}