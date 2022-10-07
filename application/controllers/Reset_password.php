<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reset_password extends CI_Controller
{
	
	function __construct() {
		parent::__construct();
		$this->load->model('Auth_model');
	}

	public function token() {
		$token = base64url_decode($this->uri->segment(3));
		$cleanToken = $this->security->xss_clean($token);

		$user_info = $this->Auth_model->isTokenValid($cleanToken); //either false or array();

		if (!$user_info) {
			$this->session->set_flashdata('auth_msg', 'Token tidak valid atau kadaluarsa');
			redirect(site_url('auth'), 'refresh');
		}

		$data = array(
			'title' => 'Halaman Reset Password | Tutorial reset password CodeIgniter @ https://recodeku.blogspot.com',
			'nama' => $user_info->username,
			'email' => $user_info->email,
			'token' => base64url_encode($token)
		);

		$this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
		$this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('auth/head', $data);
			$this->load->view('auth/restpass', $data);
			$this->load->view('auth/foot', $data);
		} else {

			$post = $this->input->post(NULL, TRUE);
			$cleanPost = $this->security->xss_clean($post);
			$hashed = password_hash($cleanPost['password'], PASSWORD_DEFAULT);
			$cleanPost['password'] = $hashed;
			$cleanPost['id_user'] = $user_info->user_id;
			unset($cleanPost['passconf']);
			if (!$this->Auth_model->updatePassword($cleanPost)) {
				$this->session->set_flashdata('auth_msg', 'Update password gagal.');
			} else {
				$this->session->set_flashdata('auth_msg', 'Password anda sudah
             diperbaharui. Silakan login.');
			}
			redirect(site_url('auth'), 'refresh');
		}
	}

}