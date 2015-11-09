<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Colas extends CI_Controller {

	public function crear_cita() {
    $this->load->helper('form');
		session_start();
		if (!isset($_SESSION['user_type']) || $_SESSION['user_type']!='asistente'){
			//redireccionar
		}
		else{

			if(!empty($this->input->post('form'))){

				$this->load->model('Usuario_movil');
				$this->load->model("Asistente");
				$this->load->model("Doctor");

				$usuario = new Usuario_movil();
				$usuario->load_by('telefono',$this->input->post('telefono'));

				if( is_null($usuario->cod_usuario_movil)){
					//Cargar usuario anonimo.
				}
				$asistente = new Asistente();
				$asistente->load_by('username',$_SESSION['username']);

				$doctor = new Doctor();
				$doctor->load_by('cod_doctor',$asistente->doctor_cod_doctor);



				$this->load->model('Cita');
				$nueva_cita = new Cita();
				$nueva_cita->usuario_movil = $usuario->cod_usuario_movil;
				$nueva_cita->doctor = $doctor->cod_doctor;
				$nueva_cita->fecha = $this->input->post('fecha');
				$nueva_cita->hora_programada = $this->input->post('hora_programada');
				$nueva_cita->estado_cita = 1;
				$nueva_cita->cliente_presente = false;

				$nueva_cita->save();

			}
			//vistas anidadas
			$data = array(
				'template_header'		=> $this->load->view('template/header','',TRUE),
				'template_navigation' 	=> $this->load->view('template/navigation','',TRUE),
				'template_footer'		=> $this->load->view('template/footer','',TRUE)
			);

			$this->load->view('creacion_cita',$data);

		}

	}
}
