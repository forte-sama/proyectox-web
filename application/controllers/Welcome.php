<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	public function index() {
		$data = array();

		$data['template_header'] = $this->load->view('template/header','',TRUE);
		$data['template_footer'] = $this->load->view('template/footer','',TRUE);

		$this->load->view('inicio',$data);
	}
}
