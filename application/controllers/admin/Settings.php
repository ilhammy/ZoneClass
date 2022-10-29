<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Kelas_model');
		$this->load->model('Menu_model', 'Menu');
		$this->config->load('globals', TRUE);
		$this->load->helper('file');
		cekLogin();
		if (!isAdminGuru()) redirect('dashboard');
	}

	public function index() {
		$data = [
			'sb_menu' => $this->Menu->getMenu(),
			'webCnf' => file_get_contents('./application/config/globals.php')
		];
		if (!is_null($this->input->post('profile'))) $this->saveProfile();
		if (!is_null($this->input->post('profile-email'))) $this->saveEmail();
		if (!is_null($this->input->post('profile-password'))) $this->savePass();
		if (!is_null($this->input->post('web'))) $this->saveWeb();

		$this->load->view('admin/top', $data);
		$this->load->view('admin/settings', $data);
		$this->load->view('admin/down', $data);
	}

	private function saveProfile() {
		$this->form_validation->set_rules($this->User_model->prof_rules);
		if ($this->form_validation->run() !== false) {
			$prof = [
				'fullname' => $this->input->post('fname', true),
				'kelamin' => $this->input->post('kel', true),
				'whatsapp' => formatHp($this->input->post('whatsapp', true)),
				'tgl_lahir' => strtotime($this->input->post('ttl')),
			];
			$this->User_model->updateProfile($prof);
			$this->session->set_flashdata('alert', 'Profile berhasil diperbarui!');
			redirect('dashboard/settings');
		} else {
			$this->session->set_flashdata('alert', validation_errors());
		}
	}

	private function savePass() {
		$this->form_validation->set_rules('pass1', 'Kata Sandi Lama', 'required');
		$this->form_validation->set_rules('pass1', 'Kata Sandi Baru', 'required|min_length[5]');

		if ($this->form_validation->run() !== false) {
			if (!password_verify($this->input->post('pass1'), userDataValue('password'))) {
				$this->session->set_flashdata('alert', 'Kata sandi anda salah!');
				redirect('dashboard/settings');
				return;
			}
			$val = [
				'password' => password_hash($this->input->post('new_pass'), PASSWORD_DEFAULT),
			];
			$hsl = $this->User_model->updateUserData($val);
			if ($hsl) {
				$this->session->set_flashdata('alert', 'Kata Sandi berhasil diperbarui!');
			} else {
				$this->session->set_flashdata('alert', 'Terjadi kesalahan sistem!');
			}
			redirect('dashboard/settings');
		} else {
			$this->session->set_flashdata('alert', validation_errors());
			redirect('dashboard/settings');
		}
	}

	private function saveEmail() {
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		if ($this->form_validation->run() !== false) {
			$val = [
				'email' => $this->input->post('email', true),
			];
			$hsl = $this->User_model->updateUserData($val);
			if ($hsl) {
				$this->session->set_flashdata('alert', 'Email Akun berhasil diperbarui!');
			} else {
				$this->session->set_flashdata('alert', 'Terjadi kesalahan sistem!');
			}
			redirect('dashboard/settings');
		} else {
			$this->session->set_flashdata('alert', validation_errors());
			redirect('dashboard/settings');
		}
	}

	private function uploadFoto() {
		if (is_null($this->input->post('upload_prof'))) {
			$this->session->set_flashdata('alert', 'Invalid data');
			redirect('dashboard/settings');
			return;
		}

		$config['upload_path'] = 'assets/img/avatar'; // folder upload
		$config['allowed_types'] = 'jpg|jpeg|JPG|JPEG'; // jenis file
		$config['max_size'] = 300000;
		$config['encrypt_name'] = true;
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('fileFoto')) {
			$this->session->set_flashdata('alert', 'Gagal mengubah foto profile');
			redirect('dashboard/settings');
			// echo var_dump($this->upload->display_errors());
		} else {
			$file = $this->upload->data();
			$namaFile = $file['file_name'];
			$res = $this->User_model->updateFoto('/assets/img/avatar/'.$namaFile);
			if ($res) {
				$this->session->set_flashdata('alert', 'Foto Profile berhasil diubah');
				redirect('dashboard/settings');
			} else {
				$this->session->set_flashdata('alert', 'Terjadi kesalahan sistem, coba lagi nanti');
				redirect('dashboard/settings');
			}
		}
	}

	private function saveWeb() {
		$this->form_validation->set_rules('web_set', 'Konfig Website', 'required|min_length[20]');

		if ($this->form_validation->run() === false) {
			$this->session->set_flashdata('alert', 'Terjadi kesalahan sistem, coba lagi nanti');
			redirect('dashboard/settings');
			return;
		}
		if (!write_file('./application/config/globals.php', $this->input->post('web_set'))) {
			$this->session->set_flashdata('alert', 'Gagal menyimpan perubahan website!');
			redirect('dashboard/settings');
		} else {
			$this->session->set_flashdata('alert', 'Perubahan website tersimpan!');
			redirect('dashboard/settings');
		}
	}

}