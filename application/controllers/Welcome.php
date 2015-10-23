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
	public function forte() {
		$res = $this->db->query("SELECT * FROM forte");

		foreach($res->result() as $row){
			echo $row->name . " : " . $row->age . "<br />";
		}
	}

	public function index() {
		$this->load->view('index');
	}

	public function blank() {
		$this->load->view('blank');
	}

	public function chart() {
		$this->load->view('chart');
	}

	public function form() {
		$this->load->view('form');
	}

	public function tab_panel() {
		$this->load->view('tab-panel');
	}

	public function table() {
		$this->load->view('table');
	}

	public function ui() {
		$this->load->view('ui');
	}
}
