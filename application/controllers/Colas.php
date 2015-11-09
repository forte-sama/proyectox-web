<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Colas extends CI_Controller {

	public function crear_cita() {
        $this->load->helper('form');

		//vistas anidadas
		$data = array(
			'template_header'		=> $this->load->view('template/header','',TRUE),
			'template_navigation' 	=> $this->load->view('template/navigation','',TRUE),
			'template_footer'		=> $this->load->view('template/footer','',TRUE)
		);

		$this->load->view('creacion_cita',$data);
	}
}
