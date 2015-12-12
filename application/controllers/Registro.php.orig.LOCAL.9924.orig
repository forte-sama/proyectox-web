<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registro extends CI_Controller {

    public function index() {
        session_start();

        if(isset($_SESSION['username'])) {
            redirect(base_url('site/index/'), 'refresh');
        }

        //declare later used variables
        $data = array();

        //vistas anidadas
        $data['template_header'] = $this->load->view('template/header','',TRUE);
        $data['template_footer'] = $this->load->view('template/footer','',TRUE);

        $this->load->view('registro_general',$data);
    }

    public function asistente() {
        $this->load->helper('form');
        $data = array('form_success' => '');

        if(!empty($this->input->post('form'))){
            //Crear nuevo Asistente a ser insertado si pasa las validaciones
            $this->load->model('Asistente');

            $new = new Asistente();

            //capturar datos del formulario
            $new->username = $this->input->post('username');
            $new->password = md5($this->input->post('password'));
            $new->telefono = $this->input->post('telefono');
            $new->email = $this->input->post('email');
            $new->nombre = $this->input->post('nombre');
            $new->apellido = $this->input->post('apellido');
            $new->sexo = $this->input->post('sexo');
            $new->fecha_nacimiento = $this->input->post('fecha_nacimiento');
            $new->doctor_cod_doctor = (int)($this->input->post('doctor_cod_doctor'));

            //validar datos
            $this->load->library('form_validation');

            //tags para delimitar cada error encontrado
            $this->form_validation->set_error_delimiters('<li>', '</li>');

            //revalidar datos formulario
            $this->form_validation->set_rules(array(
                array(
                    'field' => 'username',
                    'label' => 'Nombre de usuario',
                    'rules' => array('required','alpha_numeric','regex_match[/[a-z].*/]','is_unique[usuario.username]'),
                    'errors' => array(
                        'required'      => 'Debes incluir un %s.',
                        'alpha_numeric' => 'tu %s incluye algo mas que solo letras y numeros.',
                        'regex_match'   => 'Tu nombre de usuario debe iniciar con una letra.',
                        'is_unique'     => '%s ya esta en uso!',
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
                array(
                    'field' => 'telefono',
                    'label' => 'Telefono',
                    'rules' => array('required','regex_match[/(8[024]9-)(\d{3}-)\d{4}/]','is_unique[usuario.telefono]'),
                    'errors' => array(
                        'required'    => 'Debes incluir un %s.',
                        'regex_match' => 'Este %s no parece ser un telefono valido para Rep. Dom.',
                        'is_unique'   => 'Este %s ya esta en uso.'
                    ),
                ),
                array(
                    'field' => 'email',
                    'label' => 'Correo Electronico',
                    'rules' => 'required|valid_email|is_unique[usuario.email]',
                    'errors' => array(
                        'required'    => 'Debes incluir un %s.',
                        'valid_email' => 'El %s no tiene un formato valido.',
                        'is_unique'   => 'El email ya esta en uso!'
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
                array(
                    'field' => 'apellido',
                    'label' => 'Apellido',
                    'rules' => array('required','regex_match[/([a-z]|[A-Z])+(([a-z]|[A-Z])|\ )*/]'),
                    'errors' => array(
                        'required'    => 'Debes incluir por lo menos un %s.',
                        'regex_match' => 'Un %s no deberia incluir simbolos raros o numeros',
                    ),
                ),
                array(
                    'field' => 'sexo',
                    'label' => 'Sexo',
                    'rules' => 'required|in_list[M,F]',
                    'errors' => array(
                        'required' => 'Seguro que no tienes %s.',
                        'in_list'  => 'Estas seguro que ese es tu %s',
                    ),
                ),
                array(
                    'field' => 'fecha_nacimiento',
                    'label' => 'Fecha de Nacimiento',
                    'rules' => 'required',
                    'errors' => array(
                        'required' => 'Debiste haber nacido algun dia, por favor incluye una %s.',
                    ),
                ),
            ));

            //EXITO : Las validaciones pasaron
            if($this->form_validation->run()){
                $new->save();

                //incluir msg de exito
                $form_success_data = array();
                $form_success_data['message_type'] = "alert-success";
                $form_success_data['message']      = 'Felicidades! Has podido registrarte, ahora puedes '
                . anchor(base_url("site/login"),'Iniciar sesion','class="btn btn-success"');

                $data['form_success'] = $this->load->view('template/form_success',$form_success_data,TRUE);
            }
            //FALLA : Vuelve al formulario
        }


        //vistas anidadas
        $data['template_header']      = $this->load->view('template/header','',TRUE);
        $data['template_footer']      = $this->load->view('template/footer','',TRUE);

        $this->load->model('Doctor');
        $doctores = $this->Doctor->get_where_equals(array('username !=' => 'anonimo'));

        //Si no hay doctores, no se pueden registrar asistentes
        if(count($doctores) <= 2){
            $this->load->view('no_medico',$data);
        }
        //Si hay doctores, se puede seguir con registro de asistentes
        else{
            $data['doctores'] = $doctores;
            $this->load->view('registro_asistente', $data);
        }
    }

    public function doctor() {
        $this->load->helper('form');
        $data = array('form_success' => '');

        if(!empty($this->input->post('form'))){
            //Crear nuevo Doctor a ser insertado si pasa las validaciones
            $this->load->model('Doctor');

            $new = new Doctor();

            //capturar datos del formulario
            $new->username = $this->input->post('username');
            $new->password = md5($this->input->post('password'));
            $new->telefono = $this->input->post('telefono');
            $new->email = $this->input->post('email');
            $new->nombre = $this->input->post('nombre');
            $new->apellido = $this->input->post('apellido');
            $new->sexo = $this->input->post('sexo');
            $new->fecha_nacimiento = $this->input->post('fecha_nacimiento');
            $new->titulo = $this->input->post('titulo');

            //validar datos
            $this->load->library('form_validation');

            //tags para delimitar cada error encontrado
            $this->form_validation->set_error_delimiters('<li>', '</li>');

            //revalidar datos formulario
            $this->form_validation->set_rules(array(
               array(
                   'field' => 'username',
                   'label' => 'Nombre de usuario',
                   'rules' => array('required','alpha_numeric','regex_match[/[a-z].*/]','is_unique[usuario.username]'),
                    'errors' => array(
                            'required'      => 'Debes incluir un %s.',
                            'alpha_numeric' => 'tu %s incluye algo mas que solo letras y numeros.',
                            'regex_match'   => 'Tu nombre de usuario debe iniciar con una letra.',
                            'is_unique'     => '%s ya esta en uso!',
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
               array(
                   'field' => 'telefono',
                   'label' => 'Telefono',
                   'rules' => array('required','regex_match[/(8[024]9-)(\d{3}-)\d{4}/]','is_unique[usuario.telefono]'),
                    'errors' => array(
                            'required'    => 'Debes incluir un %s.',
                            'regex_match' => 'Este %s no parece ser un telefono valido para Rep. Dom.',
                            'is_unique'   => 'Este %s ya esta en uso.'
                    ),
               ),
               array(
                   'field' => 'email',
                   'label' => 'Correo Electronico',
                   'rules' => 'required|valid_email|is_unique[usuario.email]',
                    'errors' => array(
                            'required'    => 'Debes incluir un %s.',
                            'valid_email' => 'El %s no tiene un formato valido.',
                            'is_unique'   => 'El email ya esta en uso!'
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
               array(
                   'field' => 'apellido',
                   'label' => 'Apellido',
                   'rules' => array('required','regex_match[/([a-z]|[A-Z])+(([a-z]|[A-Z])|\ )*/]'),
                    'errors' => array(
                            'required'    => 'Debes incluir por lo menos un %s.',
                            'regex_match' => 'Un %s no deberia incluir simbolos raros o numeros',
                    ),
               ),
               array(
                   'field' => 'sexo',
                   'label' => 'Sexo',
                   'rules' => 'required|in_list[M,F]',
                    'errors' => array(
                            'required' => 'Seguro que no tienes %s.',
                            'in_list'  => 'Estas seguro que ese es tu %s',
                    ),
               ),
               array(
                   'field' => 'fecha_nacimiento',
                   'label' => 'Fecha de Nacimiento',
                   'rules' => 'required',
                    'errors' => array(
                            'required' => 'Debiste haber nacido algun dia, por favor incluye una %s.',
                    ),

               ),
               array(
                   'field' => 'titulo',
                   'label' => 'Titulo de ejercicio',
                   'rules' => array('required','regex_match[/([a-z]|[A-Z])+(([a-z]|[A-Z])|\ )*/]'),
                    'errors' => array(
                            'required'    => 'Debes incluir un %s.',
                            'regex_match' => 'Un %s no deberia incluir simbolos raros o numeros',
                    ),
               ),
            ));

            //EXITO : Las validaciones pasaron
            if($this->form_validation->run()){
                $new->save();

                //incluir msg de exito
                $form_success_data = array();
                $form_success_data['message_type'] = "alert-success";
                $form_success_data['message'] =  'Felicidades! Has podido registrarte, ahora puedes '
                                                . anchor(base_url("site/login"),'Iniciar sesion','class="btn btn-success"');

                $data['form_success'] = $this->load->view('template/form_success',$form_success_data,TRUE);
            }
            //FALLA : Vuelve al formulario
        }

        //vistas anidadas
		$data['template_header']      = $this->load->view('template/header','',TRUE);
		$data['template_footer']      = $this->load->view('template/footer','',TRUE);


        $this->load->view('registro_doctor', $data);
    }
}
