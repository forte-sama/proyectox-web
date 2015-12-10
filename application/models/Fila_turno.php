<?php
class Fila_turno extends MY_Model {

    const DB_TABLE = 'fila_turno';
    const DB_TABLE_PK = 'cod_fila_turno';
    const DB_LAST_ID_SEQ = 'fila_turno_cod_fila_turno_seq';

    public $cod_fila_turno;
    public $usuario_movil;
    // public $telefono;
    //---------------------
    public $nombre;
    public $identificador;
    //---------------------
    public $fila;
    public $hora_llegada;
    public $cita;

    public function get_list_session_doctor() {
        //load dependencies
        $this->load->Model('Cita');

        $respuesta = array();

        //obtener todos los turnos
        $turnos = $this->get();

        //filtrar solo turnos que son del doctor relacionado con la sesion actual
        foreach($turnos as $t) {
            //load dependencies
            $this->load->model(array('Fila'));
            //cargar una cita para ver si el turno corresponde a doctor de la sesion actual
            $c = new Cita();
            $c->load($t->cita);
            //cargar fila en la que esta el turno actual para ver si el manejador de esa fila (asistente)
            $f = new Fila();
            $f->load($t->fila);

            //verificar que manejador de fila del turno actual es quien inicio sesion
            if($f->asistente == $_SESSION['user_code']) {
                $respuesta[] = $t;
            }
        }

        return $respuesta;
    }

    public function mostrar_hora() {
        return date('h : i a',strtotime($this->hora_llegada));
    }
}
