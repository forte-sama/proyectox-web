<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller {

    public function index() {
        ;
    }

    public function login() {
        $this->load->helper('form');
        $data = array('form_success' => '');

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
                   'rules' => array('required','alpha_numeric','regex_match[/[a-z].*/]'),
                    'errors' => array(
                        'required'      => 'Debes incluir un %s.',
                        'alpha_numeric' => 'tu %s incluye algo mas que solo letras y numeros.',
                        'regex_match'   => 'Tu nombre de usuario debe iniciar con una letra.',
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
            if($this->form_validation->run() && valid_user($login_name, $password)){
                //iniciar sesion
                
                //redireccionar a site/index
            }
            //FALLA : Vuelve al formulario
        }


		//vistas anidadas
		$data = array(
			'template_header' => $this->load->view('template/header','',TRUE),
			'template_footer' => $this->load->view('template/footer','',TRUE)
		);

		$this->load->view('login',$data);
    }
}
