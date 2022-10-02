<?php

function cekLogin() {
	if (!isLogin()) redirect('auth/logout');
}

function isLogin() {
	$ci = &get_instance();
	$ci->load->library('session');
	return ($ci->session->userdata('uid') !== null);
}