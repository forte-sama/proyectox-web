<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Api extends CI_Controller {
    public function request_registro(){
        $input_data = json_decode(trim(file_get_contents('php://input')),true);
        $msg = new Mensaje_Respuesta();
        if ($this->registro_es_valido($input_data['username'],$input_data['email'],$input_data['telefono'],$msg)){
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
            $nuevo_usuario->cedula = $input_data['cedula'];
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
        $input_data = json_decode(trim(file_get_contents('php://input')),true);
        $this->load->model("Usuario_movil");
        $usuario = new Usuario_movil();
        $usuario->load_by("username",$input_data["usuario"]);
        $msg = new Mensaje_Respuesta();
        if (!isset($usuario->username)){
            $msg->set_error(5);
        }
        elseif($usuario->password == $input_data['vieja_contrasena'] && $this->registro_es_valido("",$input_data['nuevo_correo'],$input_data['nuevo_telefono'],$msg)){
            $msg->set_error(0);
            if ($input_data["nuevo_correo"] != "mismo"){
                $usuario->email = $input_data["nuevo_correo"];
            }
            if ($input_data["nueva_contrasena"] != "mismo"){
                $usuario->password = $input_data["nueva_contrasena"];
            }
            if ($input_data["nuevo_telefono"] != "mismo"){
                $usuario->telefono = $input_data["nuevo_telefono"];
            }
            $usuario->save();
        }
        elseif($usuario->password != $input_data['vieja_contrasena']){
            $msg->set_error(1);
        }
        echo json_encode($msg);
    }
    public function request_info_fila(){
        $input_data = json_decode(trim(file_get_contents('php://input')),true);
        $this->load->model("Usuario_movil");
        $usuario= new Usuario_movil();
        $usuario->load_by("username",$input_data['username']);
        $if = new Info_Fila();
        $info_filas = array();
        if (!isset($usuario->username)){
            $if->estado_peticion='2';
            array_push($info_filas,$if);
            echo json_encode($info_filas);
            return;
        }
        $this->load->model("Fila_turno");
        $turno = new Fila_turno();
        $turnos = $turno->get_turnos_usuario($usuario->cod_usuario_movil);
        if(count($turnos)==0){
            $if->estado_peticion='1';
            array_push($info_filas,$if);
            echo json_encode($info_filas);
            return;
        }
        else{
            echo json_encode($this->cargar_infofila($turnos));
        }
    }
    private function cargar_infofila($turnos){
        $info_filas= array();
        $this->load->model("Doctor");
        $this->load->model("Fila");
        $this->load->model("Asistente");
        $this->load->model("Consulta");
        $this->load->model("Cita");
        foreach ($turnos as $t){
            if($t->estado_turno == 2){
                continue;
            }
            $if = new Info_Fila();
            $fila = new Fila();
            $fila->load_by("cod_fila",$t->fila);
            $asistente = new Asistente();
            $asistente->load_by("cod_asistente",$fila->asistente);
            $doctor = new Doctor();
            $doctor->load_by("cod_doctor",$asistente->doctor_cod_doctor);
            $cita = new Cita();
            if ($t->cita == 1){
                $if->es_cita = "false";
            }
            else{
                $if->es_cita = "true";
            }
            $consulta = new Consulta();
            $if->nombre_asistente = $asistente->nombre." ".$asistente->apellido;
            $if->nombre_doctor = $doctor->nombre." ".$doctor->apellido;
            $if->titulo_doctor = $doctor->titulo;
            $if->hora_llegada = $t->hora_llegada;
            $if->estado_peticion='0';
            $tiempo_estimado =   $consulta->tiempo_estimado($doctor->cod_doctor);
            sscanf($tiempo_estimado, "%d:%d:%d", $hours, $minutes, $seconds);
            $if->tiempo_estimado = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
            array_push($info_filas,$if);
        }
        return $info_filas;
    }
    public function request_info_cita(){
        $input_data = json_decode(trim(file_get_contents('php://input')),true);
        $this->load->model("Usuario_movil");
        $usuario= new Usuario_movil();
        $usuario->load_by("username",$input_data['username']);
        $ic = new Info_Cita();
        $info_citas = array();
        if (!isset($usuario->username)){
            $ic->estado_peticion='2';
            array_push($info_citas,$ic);
            echo json_encode($info_citas);
            return;
        }
        $this->load->model("Cita");
        $cita = new Cita();
        $citas = $cita->get_citas_usuario($usuario->cod_usuario_movil);
        if(count($citas)==0){
            $ic->estado_peticion='1';
            array_push($info_citas,$ic);
            echo json_encode($info_citas);
            return;
        }
        else{
            echo json_encode($this->cargar_infocita($citas));
        }
    }
    private function cargar_infocita($citas){
        $info_citas= array();
        $this->load->model("Doctor");
        $this->load->model("Consulta");
        $this->load->model("Cita");
        foreach ($citas as $c){
            if($c->estado_cita == 2 || $c->estado_cita ==4){
                continue;
            }
            $ic = new Info_Cita();
            $doctor = new Doctor();
            $doctor->load_by("cod_doctor",$c->doctor);
            $ic->estado_peticion="0";
            $ic->nombre_doctor=$doctor->nombre." ".$doctor->apellido;
            $ic->titulo_doctor = $doctor->titulo;
            $ic->fecha = $c->mostrar_fecha();
            $ic->hora_programada = $c->hora_programada;
            $ic->estado_cita = $c->estado_cita;
            array_push($info_citas,$ic);
        }
        return $info_citas;
    }
    private function registro_es_valido($usuario,$correo,$telefono,$msg){
        $this->load->model("Usuario_movil");
        $validacion1 = new Usuario_movil();
        $validacion2 = new Usuario_movil();
        $validacion3 = new Usuario_movil();
        $validacion1->load_by('username',$usuario);
        $validacion2->load_by('email',$correo);
        $validacion3->load_by('telefono',$telefono);
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
        elseif(isset($validacion3->telefono)){
            $msg->set_error(6);
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
            case 5:
            $this->cod_error = 5;
            $this->mensaje = "Usuario no encontrado.";
            break;
            case 6:
            $this->cod_error = 6;
            $this->mensaje = "El telefono indicado ya está registrado";
            break;
        }
    }
}
Class Info_Fila{
    public $estado_peticion;
    public $nombre_asistente;
    public $nombre_doctor;
    public $titulo_doctor;
    public $hora_llegada;
    public $tiempo_estimado;
    public $es_cita;
}
Class Info_Cita{
    public $estado_peticion;
    public $nombre_doctor;
    public $titulo_doctor;
    public $fecha;
    public $hora_programada;
    public $estado_cita;
}
Class Info_edicion{
    public $usuario;
    public $nueva_contrasena;
    public $vieja_contrasena;
    public $nuevo_correo;
    public $nuevo_telefono;
}
