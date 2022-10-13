<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model
{
	public $tu = "users";
	public $tp = "profile";
	public $tto = "tokens";

	public $log_rules = array(
		array(
			'field' => 'username',
			'label' => 'Username',
			'rules' => 'required|trim',
			'errors' => array(
				'required' => 'Username kosong'
			)
		),
		array(
			'field' => 'password',
			'label' => 'Password',
			'rules' => 'required|trim',
			'errors' => array(
				'required' => 'Password kososng.',
			),
		)
	);

	public $reg_rules = array(
		array(
			'field' => 'username',
			'label' => 'Username',
			'rules' => 'trim|required|min_length[5]|max_length[32]|is_unique[users.username]',
			'errors' => array(
				'min_length' => 'Minimal 5 karakter',
				'max_length' => 'Maksimal 32 karakter!',
				'required' => 'Username kosong',
				'is_unique' => 'Username tidak tersedia'
			)
		),
		array(
			'field' => 'fullname',
			'label' => 'Nama Lengkap',
			'rules' => 'trim|required|min_length[5]|max_length[30]',
			'errors' => array(
				'required' => 'Nama Lengkap kosong',
				'min_length' => 'Minimal 5 karakter',
				'max_length' => 'Maksimal 30 karakter!'
			)
		),
		array(
			'field' => 'password',
			'label' => 'Password',
			'rules' => 'trim|required|min_length[3]|max_length[20]',
			'errors' => array(
				'required' => 'Password kosong',
				'min_length' => '%s minimal 3 karakter',
			),
		),
		array(
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'trim|required|valid_email|is_unique[users.email]',
			'errors' => array(
				'required' => 'Email kosong',
				'is_unique' => 'Email sudah terdaftar!',
				'valid_email' => 'Email tidak benar',
			),
		),
		array(
			'field' => 'what',
			'label' => 'No WhatsApp',
			'rules' => 'trim|required',
			'errors' => array(
				'required' => '%s kosong',
			),
		)
	);

	public function cek_user($data) {
		$uname = $data['username'];
		$pass = $data['password'];

		$res = $this->db->get_where($this->tu, ['username' => $uname])->row_array();
		return $res;
	}

	public function getUserInfo($id) {
		$q = $this->db->get_where($this->tu, array('user_id' => $id), 1);
		if ($this->db->affected_rows() > 0) {
			$row = $q->row();
			return $row;
		} else {
			error_log('no user found getUserInfo(' . $id . ')');
			return false;
		}
	}

	public function getUserInfoByEmail($email) {
		$q = $this->db->get_where($this->tu, array('email' => $email), 1);
		if ($this->db->affected_rows() > 0) {
			$row = $q->row();
			return $row;
		}
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

	public function insertToken($user_id) {
		$token = substr(sha1(rand()), 0, 30);
		$date = date('Y-m-d');

		$string = array(
			'token' => $token,
			'user_id' => $user_id,
			'created' => $date
		);
		$query = $this->db->insert_string($this->tto, $string);
		$this->db->query($query);
		return $token . $user_id;
	}

	public function isTokenValid($token) {
		$tkn = substr($token, 0, 30);
		$uid = substr($token, 30);

		$q = $this->db->get_where($this->tto, array(
			'tokens.token' => $tkn,
			'tokens.user_id' => $uid
		), 1);

		if ($this->db->affected_rows() > 0) {
			$row = $q->row();

			$created = $row->created;
			$createdTS = strtotime($created);
			$today = date('Y-m-d');
			$todayTS = strtotime($today);

			if ($createdTS != $todayTS) {
				return false;
			}

			$user_info = $this->getUserInfo($row->user_id);
			return $user_info;
		} else {
			return false;
		}
	}

	public function updatePassword($post) {
		$this->db->where('user_id', $post['id_user']);
		$this->db->update($this->tu, array('password' => $post['password']));
		return true;
	}

}