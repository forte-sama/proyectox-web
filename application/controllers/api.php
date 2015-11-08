<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class API extends CI_Controller {
    public function request_registro(){
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

            $this->load->model("Usuario_Movil");
            $nuevo_usuario= new Usuario_Movil();
            $nuevo_usuario->username=$data['username'];
            $nuevo_usuario->password=$data['password'];
            $nuevo_usuario->telefono=$data['telefono'];
            $nuevo_usuario->email=$data['email'];
            $nuevo_usuario->nombre=$data['nombre'];
            $nuevo_usuario->apellido=$data['apellido'];
            $nuevo_usuario->sexo=$data['sexo'];
            $nuevo_usuario->fecha_nacimiento=$data['fecha_nacimiento'];
            $nuevo_usuario->tipo_sangre=$data['tipo_sangre'];
            $nuevo_usuario->save();
<<<<<<< HEAD
=======

            echo "wei";
>>>>>>> cf1f1a9... T#42 Crear nuevo método para manejar peticiones de edición de datos de usuarios moviles
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

            $this->load->model("Usuario_Movil");
            $nuevo_usuario= new Usuario_Movil();
            $nuevo_usuario->username=$data['username'];
            $nuevo_usuario->password=$data['password'];
            $nuevo_usuario->telefono=$data['telefono'];
            $nuevo_usuario->email=$data['email'];
            $nuevo_usuario->nombre=$data['nombre'];
            $nuevo_usuario->apellido=$data['apellido'];
            $nuevo_usuario->sexo=$data['sexo'];
            $nuevo_usuario->fecha_nacimiento=$data['fecha_nacimiento'];
            $nuevo_usuario->tipo_sangre=$data['tipo_sangre'];
            $nuevo_usuario->save();
<<<<<<< HEAD
=======

            echo "wei editado";
>>>>>>> cf1f1a9... T#42 Crear nuevo método para manejar peticiones de edición de datos de usuarios moviles
    }

}
