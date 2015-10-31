<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registro extends CI_Controller {

    public function form_asistente() {
        $this->load->helper('form');

        if(!empty($this->input->post('form'))){
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
            $email_found =    new Asistente();
            $email_found->load_by("email", $new->email);

            $username_found = new Asistente();
            $username_found->load_by("username", $new->username);

            $doctor_found = new Asistente();
            $doctor_found->load_by("doctor_cod_doctor", $new->doctor_cod_doctor);

            $found_email = isset($email_found->email);
            $found_user  = isset($username_found->username);
            $doctor_found  = isset($doctor_found->doctor_cod_doctor);

            //FALLO : encontrado en la bd
            if($found_user || $found_email || $doctor_found){
                if($found_user)  echo "Ya hay asistente con ese username";
                if($found_email) echo "Ya hay asistente con ese email";
                if($doctor_found) echo "Ya ese doctor tiene asistente";
            }
            //EXITO : no encontrado en la bd
            //insertar datos
            else{
                $new->save();
                //redirigir a mensaje de exito
            }
        }
        else{
            $this->load->model('Doctor');
            $doctores = $this->Doctor->get();

            $this->load->view('header');

            //Si no hay doctores, no se pueden registrar asistentes
            if(empty($doctores)){
                $this->load->view('no_medicos');
            }
            //Si hay doctores, se puede seguir con registro de asistentes
            else{
                $this->load->view('registro_asistente', array('doctores' => $doctores));
            }

            $this->load->view('footer');
        }
    }

    public function form_doctor() {
        $this->load->helper('form');

        if(!empty($this->input->post('form'))){
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
            $email_found =    new Doctor();
            $email_found->load_by("email", $new->email);

            $username_found = new Doctor();
            $username_found->load_by("username", $new->username);

            $found_email = isset($email_found->email);
            $found_user  = isset($username_found->username);

            //FALLO : encontrado en la bd
            if($found_user || $found_email){
                if($found_user)  echo "Ya hay doctor con ese username";
                if($found_email) echo "Ya hay doctor con ese email";
            }
            //EXITO : no encontrado en la bd
            //insertar datos
            else{
                $new->save();
                //redirigir a mensaje de exito
            }
        }
        else{
            $this->load->view('header');
            $this->load->view('registro_doctor');
            $this->load->view('footer');
        }
    }
}
