<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index() {

	}

	public function blank() {
		$this->load->view('examples/blank');
	}

	public function chart() {
		$this->load->view('examples/chart');
	}

	public function form() {
		$this->load->view('examples/form');
	}

	public function tab_panel() {
		$this->load->view('examples/tab-panel');
	}

	public function table() {
		$this->load->view('examples/table');
	}

	public function ui() {
		$this->load->view('examples/ui');
	}

	public function myblank() {
		$this->load->view('header');
		$this->load->view('blank');
		$this->load->view('footer');
	}
}
