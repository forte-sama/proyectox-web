<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index() {
		$this->load->view('examples/index');
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
	
	public function calvo() {
	    $number = mt_rand(100000, 999999);
	    echo json_encode(array('number'=>$number));
	}
}
