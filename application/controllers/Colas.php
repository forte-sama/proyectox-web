<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Colas extends CI_Controller {

	public function cambio_estado_turno_cita() {
		session_start();

		$data = array('estado' => 'fallo');

		if(!isset($_SESSION['username'])) {
			$data['resultado'] = 'No hay sesion activa';
		}
		else {
			//load dependencies
			$this->load->model(array('Fila','Fila_turno','Cita'));

			//intentar cambiar estado de cita en turno
			$turno = new Fila_turno();
			$turno->load($this->input->post('numero_turno'));

			if(isset($turno->cod_fila_turno)) {
				$cita = new Cita();
				$cita->load($turno->cita);

				if($cita->cliente_presente == 'f') {
					$cita->cliente_presente = 't';
					$turno->num_turno = $this->Fila_turno->asignar_nuevo_num_turno($_SESSION['user_code']);
					$turno->save();
				}
				else {
					$cita->cliente_presente = 'f';
				}

				$cita->save();
			}

			//exito
			$data['estado'] = 'exito';
			$data['resultado'] = $this->mostrar_fila()['fila'];//fn
		}

		echo json_encode($data);
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

			//building display arrangement for the html table
			foreach ($citas_raw as $c) {

				$usuario = new Usuario_movil();
				$usuario->load($c->usuario_movil);

				$display_name = ($usuario->nombre == 'anonimo' ? $c->nombre : $usuario->display_name());

				$citas[] = array(
					$c->mostrar_fecha(),
					$c->mostrar_hora(),
					$display_name,
				);
			}

			//set html table template
	        $this->table->set_heading('Fecha', 'Hora', 'Paciente');
	        $this->table->set_template(array(
	            'table_open'  => '<table class="table table-hover">',
	            'thead_open'  => '<thead>',
	            'thead_close' => '</thead>',
	        ));
			if(count($citas) > 0){
		        $data['resultado'] = $this->table->generate($citas);
			}
			else{
				$data['resultado'] = "<div class=\"text-center\"><h3><i class=\"fa fa-bug fa-2x\"></i> No hay citas en esta fecha, quizas accediste a esta fecha por error.</h3></div>";
			}
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

				$this->load->model(array('Usuario_movil','Asistente','Doctor','Cita'));

				$usuario = new Usuario_movil();
				$usuario->load_by('telefono',$this->input->post('identificador'));

				if(!isset($usuario->cod_usuario_movil)){
					$usuario->load_by('cedula',$this->input->post('identificador'));

					//Cargar usuario anonimo.
					if(!isset($usuario->cod_usuario_movil))
						$usuario->load(1);
				}

				$asistente = new Asistente();
				$asistente->load_by('username',$_SESSION['username']);

				$doctor = new Doctor();
				$doctor->load_by('cod_doctor',$asistente->doctor_cod_doctor);

				//creando nueva cita
				$nueva_cita 				  = new Cita();
				$nueva_cita->usuario_movil 	  = $usuario->cod_usuario_movil;
				$nueva_cita->doctor 		  = $_SESSION['doctor'];
				$nueva_cita->fecha 			  = $this->input->post('fecha');
				$nueva_cita->nombre 		  = $this->input->post('nombre');
				$nueva_cita->identificador 	  = $this->input->post('identificador');
				$nueva_cita->cliente_presente = false;
				$nueva_cita->estado_cita	  = 1;

				//formatear hora para formato de postgreSQL
				$hora_raw = $this->input->post('hora_programada');
				$hora_new = date("g:i a",strtotime($hora_raw));
				$nueva_cita->hora_programada  = $hora_new;

				$this->load->library('form_validation');

				//tags para delimitar cada error encontrado
				$this->form_validation->set_error_delimiters('<li>', '</li>');

				//revalidar datos formulario
				$this->form_validation->set_rules(array(
					array(
						'field' => 'identificador',
						'label' => 'Telefono / Doc. de identificacion',
						'rules' => array('required','callback_identificador_valido'),
						'errors' => array(
							'required'    => 'Debes incluir un %s.',
							'identificador_valido' => 'El %s provisto no tiene el formato valido, favor revisarlo',
						),
					),
	                array(
	                    'field' => 'nombre',
	                    'label' => 'Nombre',
	                    'rules' => array('required','regex_match[/([a-z]|[A-Z])+(([a-z]|[A-Z])|\ )*/]'),
	                    'errors' => array(
	                        'required'    => 'Debes incluir por lo menos un %s.',
	                        'regex_match' => 'Un %s no deberia incluir simbolos raros o numeros',
	                    ),
	                ),
				));

                $form_success_data = array();

				$cita_valida = $this->validar_cita($nueva_cita);
				//EXITO : Las validaciones pasaron
				if($this->form_validation->run() && $cita_valida){
					$nueva_cita->save();

	                //incluir msg de exito
	                $form_success_data['message_type'] = "alert-success";
	                $form_success_data['message']      =  'Cita creada exitosamente.';
				}
				else{
	                //incluir msg de fracaso
	                $form_success_data['message_type'] = "alert-danger";
					$form_success_data['message']      = validation_errors();

					if(!$cita_valida)
	                	$form_success_data['message']  .= '<li>Ya su doctor tiene una cita programada para esta fecha y esta hora.</li>';
				}

                $data['form_success'] = $this->load->view('template/form_success',$form_success_data,TRUE);
			}

			//vistas anidadas
			$data['template_header']     = $this->load->view('template/header','',TRUE);
			$data['template_footer']     = $this->load->view('template/footer','',TRUE);
			$data['template_navigation'] = $this->nav_usuario();

			$this->load->view('creacion_cita',$data);
		}
	}

	public function identificador_valido($campo) {
		$coincide_telefono = (preg_match("/^(8[024]9)-\d{3}-\d{4}$/", $campo, $matches) == 1);
		$coincide_cedula   = (preg_match("/^\d{3}-\d{7}-\d$/", $campo, $matches) == 1);

		if ($coincide_telefono || $coincide_cedula)
			return TRUE;

		return FALSE;
	}

	public function crear_turno() {
		session_start();

		if(!isset($_SESSION['username']) || $_SESSION['user_type'] != 'asistente') {
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
					'field' => 'identificador',
					'label' => 'Documento de identificacion',
					'rules' => array('required','callback_identificador_valido'),
					'errors' => array(
						'required'    => 'Debes incluir un %s.',
						'identificador_valido' => 'El %s provisto no tiene el formato valido, favor revisarlo',
					),
				),
				array(
					'field' => 'nombre',
					'label' => 'Nombre',
					'rules' => array('required','regex_match[/([a-z]|[A-Z])+(([a-z]|[A-Z])|\ )*/]'),
					'errors' => array(
						'required'    => 'Debes incluir por lo menos un %s.',
						'regex_match' => 'Un %s no deberia incluir simbolos raros o numeros',
					),
				),
			));

			$form_success_data = array();
			//EXITO : Las validaciones pasaron
			if($this->form_validation->run()){
				$paciente = new Usuario_movil();
				$paciente->load_by('telefono',$this->input->post('identificador'));

				//cargar como usuario dummy si no es encontrado por telefono
				if(!isset($paciente->cod_usuario_movil)) {
					$paciente->load_by('cedula',$this->input->post('identificador'));

					if(!isset($paciente->cod_usuario_movil))
						$paciente->load(1); //usuario dummy (ninguno)
				}

				//formato de hora de llegada
				$formato = '%h:%i:%a';

				//agregar turno a la fila
				//obtener codigo de fila desde el asistente que ha iniciado sesion
				$cod_fila             = $this->obtener_codigo_fila($_SESSION['user_code']);

				$turno                = new Fila_turno();
				$turno->usuario_movil = $paciente->cod_usuario_movil;
				$turno->nombre		  = $this->input->post('nombre');
				$turno->identificador = $this->input->post('identificador');
				$turno->fila          = $cod_fila;
				$turno->hora_llegada  = mdate($formato, now());
				$turno->cita          = 1; //cita dummy (ninguna)
				$turno->estado_turno  = 1; // 1 : estado_turno espera
				$turno->num_turno     = $this->Fila_turno->asignar_nuevo_num_turno($_SESSION['user_code']);
				// $turno->num_turno = 2;

				if($this->usuario_unico_en_fila($turno->fila, $turno->identificador)){
					$turno->save();

					//incluir msg de exito
	                $form_success_data['message_type'] = "alert-success";
	                $form_success_data['message']      =  'Paciente ingresado exitosamente.';
				}
				else{
					$form_success_data['message_type'] = "alert-danger";
	                $form_success_data['message']      =  'Ya un paciente con esta identidad ha ingresado a la cola '
													   . anchor(base_url("colas/ver_fila"),'Ver cola','class="btn btn-warning"');
				}

                $data['form_success'] = $this->load->view('template/form_success',$form_success_data,TRUE);
				//redireccionar a vista de fila
			}
		}
		//FALLA : Vuelve al formulario

		//vistas anidadas
		$data['template_header']     = $this->load->view('template/header','',TRUE);
		$data['template_footer']     = $this->load->view('template/footer','',TRUE);
		$data['template_navigation'] = $this->nav_usuario();

		$this->load->view('creacion_turno',$data);
	}

	public function xxx() {
		session_start();

        $this->load->model(array('Fila','Cita'));

        $fila = new Fila();
        $fila->load_by('asistente',$_SESSION['user_code']);

        $sql = "SELECT max(num_turno) as maximo FROM fila_turno WHERE fila={$fila->cod_fila}";
        $query = $this->db->query($sql);

        if(isset($query->result()[0]->maximo))
			echo $query->result()[0]->maximo;
		else
			echo 0;
	}

	public function entrada_consulta() {
		session_start();

		if($this->input->post('numero_turno')){
			//load dependencies
			$this->load->model(array('Fila_turno','Consulta','Asistente','Fila'));

			//declare later used variables
			//array de respuesta
			$data = array('estado' => 'exito');
			//turno a ingresar
			$turno = new Fila_turno();
			$turno->load($this->input->post('numero_turno'));

			if(isset($turno->cod_fila_turno)) {
				//intento de cambiar estado de tur no a ingresado
				if($turno->iniciar_consulta() == TRUE) {
					$data['estado'] = 'exito';
				}
				else{
					$data['estado'] = 'fallo';
				}
			}

			$turnos = $this->mostrar_fila();

			$data['resultado_turno_actual'] = $this->turno_actual($turnos);
			$data['resultado_fila']         = $turnos['fila'];

			echo json_encode($data);
		}
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

	private function mostrar_fila() {
		//load dependencies
		$this->load->library('table');
		$this->load->helper(array('date','form'));
		$this->load->model(array('Fila','Fila_turno','Usuario_movil','Cita'));

		$data = array();
		$ar_turnos = array();

		//cargar todos los turnos de la fila relacionada con la sesion
		$turnos = $this->Fila_turno->get_list_session_doctor();
		foreach($turnos as $t) {
			$user = new Usuario_movil();
			$user->load($t->usuario_movil);
			$display_name = ($user->nombre == 'anonimo' ? $t->nombre : $user->display_name());

			$fila = new Fila();
			$fila->load($t->fila);

			//solo seguir procesando turno para mostrarlo si es un turno que correspnde a fila de asistente o medico actual
			if($fila->asistente == $_SESSION['user_code']){

				$cita = new Cita();
				$cita->load($t->cita);
				$cliente_presente_class = '';
				$cliente_presente_msg   = '';

				//postgreSQL t -> true : f -> false
				if($cita->cliente_presente == 't') {
					$cliente_presente_class = 'btn btn-default btn-sm disabled';
					$cliente_presente_msg   = 'Paciente llego';
				}
				else {
					$cliente_presente_class = 'cambio_estado btn btn-primary btn-sm';
					$cliente_presente_msg   = 'Llego el paciente?';
				}

				//opciones de cada turno (solo para asistente)
				if($_SESSION['user_type'] == 'asistente'){
					$opciones = array();
					//BOTON DE CAMBIAR ESTADO DE CITA EN TURNO
					//Si es una cita anonima (turno normal del fila) no hay que actualizar estado
					if($t->cita == 1) {
						$opciones['btn_estado_turno'] = '<span class="badge"><i class="fa fa-list"></i> Turno normal</span>';
					}
					else {
						$opciones['btn_estado_turno'] = form_button(
							'',
							$cliente_presente_msg,
							array(
								'num_turno' => $t->cod_fila_turno,
								'class'     => $cliente_presente_class,
								'title'     => 'Hacer click para indicar que paciente correspondiente ha llegado',
							)
						);
					}

					//BOTON DE SACAR TURNO DE LA FILA
					$opciones['btn_entrada_consulta'] = form_button(
						'',
						'<i class="fa fa-share"></i> Iniciar consulta',
						array(
							'num_turno' => $t->cod_fila_turno,
							'class'     => 'btn btn-primary btn-block btn_entrada_consulta',
							'title'     => 'Hacer click para sacar paciente de la fila',
						)
					);

					//BOTON DE SACAR TURNO DE LA FILA
					$opciones['btn_salida_fila'] = form_button(
						'',
						'<i class="fa fa-sign-out"></i>',
						array(
							'num_turno' => $t->cod_fila_turno,
							'class'     => 'btn btn-warning btn-block btn_salida_fila',
							'title'     => 'Hacer click para sacar paciente de la fila'
						)
					);

					//Agregar row que se mostrara en lista de turnos
					$ar_turnos[] = array(
						$display_name,
						$t->identificador,
						$t->mostrar_hora(),
						$this->load->view('opciones_turno',$opciones,TRUE),
					);
				}
				else {
					//Agregar row que se mostrara en lista de turnos
					$ar_turnos[] = array(
						$display_name,
						$t->identificador,
						$t->mostrar_hora(),
					);
				}
			}
		}

		if($_SESSION['user_type'] == 'asistente')
			$this->table->set_heading('Paciente', 'Telefono / Cedula', 'Hora llegada', 'Opciones de Turnos');
		else
			$this->table->set_heading('Paciente', 'Telefono / Cedula', 'Hora llegada');

		$this->table->set_template(array(
			'table_open'  => '<table class="table table-hover">',
			'thead_open'  => '<thead>',
			'thead_close' => '</thead>',
		));

		$resultado = array();
		$resultado['fila'] = $this->table->generate($ar_turnos);

		//turno actual
		$t_actual = $this->Fila_turno->turno_actual();

		if(isset($t_actual->cod_fila_turno)){
			//usuario del turno actual
			$u_actual = new Usuario_movil();
			$u_actual->load($t_actual->usuario_movil);
			//informacion necesaria por partes del turno actual
			$resultado['turno_actual'] = array(
				'display_info' => array(
					'nombre'        => ($u_actual->nombre == 'anonimo' ? $t_actual->nombre : $u_actual->display_name()),
					'identificador' => $t_actual->identificador,
					'hora_llegada'  => $t_actual->mostrar_hora_inicio_consulta(),
				),
				'num_turno'    => $t_actual->cod_fila_turno,
			);

		}
		else{
			$resultado['turno_actual'] = array('empty');
		}

		return $resultado;
	}

	private function nav_usuario() {
		$user_options = '';

		switch($_SESSION['user_type']){
			case "asistente":
				$user_options = $this->load->view('template/navigation_asistente','',TRUE);
				break;
			case "doctor":
				$user_options = $this->load->view('template/navigation_doctor','',TRUE);
				break;
		}

		$data = array(
			'user_options' => $user_options,
		);

		return $this->load->view('template/navigation',$data,TRUE);
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

	public function salida_consulta() {
		session_start();

		if($this->input->post('numero_turno')){
			$result = array();

			//load dependencies
			$this->load->model(array('Fila_turno','Consulta','Asistente','Fila'));

			//turno que se acaba (sale del consultorio)
			$turno = new Fila_turno();
			$turno->load($this->input->post('numero_turno'));
			//fila donde estaba el turno
			$f = new Fila();
			$f->load($turno->fila);
			//asistente encargad@ de la fila
			$a = new Asistente();
			$a->load($f->asistente);
			//consulta generada para el doctor
			$consulta = new Consulta();
			$consulta->doctor  = $a->doctor_cod_doctor;
			$consulta->es_cita = ($turno->cita != 1); //si el codigo de la cita es diferente a uno es una cita real
			$formato = "%h:%i:%a";
			$consulta->hora_llegada = $turno->hora_entrada_consulta;
			$consulta->hora_salida  = mdate("%h:%i:%a", now());
			//crear nuevo tiempo de consulta
			$consulta->save();
			//sacar turno de la fila
			$turno->sacar_fila();

			$result = array(
				'estado'    => 'exito',
				'resultado' => $this->turno_actual($this->mostrar_fila()),
			);

			echo json_encode($result);
		}
		else {
			echo json_encode(array(
				'estado'    => 'fallo',
				'resultado' => 'Este no parece ser un request legitimo'
			));
		}
	}

	public function salida_fila() {
		session_start();

		$data = array('estado' => 'fallo');

		if(!isset($_SESSION['username'])) {
			$data['resultado'] = 'No hay sesion activa';
		}
		else {
			//load dependencies
			$this->load->model(array('Fila_turno'));

			//intentar cambiar estado de cita en turno
			$turno = new Fila_turno();
			$turno->load($this->input->post('numero_turno'));

			if(isset($turno->cod_fila_turno)) {
				//borrar turno especificado
				$turno->sacar_fila();
			}

			//exito
			$data['estado'] = 'exito';
			$data['resultado'] = $this->mostrar_fila()['fila'];//fn
		}

		echo json_encode($data);
	}

	private function usuario_unico_en_fila($fila,$identificador) {
		$turnos = $this->db->get_where('fila_turno',array(
			'fila'     => $fila,
			'identificador' => $identificador
		));

		if($turnos->num_rows() > 0)
			return FALSE;
		else
			return TRUE;
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

		$data = array();
		$data['ajax_doctor']         = $_SESSION['doctor'];
		$data['template_header']     = $this->load->view('template/header','',TRUE);
		$data['template_footer']     = $this->load->view('template/footer','',TRUE);
		$data['template_navigation'] = $this->nav_usuario();

		$this->load->view('ver_cita', $data);
	}

	public function ver_fila() {
		session_start();

		if(!isset($_SESSION['username'])) {
			redirect(base_url('site/login/'), 'refresh');
		}

		$data = array();

		$turnos = $this->mostrar_fila();
		$data['turnos']				 = $turnos['fila'];
		$data['template_header']     = $this->load->view('template/header','',TRUE);
		$data['template_footer']     = $this->load->view('template/footer','',TRUE);
		$data['template_navigation'] = $this->nav_usuario();
		$data['info_turno_actual']   = $this->turno_actual($turnos); //turno actual

		$this->load->view('ver_fila', $data);
	}

	private function turno_actual($turnos_array) {
		if(count($turnos_array['turno_actual']) < 2)
			return $this->load->view('turno_actual_vacio','',TRUE);
		else
			return $this->load->view('turno_actual_lleno',$turnos_array,TRUE);
	}
}
