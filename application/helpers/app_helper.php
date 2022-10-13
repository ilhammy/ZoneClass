<?php

// Untuk Cek Login Lalu redirect
function cekLogin() {
	if (!isLogin()) redirect('auth/logout');
}

// Untuk Cek Login (Boolean)
function isLogin() {
	$ci = &get_instance();
	$ci->load->library('session');
	return ($ci->session->userdata('uid') !== null);
}

// Ambil User_id
function myUid() {
	$ci = &get_instance();
	$ci->load->library('session');
	return $ci->session->userdata('uid');
}

function timeago($timestamp) {
	//$timestamp = strtotime($date);

	$strTime = array("detik", "menit", "jam", "hari", "bulan", "tahun");
	$length = array("60", "60", "24", "30", "12", "10");

	$currentTime = time();
	if ($currentTime >= $timestamp) {
		$diff = time()- $timestamp;
		for ($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
			$diff = $diff / $length[$i];
		}

		$diff = round($diff);
		return $diff . " " . $strTime[$i] . " yang lalu";
	}
}

// UUID GENERATOR
function guidv4($data = null) {
	// Generate 16 bytes (128 bits) of random data or use the data passed into the function.
	$data = $data ?? random_bytes(16);
	assert(strlen($data) == 16);

	// Set version to 0100
	$data[6] = chr(ord($data[6]) & 0x0f | 0x40);
	// Set bits 6-7 to 10
	$data[8] = chr(ord($data[8]) & 0x3f | 0x80);

	// Output the 36 character UUID.
	return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

function formatHp($nohp) {
	$nohp = preg_replace('/\D/', '', $nohp);
	if (!preg_match('/[^+0-9]/', trim($nohp))) {
		if (substr(trim($nohp), 0, 2) == '62') {
			return trim($nohp);
		} else if (substr(trim($nohp), 0, 1) == '0') {
			return '62'.substr(trim($nohp), 1);
		}
	}
}

function base64url_encode($data) {
	return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}
function base64url_decode($data) {
	return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
}

/* Array Unik */
function my_array_unique($array, $keep_key_assoc = false) {
	$duplicate_keys = array();
	$tmp = array();

	foreach ($array as $key => $val) {
		// convert objects to arrays, in_array() does not support objects
		if (is_object($val))
			$val = (array)$val;

		if (!in_array($val, $tmp))
			$tmp[] = $val;
		else
			$duplicate_keys[] = $key;
	}

	foreach ($duplicate_keys as $key)
	unset($array[$key]);

	return $keep_key_assoc ? $array : array_values($array);
}