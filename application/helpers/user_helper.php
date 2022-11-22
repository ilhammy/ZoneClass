<?php

// Get data dari tabel users
function dataUserValue($key) {
	$ci = get_instance();
	$ci->load->model('User_model');
	return $ci->User_model->getUserData($_SESSION['uid'], $key);
}

// Get data dari tabel profile
function profileValue($key) {
	$ci = get_instance();
	$ci->load->model('User_model');
	return $ci->User_model->getProfile($_SESSION['uid'], $key);
}

// Get tipe akun
function getTipeAkun($uid) {
	$ci = get_instance();
	$ci->load->model('User_model');
	$role = $ci->User_model->getUserData($uid, 'role_id');
	return roleName($role);
}

// Nama Level
function roleName($role) {
	if ($role == 0) return 'Admin';
	if ($role == 1) return 'Guru';
	if ($role == 2) return 'Siswa';
	return null;
}

// Nama Level
function roleNameToId($role = null) {
	$role = strtolower($role);
	if ($role == 'admin') return 0;
	if ($role == 'guru') return 1;
	if ($role == 'siswa') return 2;
	if ($role == 'pending') return 3;
	return null;
}

// Output Boolean
function isAdmin($uid = null) {
	$ci = get_instance();
	if (!is_null($uid)) {
		return (getTipeAkun($uid) == 0);
	}
	return ($ci->session->userdata('role_id') == 0);
}

function isAdminGuru($uid = null) {
	$ci = get_instance();
	if (!is_null($uid)) {
		return (getTipeAkun($uid) == 0 || getTypeAkun($uid) == 1);
	}
	return ($ci->session->userdata('role_id') == 0 || $ci->session->userdata('role_id') == 1);
}

function isSiswa($uid = null) {
	$ci = get_instance();
	if (!is_null($uid)) {
		return (getTypeAkun($uid) == 2);
	}
	return ($ci->session->userdata('role_id') == 2);
}

