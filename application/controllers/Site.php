<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller {
    public function index() {
        session_start();

        if(!isset($_SESSION['username'])) {
            redirect(base_url('site/login/'), 'refresh');
        }

        echo "Enhorabuena! Bienvenido, " . $_SESSION['user_type'] . " " . $_SESSION['username'] . "<hr>";
        echo '<a href="' . base_url('site/logout/') . '/">Logout</a>';
    }

    public function logout() {
        session_start();

        if(!isset($_SESSION['username'])) {
            redirect(base_url('site/login/'), 'refresh');
        }

        session_unset();
        setcookie(session_name(),'',0,'/');

        redirect(base_url('site/login/'),'refresh');
    }

    public function login() {
        session_start();

        if(isset($_SESSION['username'])) {
            redirect('site/index/', 'refresh');
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
                   'rules' => array('required','alpha_numeric'),
                    'errors' => array(
                        'required'      => 'Debes incluir un %s.',
                        'alpha_numeric' => 'tu %s incluye algo mas que solo letras y numeros.',
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
                $_SESSION['username'] = $login_name;
                $_SESSION['user_type'] = $type;
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
