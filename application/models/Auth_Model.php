<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model
{
	public $tu = "users";
	public $tp = "profile";

	public $log_rules = array(
		array(
			'field' => 'username',
			'label' => 'Username',
			'rules' => 'required|trim'
		),
		array(
			'field' => 'password',
			'label' => 'Password',
			'rules' => 'required|trim',
			'errors' => array(
				'required' => 'Mohon isi %s anda.',
			),
		)
	);
	
	public $reg_rules = array(
		array(
			'field' => 'username',
			'label' => 'Username',
			'rules' => 'trim|required|min_length[3]|max_length[32]|is_unique[users.username]',
			'errors' => array(
				'is_unique' => 'Username tidak tersedia'
			)
		),
		array(
			'field' => 'fullname',
			'label' => 'Nama Lengkap',
			'rules' => 'trim|required|min_length[5]|max_length[30]',
			'errors' => array(
				'min_length' => 'Minimal 3 karakter',
				'max_length' => 'Maksimal 30 karakter!'
			)
		),
		array(
			'field' => 'password',
			'label' => 'Password',
			'rules' => 'trim|required|min_length[3]|max_length[20]',
			'errors' => array(
				'required' => 'Mohon isi %s anda.',
			),
		),
		array(
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'trim|required|valid_email|is_unique[users.email]',
			'errors' => array(
				'is_unique' => 'Email sudah terdaftar!',
			),
		)
	);

	public function cek_user($data) {
		$uname = $data['username'];
		$pass = $data['password'];

		$res = $this->db->get_where($this->tu, ['username' => $uname])->row_array();
		return $res;
	}

	public function createUser($inti, $profil) {
		$this->db->trans_start();
		$this->db->insert($this->tu, $inti);
		$profil['uid'] = $this->db->insert_id();
		$this->db->insert($this->tp, $profil);
		$this->db->trans_complete();
		return $this->db->trans_status();
	}

	public function getByEmail($mail) {
		$res = $this->db->get_where($this->tu, ['email' => $mail])->row_array();
		return $res;
	}

}