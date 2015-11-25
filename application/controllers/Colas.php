<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Colas extends CI_Controller {

	public function pr () {
		session_start();

		$this->load->model(array('Cita','Doctor','Usuario_movil'));
		$citas_raw = $this->Cita->get_citas_fecha_doctor('Nov 25, 2015',$_SESSION['doctor']);

		var_dump($citas_raw);
	}

	public function citas_en_fecha() {
		session_start();
		//load dependencies
		$this->load->library('table');
		$this->load->model(array('Cita','Doctor','Usuario_movil'));

		//declaring later used variables
		$data = array();
		//default value of the response
		$estado = 'fallo';
		//buscar citas para la fecha, solo si ya se ha iniciado una sesion que involucre un doctor(su asistente o el mismo doctor)
		if(isset($_SESSION['doctor'])){
			//set response values
			$data['estado'] = 'exito';

			//obtener citas del doctor de la sesion y la fecha seleccionada
			$citas = array();
			$citas_raw = $this->Cita->get_citas_fecha_doctor($this->input->post('target_date'),$_SESSION['doctor']);
			// $citas_raw = array();
			
			//building display arrangement for the html table
			foreach ($citas_raw as $c) {

				$usuario = new Usuario_movil();
				$usuario->load($c->usuario_movil);

				$citas[] = array(
					$c->fecha,
					$c->display_hour(),
					$usuario->nombre . " " . $usuario->apellido,
				);
			}

			//set html table template
	        $this->table->set_heading('Fecha', 'Hora', 'Paciente');
	        $this->table->set_template(array(
	            'table_open'  => '<table class="table table-hover">',
	            'thead_open'  => '<thead>',
	            'thead_close' => '</thead>',
	        ));
	        $data['resultado'] = $this->table->generate($citas);
		}
		else{
			$data['resultado'] = 'No hay sesion activa';
		}

		echo json_encode($data);
	}

	public function crear_cita() {
		session_start();
		if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'asistente'){
			//redireccionar
			redirect(base_url('site/login/'), 'refresh');
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

				if(!isset($usuario->cod_usuario_movil)){
					//Cargar usuario anonimo.
					$usuario->load(1);
				}

				$asistente = new Asistente();
				$asistente->load_by('username',$_SESSION['username']);

				$doctor = new Doctor();
				$doctor->load_by('cod_doctor',$asistente->doctor_cod_doctor);

				$this->load->model('Cita');
				$nueva_cita = new Cita();
				$nueva_cita->usuario_movil = $usuario->cod_usuario_movil;
				$nueva_cita->doctor = $_SESSION['doctor'];
				$nueva_cita->fecha = $this->input->post('fecha');
				$nueva_cita->telefono = $this->input->post('telefono');
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

                $form_success_data = array();

				//EXITO : Las validaciones pasaron
				if($this->form_validation->run() && $this->validar_cita($nueva_cita)){
					$nueva_cita->save();

	                //incluir msg de exito
	                $form_success_data['message_type'] = "alert-success";
	                $form_success_data['message']      =  'Cita creada exitosamente.';

				}
				else{
	                //incluir msg de fracaso
	                $form_success_data['message_type'] = "alert-danger";
	                $form_success_data['message']      =  'Ya su doctor tiene una cita programada para esta fecha y esta hora.';
				}

                $data['form_success'] = $this->load->view('template/form_success',$form_success_data,TRUE);
			}

			//vistas anidadas
			$data['template_header']		= $this->load->view('template/header','',TRUE);
			$data['template_navigation'] 	= $this->load->view('template/navigation','',TRUE);
			$data['template_footer']		= $this->load->view('template/footer','',TRUE);

			$this->load->view('creacion_cita',$data);
		}

	}

	public function crear_turno() {
		session_start();

		if(!isset($_SESSION['username'])) {
			redirect(base_url('site/login/'), 'refresh');
		}

		//load dependencies
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model(array('Fila','Fila_turno','Usuario_movil'));
		//declare later used variables
		$data = array('form_success' => '');

		//tags para delimitar cada error encontrado
		$this->form_validation->set_error_delimiters('<li>', '</li>');

		if($this->input->post('form')) {
			//revalidar datos formulario
			$this->form_validation->set_rules(array(
				array(
					'field' => 'telefono',
					'label' => 'Telefono',
					'rules' => array('required','regex_match[/(8[024]9-)(\d{3}-)\d{4}/]'),
					'errors' => array(
						'required'      => 'Debes incluir un %s.',
						'regex_match'	=> 'Formato de telefono no es valido'
					),
				),
			));

			$form_success_data = array();
			//EXITO : Las validaciones pasaron
			if($this->form_validation->run()){
				$paciente = new Usuario_movil();
				$paciente->load_by('telefono',$this->input->post('telefono'));

				//cargar como usuario dummy si no es encontrado por telefono
				if(!isset($paciente->cod_usuario_movil)) {
					$paciente->load(1); //usuario dummy (ninguno)
				}

				//formato de hora de llegada
				$formato = '%h:%i:%a';

				//agregar turno a la fila
				//obtener codigo de fila desde el asistente que ha iniciado sesion
				$cod_fila             = $this->obtener_codigo_fila($_SESSION['user_code']);
				$turno                = new Fila_turno();
				$turno->usuario_movil = $paciente->cod_usuario_movil;
				$turno->telefono      = $this->input->post('telefono');
				$turno->fila          = $cod_fila;
				$turno->hora_llegada  = mdate($formato, now());
				$turno->cita          = 1; //cita dummy (ninguna)

				if($this->usuario_unico_en_fila($turno->fila, $turno->telefono)){
					$turno->save();

					//incluir msg de exito
	                $form_success_data['message_type'] = "alert-success";
	                $form_success_data['message'] =  'Paciente ingresado a la cola.  '
	                                                . anchor(base_url("site/login"),'Iniciar sesion','class="btn btn-success"');

				}
				else{
					$form_success_data['message_type'] = "alert-danger";
	                $form_success_data['message'] =  'Ya un paciente con este telefono ha ingresado a la cola '
													. anchor(base_url("colas/ver_fila"),'Ver cola','class="btn btn-warning"');
				}

                $data['form_success'] = $this->load->view('template/form_success',$form_success_data,TRUE);
				//redireccionar a vista de fila
			}
		}
		//FALLA : Vuelve al formulario

		//vistas anidadas
		$data['template_header']     = $this->load->view('template/header','',TRUE);
		$data['template_navigation'] = $this->load->view('template/navigation','',TRUE);
		$data['template_footer']     = $this->load->view('template/footer','',TRUE);

		$this->load->view('creacion_turno',$data);
	}

	public function fechas_con_citas() {
		session_start();

		//declaring later used variables
		$data = array();
		//default value of the response
		$estado = 'fallo';
		//buscar citas para el doctor, solo si ya se ha iniciado una sesion que lo involucre (su asistente o el mismo doctor)
		if(isset($_SESSION['doctor'])){
			//set response values
			$data['estado'] = 'exito';

			//building sql statement to query all appointments
			$sql = "SELECT DISTINCT fecha "
				 . "FROM cita "
				 . "WHERE doctor=" . $_SESSION['doctor'] . ";";

			//obtener fechas
			$query = $this->db->query($sql);
			$res = array();
			foreach($query->result() as $row) { $res[] = $row->fecha; }
			$data['resultado'] = $res;
		}
		else{
			$data['resultado'] = 'No hay sesion activa';
		}

		echo json_encode($data);
	}

	private function obtener_codigo_fila($user_code) {
		$fila = new Fila();
		$fila->load_by('asistente',$user_code);

		return $fila->cod_fila;
	}

	private function resta_absoluta_horas($hora2,$hora1){
		$timestamp2 = strtotime($hora2)-strtotime($hora1);
		return abs($timestamp2/3600);
	}

	private function usuario_unico_en_fila($fila,$telefono) {
		$turnos = $this->db->get_where('fila_turno',array(
			'fila'     => $fila,
			'telefono' => $telefono
		));

		if($turnos->num_rows() > 0) return FALSE;
		else return TRUE;
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

	public function ver_cita() {
		session_start();

		if(!isset($_SESSION['username'])) {
			redirect(base_url('site/login/'), 'refresh');
		}

		//load dependencies
		$this->load->library('calendar');

		$data = array();
		$data['ajax_doctor']      = $_SESSION['doctor'];
		$data['template_header']     = $this->load->view('template/header','',TRUE);
		$data['template_navigation'] = $this->load->view('template/navigation','',TRUE);
		$data['template_footer']     = $this->load->view('template/footer','',TRUE);
		$this->load->view('ver_cita', $data);
	}

	public function ver_fila() {
		session_start();

		if(!isset($_SESSION['username'])) {
			redirect(base_url('site/login/'), 'refresh');
		}

		//load dependencies
		$this->load->library('table');
		$this->load->model(array('Fila','Fila_turno','Usuario_movil','Cita'));

		$data = array();
		$ar_turnos = array();

		//cargar todos los turnos de la fila relacionada con la sesion
		$turnos = $this->Fila_turno->get_list_session_doctor();
		foreach($turnos as $t) {
			$user = new Usuario_movil();
			$user->load($t->usuario_movil);

			$cita = new Cita();
			$cita->load($t->cita);

			$ar_turnos[] = array(
				$user->nombre . " " . $user->apellido,
				$t->telefono,
				$t->hora_llegada,
				$t->cita,
			);
		}
		$data['turnos'] = $ar_turnos;

		$data['template_header']     = $this->load->view('template/header','',TRUE);
		$data['template_navigation'] = $this->load->view('template/navigation','',TRUE);
		$data['template_footer']     = $this->load->view('template/footer','',TRUE);

		$this->load->view('listado_fila', $data);
	}
}
