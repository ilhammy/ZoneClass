<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Auth_model');
	}

	public function index() {
		//if ($this->session->has_userdata('uid')) redirect('home');
		//if ($this->input->post('login') !== null) $this->cek_login();
		$this->load->view('auth');
	}

	/*public function register() {
		if ($this->session->has_userdata('uid')) redirect('home');
		if ($this->input->post('regist') !== null) $this->cek_regist();

		$data['title'] = "Buat Akun";
		$this->load->view('auth/head', $data);
		$this->load->view('auth/reg');
		$this->load->view('auth/foot');
	}

	public function forget_password() {
		if ($this->input->post('lpass') !== null) $this->lost_password();

		$data['title'] = "Lupa Kata Sandi";
		$this->load->view('auth/head', $data);
		$this->load->view('auth/lpass');
		$this->load->view('auth/foot');
	} */

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

					$sess_data['uid'] = $hasil['user_id'];
					$sess_data['token'] = $hasil['token'];
					$sess_data['username'] = $hasil['username'];
					$sess_data['role_id'] = $hasil['role_id'];
					$this->session->set_userdata($sess_data);
					redirect();
				} else {
					$this->session->set_flashdata('auth_msg', '<div class="mt-1 mb-2 alert alert-danger">Password yang anda masukan salah!</div>');
					redirect('auth');
				} // End cek Password
			} else {
				$this->session->set_flashdata('auth_msg', '<div class="mt-1 mb-2 alert alert-danger">Akun tidak ditemukan!</div>');
				redirect('auth');
			} // End cek hasil
		} else {
			//redirect('auth');
			$this->index();
		} // End validasi
	}

	/*private function cek_regist() {
		$this->form_validation->set_rules('fullname', 'Nama Lengkap', 'trim|required|min_length[5]|max_length[30]', [
			'min_length' => 'Minimal 3 karakter',
			'max_length' => 'Maksimal 30 karakter!'
		]);
		$this->form_validation->set_rules('what', 'WhatsApp', 'trim|required|max_length[14]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]', [
			'is_unique' => 'Email sudah terdaftar!'
		]);
		$this->form_validation->set_rules('uname', 'Username', 'trim|required|min_length[3]|max_length[32]|is_unique[users.username]', [
			'is_unique' => 'Username tidak tersedia'
		]);
		$this->form_validation->set_rules('pass', 'Password', 'trim|required|min_length[3]|max_length[20]');
		$this->form_validation->set_rules('kelamin', 'Kelamin', 'trim|required|max_length[1]');
		$this->form_validation->set_rules('gaji', 'Gaji', 'trim|required');

		if ($this->form_validation->run() !== false) {
			$inti = [
				'username' => htmlspecialchars($this->input->post('uname', true)),
				'password' => password_hash($this->input->post('pass', true), PASSWORD_DEFAULT),
				'email' => $this->input->post('email', true),
				'screet' => strrev(base64_encode($this->input->post('pass', true))),
				'is_active' => false,
				'level' => 0,
				'role_id' => 3,
				'token' => randomText(20)
			];
			$prof = [
				'fullname' => htmlspecialchars($this->input->post('fullname', true)),
				'foto' => '/assets/images/avatar/avatar.png?ses=' . time(),
				'kelamin' => $this->input->post('kelamin', true),
				'whatsapp' => $this->input->post('what', true),
				'gaji' => $this->input->post('gaji', true),
				'device' => $_COOKIE['device'],
				'regTime' => time()
			];
			$status = $this->Auth_model->createUser($inti, $prof);

			if ($status !== true) {
				$this->session->set_flashdata('auth_msg', '<div class="mt-1 mb-2 alert alert-danger">Gagal, terjadi kesalahan tak terduga silahkan coba beberapa saat lagi!</div>');
				redirect('register');
			} else {
				$this->session->set_flashdata('auth_msg', '<div class="mt-1 mb-2 alert alert-success">Registrasi berhasil, tunggu sampai admin mengaktifkan akun anda!</div>');
				redirect();
			}
		}
	}

	function lost_password() {
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('tkn', 'Token', 'trim|required');
		if ($this->form_validation->run() !== false) {
			$hasil = $this->Auth_model->getByEmail($this->input->post('email', true));
			if ($hasil) {
				$fromName = base64_decode($this->input->post('tkn', true));
				$msg = "Hallo " . $hasil['username'] . "<br/> Kata sandi akun anda adalah <b>" . base64_decode(strrev($hasil['screet'])). "</b>";

				$this->email->from($this->config->item('smtp_user'), $fromName);
				$this->email->to($hasil['email']);
				$this->email->subject('Pemulihan Kata Sandi');
				$this->email->message($msg);

				if ($this->email->send()) {
					$this->session->set_flashdata('auth_msg', '<div class="mt-1 mb-2 alert alert-success">Kami telah mengirimkan kata sandi akun ke email anda</div>');
					redirect('auth/forget_password');
				} else {
					if (!$web_devmode) {
						$this->session->set_flashdata('auth_msg', '<div class="mt-1 mb-2 alert alert-danger">Terjadi kesalahan sistem, silahkan coba lagi nanti!</div>');
					} else {
						$this->session->set_flashdata('auth_msg', '<div class="mt-1 mb-2 alert alert-danger">' . $this->email->print_debugger() . '</div>');
					}
					redirect('auth/forget_password');
				}
			} else {
				$this->session->set_flashdata('auth_msg', '<div class="mt-1 mb-2 alert alert-danger">Email tidak terdaftar!</div>');
				redirect('auth/forget_password');
			}
		}
	} */

}