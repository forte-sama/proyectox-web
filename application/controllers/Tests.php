<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tests extends CI_Controller {
    public function index() {
        $data = array();

    	$data['template_header'] = $this->load->view('template/header','',TRUE);
    	$data['template_footer'] = $this->load->view('template/footer','',TRUE);
        $data['pruebas_caja_negra_login'] = $this->pruebas_caja_negra_login();

        $this->load->view('tests',$data);
    }

    public function pruebas_caja_negra_login() {
        $this->load->library('unit_test');
        $this->load->controller('Site');

        $data = array();

        //doctor valido
        $test_value = array(
            'username' => 'doctor',
            'password' => 'jolopero1'
        );
        $test = $this->Site->valid_user($test_value['username'],md5($test_value['password']));
        $resultado_esperado = 'doctor';
        $test_name = 'Prueba de caja Negra: Tipo de usuario a loguear por nombre de usuario';
        $test_notes = 'Deberia retornar doctor, las credenciales doctor:jolopero1 corresponden a una instancia de doctor';

        $data["login_doctor_correcto"] = $this->unit->run($test, $resultado_esperado, $test_name, $test_notes);
        //asistente valido
        $test_value = array(
            'username' => 'asistente',
            'password' => 'jolopero1'
        );
        $test = $this->Site->valid_user($test_value['username'],md5($test_value['password']));
        $resultado_esperado = 'asistente';
        $test_name = 'Prueba de caja Negra: Tipo de usuario a loguear por nombre de usuario';
        $test_notes = 'Deberia retornar asistente, las credenciales asistente:jolopero1 corresponden a una instancia de asistente';

        $data["login_asistente_correcto"] = $this->unit->run($test, $resultado_esperado, $test_name, $test_notes);
        //usuario invalido
        $test_value = array(
            'username' => 'raro',
            'password' => 'rara'
        );
        $test = $this->Site->valid_user($test_value['username'],md5($test_value['password']));
        $resultado_esperado = 'nada';
        $test_name = 'Prueba de caja Negra: Tipo de usuario a loguear por nombre de usuario';
        $test_notes = 'Deberia retornar nada, las credenciales raro:rara no corresponden a ninguna instancia';

        $data["login_usuario_incorrecto"] = $this->unit->run($test, $resultado_esperado, $test_name, $test_notes);

        return $data;
    }
}
