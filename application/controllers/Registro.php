<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registro extends CI_Controller {

    public function form_asistente() {
        $this->load->model('Doctor');

        $doctores = $this->Doctor->get();

        $this->load->view('header');
        $this->load->view('registro_asistente', array('doctores' => $doctores));
        $this->load->view('footer');
    }
    public function form_doctor() {
        $this->load->view('header');
        $this->load->view('registro_doctor');
        $this->load->view('footer');
    }
}
