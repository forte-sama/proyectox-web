<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Api extends CI_Controller {
    public function request_registro(){
          $input_data = json_decode(trim(file_get_contents('php://input')),true);

          $msg = new Mensaje_Respuesta();
          if ($this->registro_es_valido($input_data['username'],$input_data['email'],$msg)){
            $msg->set_error(0);
            $this->load->model("Usuario_movil");
            $nuevo_usuario = new Usuario_movil();
            $nuevo_usuario->username=$input_data['username'];
            $nuevo_usuario->password=$input_data['password'];
            $nuevo_usuario->telefono=$input_data['telefono'];
            $nuevo_usuario->email=$input_data['email'];
            $nuevo_usuario->nombre=$input_data['nombre'];
            $nuevo_usuario->apellido=$input_data['apellido'];
            $nuevo_usuario->sexo=$input_data['sexo'];
            $nuevo_usuario->fecha_nacimiento=$input_data['fecha_nacimiento'];
            $nuevo_usuario->tipo_sangre=$input_data['tipo_sangre'];

            $nuevo_usuario->save();
          }
          echo json_encode($msg);
    }


    public function request_login(){
      $input_data = json_decode(trim(file_get_contents('php://input')),true);
      $this->load->model("Usuario_movil");
      $nuevo_usuario= new Usuario_movil();
      $nuevo_usuario->load_by("username",$input_data['username']);
      $msg = new Mensaje_Respuesta();
      if (!isset($nuevo_usuario->username)){
        $msg->set_error(1);
      }
      elseif($nuevo_usuario->password == $input_data['password']){
        $msg->set_error(0);
      }
      else{
        $msg->set_error(1);
      }
      echo json_encode($msg);
    }

    public function request_edicion(){
        $data = array(

            'username' => $this->input->post('username'),
            'password' => $this->input->post('password'),
            'telefono' => $this->input->post('telefono'),
            'email' => $this->input->post('email'),
            'nombre' => $this->input->post('nombre'),
            'apellido' => $this->input->post('apellido'),
            'sexo' => $this->input->post('sexo'),
            'fecha_nacimiento' => $this->input->post('fecha_nacimiento'),
            'tipo_sangre' => $this->input->post('tipo_sangre'));

            //  $data = array(
            //
            //     'username' => 'sasulo',
            //     'password' => 'asdfasdf',
            //     'telefono' =>'564-445-4555',
            //     'email' => 'email@mmg.com',
            //     'nombre' => 'nombre',
            //     'apellido' => 'apellido',
            //     'sexo' => 'M',
            //     'fecha_nacimiento' => '11-10-2003',
            //     'tipo_sangre' => 'O+');

            echo $data['username'].$data['password'].$data['telefono'].$data['email'].$data['nombre'].$data['apellido'].$data['sexo'].$data['fecha_nacimiento'].$data['tipo_sangre'];

            $this->load->model("Usuario_movil");
            $nuevo_usuario= new Usuario_movil();
            $nuevo_usuario->username=$data['username'];
            $nuevo_usuario->password=$data['password'];
            $nuevo_usuario->telefono=$data['telefono'];
            $nuevo_usuario->email=$data['email'];
            $nuevo_usuario->nombre=$data['nombre'];
            $nuevo_usuario->apellido=$data['apellido'];
            $nuevo_usuario->sexo=$data['sexo'];
            $nuevo_usuario->fecha_nacimiento=$data['fecha_nacimiento'];
            $nuevo_usuario->tipo_sangre=$data['tipo_sangre'];
            //$nuevo_usuario->save();

    }

    public function registro_es_valido($usuario,$correo,$msg){
      $this->load->model("Usuario_movil");
      $validacion1 = new Usuario_movil();
      $validacion2 = new Usuario_movil();
      $validacion1->load_by('username',$usuario);
      $validacion2->load_by('email',$correo);
      if (isset($validacion1->username) && isset($validacion2->email)){
        $msg->set_error(4);
        return FALSE;
      }

      elseif (isset($validacion1->username)){
        $msg->set_error(2);
        return FALSE;
      }
      elseif (isset($validacion2->email)){
        $msg->set_error(3);
        return FALSE;
      }
      return TRUE;
    }

}

Class Mensaje_Respuesta{

    function __construct($cod_error="",$mensaje=""){
      $this->cod_error = $cod_error;
      $this->mensaje = $mensaje;
    }
    function set_error($code){
      switch ($code) {
            case 0:
                $this->cod_error = 0;
                $this->mensaje = "Exito.";
                break;
            case 1:
                $this->cod_error = 1;
                $this->mensaje = "Usuario o contraseña incorrecta.";
                break;
            case 2:
                $this->cod_error = 2;
                $this->mensaje = "El usuario indicado ya está en uso.";
                break;
            case 3:
                $this->cod_error = 3;
                $this->mensaje = "El correo indicado ya está registrado.";
                break;
            case 4:
                $this->cod_error = 4;
                $this->mensaje = "Tanto el usuario como el correo indicados ya están registrados";
                break;
}
    }

}
