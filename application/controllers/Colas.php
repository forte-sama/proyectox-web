<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Colas extends CI_Controller {

	public function crear_cita() {
		session_start();
		if (!isset($_SESSION['user_type']) || $_SESSION['user_type']!='asistente'){
			//redireccionar
		}
		else{
    	$this->load->helper('form');
			$data = array('form_success' => '');
			if(!empty($this->input->post('form'))){

				$this->load->model('Usuario_movil');
				$this->load->model("Asistente");
				$this->load->model("Doctor");

				$usuario = new Usuario_movil();
				$usuario->load_by('telefono',$this->input->post('telefono'));

				if(isset($usuario->cod_usuario_movil)){
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

				$this->load->library('form_validation');

				//tags para delimitar cada error encontrado
				$this->form_validation->set_error_delimiters('<li>', '</li>');

				//revalidar datos formulario
				$this->form_validation->set_rules(array(
					 array(
						 'field' => 'telefono',
						 'label' => 'Telefono',
						 'rules' => array('required','regex_match[/(8[024]9-)(\d{3}-)\d{4}/]'),
							'errors' => array(
								'required'    => 'Debes incluir un %s.',
								'regex_match' => 'Este %s no parece ser un telefono valido para Rep. Dom.',
							),
					 )
				));

				//EXITO : Las validaciones pasaron
				if($this->form_validation->run() && $this->validar_cita($nueva_cita)){
					$nueva_cita->save();
					//incluir msg de exito
					$data['form_success'] = 'Cita creada exitosamente.';
				}
				else{
					$data['form_success']='Ya su doctor tiene una cita programada para esta fecha y esta hora.';
				}

			}

			//vistas anidadas
			$data['template_header']		= $this->load->view('template/header','',TRUE);
			$data['template_navigation'] 	= $this->load->view('template/navigation','',TRUE);
			$data['template_footer']		= $this->load->view('template/footer','',TRUE);

			$this->load->view('creacion_cita',$data);
		}

	}

	private function validar_cita($cita){
		$citas_misma_fecha_doctor = $cita->get(0,0,FALSE);

		foreach ($citas_misma_fecha_doctor as $c){
			if ($this->resta_absoluta_horas($c->hora_programada,$cita->hora_programada)==0){
				return FALSE;
			}
		}
		return TRUE;
	}

	public function resta_absoluta_horas($hora2,$hora1){
		$timestamp2 = strtotime($hora2)-strtotime($hora1);
		return abs($timestamp2/3600);
	}
}
