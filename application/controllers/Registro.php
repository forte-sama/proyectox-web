<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registro extends CI_Controller {

    public function form_asistente() {
        $this->load->model('Doctor');

        $doctores = $this->Doctor->get();

        $this->load->view('registro_asistente', array('doctores' => $doctores));
    }
}
