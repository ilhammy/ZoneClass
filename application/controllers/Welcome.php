<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		cekLogin();
	}

	public function index()
	{
		$this->load->view('user/top');
		$this->load->view('user/main');
		$this->load->view('user/down');
	}
}
