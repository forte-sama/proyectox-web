<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller {
    private function crear_fila($user_code) {
        //load dependencies
        $this->load->model(array('Fila','Cita','Fila_turno'));

        //cargar fila de la base de datos
        $new = new Fila();
        $new->load_by('asistente',$user_code);

        //si la fila no fue cargada, entonces hay que crearla
        if(!isset($new->cod_fila)) {
            //formato para fecha
            $format = "%M-%d-%Y";

            $new->asistente = $user_code;
            $new->fecha = mdate($format,now());
            //insertar nueva fila en tabla correspondiente
            $new->save();

            //cargar todas las citas para hoy
            $citas = $this->Cita->get_where_equals(array(
                'fecha'  => $new->fecha,
                'doctor' => $_SESSION['doctor']
            ));
            //entrar todos los turnos para las citas de la fecha de hoy
            foreach($citas as $c) {
                $turno = new Fila_turno();
                $turno->usuario_movil = $c->usuario_movil;
                $turno->telefono = $c->telefono;
                $turno->fila = $new->cod_fila;
                $turno->hora_llegada = $c->hora_programada;
                $turno->cita = $c->cod_cita;

                $turno->save();
            }
        }
    }

    public function index() {
        session_start();

        if(!isset($_SESSION['username'])) {
            redirect(base_url('site/login/'), 'refresh');
        }

        echo "Enhorabuena! Bienvenido, " . $_SESSION['user_type'] . " " . $_SESSION['username'] . "<hr>";
        echo '<a href="' . base_url('site/logout/') . '/">Logout</a>';
    }

    private function limpiar_fila($user_code) {
        ;
    }

    public function logout() {
        session_start();

        if(!isset($_SESSION['username'])) {
            redirect(base_url('site/login/'), 'refresh');
        }

        $this->limpiar_fila($_SESSION['user_code']);

        session_unset();
        setcookie(session_name(),'',0,'/');

        redirect(base_url('site/login/'),'refresh');
    }

    public function login() {
        session_start();

        if(isset($_SESSION['username'])) {
            redirect(base_url('site/index/'), 'refresh');
        }

        $this->load->helper('form');
        $data = array('form_success' => '', 'no_user_pass' => '');

        if(!empty($this->input->post('form'))){
            //Crear nuevo Doctor a ser insertado si pasa las validaciones
            $this->load->model('Doctor');
            $this->load->model('Asistente');

            $doctor    = new Doctor();
            $asistente = new Asistente();

            //capturar datos del formulario
            $login_name = $this->input->post('login_name');
            $password = md5($this->input->post('password'));

            //validar datos
            $this->load->library('form_validation');

            //tags para delimitar cada error encontrado
            $this->form_validation->set_error_delimiters('<li>', '</li>');

            //revalidar datos formulario
            $this->form_validation->set_rules(array(
                array(
                    'field' => 'login_name',
                    'label' => 'Nombre de usuario o Email',
                    'rules' => array('required'),
                    'errors' => array(
                        'required' => 'Debes incluir un %s.',
                    ),
                ),
                array(
                    'field' => 'password',
                    'label' => 'Contraseña',
                    'rules' => array('required','alpha_numeric'),
                    'errors' => array(
                        'required'      => 'Debes incluir un %s.',
                        'alpha_numeric' => '%s incluye algo mas que solo letras y numeros.',
                    ),
                ),
            ));

            //EXITO : Las validaciones pasaron
            if($this->form_validation->run() && ($type = $this->valid_user($login_name, $password)) !== 'nada'){
                //iniciar sesion
                $this->set_session_values($login_name, $type);
                //redireccionar a site/index
                redirect(base_url('site/index/'), 'refresh');
            }
            //FALLA : Vuelve al formulario
            else{
                $data['no_user_pass'] = '<li>no existe usuario/contrasena</li>';
            }
        }

        //vistas anidadas
        $data['template_header'] = $this->load->view('template/header','',TRUE);
        $data['template_footer'] = $this->load->view('template/footer','',TRUE);

        $this->load->view('login',$data);
    }

    private function set_session_values($login_name, $user_type) {
        //declarar variables con valor dummy
        $new = 1;
        $doctor_val = 0;
        $found_asistente = FALSE;

        //busqueda de asistente
        if($user_type == 'asistente') {
            $new = new Asistente();
            $new->load_by('username', $login_name);

            if(!isset($new->cod_asistente)) {
                $new->load_by('email', $login_name);
            }

            //generar valor del codigo del doctor
            $doctor_val = $new->doctor_cod_doctor;

            //indicar que se puede crear fila para doctor (fila vacia)
            $found_asistente = TRUE;
        }
        //busqueda de doctor
        else if($user_type == 'doctor') {
            $new = new Doctor();
            $new->load_by('username', $login_name);

            if(!isset($new->cod_doctor)) {
                $new->load_by('email', $login_name);
            }

            //generar valor del codigo del doctor
            $doctor_val = $new->cod_doctor;
        }

        //generar datos de la sesion
        $_SESSION['doctor']    = $doctor_val;
        $_SESSION['username']  = $new->username;
        $_SESSION['user_code'] = $new->{'cod_' . $user_type};
        $_SESSION['user_type'] = $user_type;

        if($found_asistente == TRUE)
        $this->crear_fila($_SESSION['user_code']);
    }

    private function valid_user($login_user, $password) {
        $new_doctor = new Doctor();
        $new_doctor->load_by('username', $login_user);

        $new_asistente = new Asistente();
        $new_asistente->load_by('username', $login_user);

        //busqueda por nombre de usuario
        if($new_doctor->cod_doctor !== null && $new_asistente->cod_asistente == null) {
            if($new_doctor->password == $password) return 'doctor';
        }
        else if($new_doctor->cod_doctor == null && $new_asistente->cod_asistente !== null) {
            if($new_asistente->password == $password) return 'asistente';
        }

        $new_doctor->load_by('email',$login_user);
        $new_asistente->load_by('email',$login_user);
        //busqueda por email
        if($new_doctor->cod_doctor !== null && $new_asistente->cod_asistente == null) {
            if($new_doctor->password == $password) return 'doctor';
        }
        else if($new_doctor->cod_doctor == null && $new_asistente->cod_asistente !== null) {
            if($new_asistente->password == $password) return 'asistente';
        }

        return 'nada';
    }
}
