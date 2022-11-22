<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Kelas_model');
		cekLogin();
		if (!isSiswa()) redirect('dashboard');
	}

	public function profile() {
		$data['nonav'] = true;
		if (!is_null($this->input->post('save'))) $this->saveProfile($this->input->post());

		$this->load->view('user/top', $data);
		$this->load->view('user/profile_set', $data);
		$this->load->view('user/down', $data);
	}

	public function kelasku() {
		$this->User_model->updateKelas();
		//$data['nonav'] = true;
		$data['data_kelas'] = $this->Kelas_model->getAllByUser($this->session->userdata('uid'));

		//$this->load->view('user/top', $data);
		$this->load->view('user/my_class', $data);
		//$this->load->view('user/down', $data);
	}

	public function rekening() {
		$this->User_model->updateKelas();
		$data['nonav'] = true;
		$data['data_kelas'] = $this->Kelas_model->getAllByUser($this->session->userdata('uid'));

		$this->load->view('user/top', $data);
		$this->load->view('user/reknote', $data);
		$this->load->view('user/down', $data);
	}

	public function set_password() {
		$data['nonav'] = true;
		if (!is_null($this->input->post('save'))) $this->savePass();

		$this->load->view('user/top', $data);
		$this->load->view('user/pass_set', $data);
		$this->load->view('user/down', $data);
	}

	private function saveProfile($post) {
		$this->form_validation->set_rules($this->User_model->prof_rules);
		if ($this->form_validation->run() !== false) {
			$prof = [
				'fullname' => $this->input->post('fname', true),
				'kelamin' => $this->input->post('kel', true),
				'whatsapp' => formatHp($this->input->post('whatsapp', true)),
				'tgl_lahir' => strtotime($this->input->post('ttl')),
			];
			$this->User_model->updateProfile($prof);
			$this->session->set_flashdata('setting-msg', '<div class="alert alert-info">Profile berhasil diperbarui!</div>');
			redirect('settings/profile');
		} else {
			return array (
				'status' => false,
				'text' => validation_errors()
			);
		}
	}

	public function saveRekening() {
		$this->User_model->updateProfile([
			'rekening' => $this->input->post('text')
		]);
		$this->session->set_flashdata('alert', '<div class="alert alert-info">Rekening berhasil diperbarui!</div>');
		redirect('settings/rekening');
	}

	private function savePass() {
		$this->form_validation->set_rules('pass', 'Kata Sandi Lama', 'required');
		$this->form_validation->set_rules('new_pass', 'Kata Sandi Baru', 'required|min_length[5]');

		if ($this->form_validation->run() !== false) {
			if (!password_verify($this->input->post('pass'), dataUserValue('password'))) {
				$this->session->set_flashdata('setting-msg', '<div class="alert alert-info">Kata sandi anda salah!</div>');
				redirect('settings/set_password');
				return;
			}
			$val = [
				'password' => password_hash($this->input->post('new_pass'), PASSWORD_DEFAULT),
			];
			$hsl = $this->User_model->updateUserData($val);
			if ($hsl) {
				$this->session->set_flashdata('setting-msg', '<div class="alert alert-info">Kata Sandi berhasil diperbarui!</div>');
			} else {
				$this->session->set_flashdata('setting-msg', '<div class="alert alert-info">Terjadi kesalahan sistem!</div>');
			}
			redirect('settings/set_password');
		} else {
			return array (
				'status' => false,
				'text' => validation_errors()
			);
		}
	}
}