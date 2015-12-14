<?php
class Fila_turno extends MY_Model {

    const DB_TABLE = 'fila_turno';
    const DB_TABLE_PK = 'cod_fila_turno';
    const DB_LAST_ID_SEQ = 'fila_turno_cod_fila_turno_seq';

    public $cod_fila_turno;
    public $usuario_movil;
    public $nombre;
    public $identificador;
    public $fila;
    public $hora_llegada;
    public $cita;
    public $estado_turno;
    public $hora_entrada_consulta;

    public function turno_actual() {
        //load dependencies
        $this->load->model(array('Fila','Cita'));

        $respuesta = new Fila_turno();
        $fila = new Fila();

        //obtener todos los turnos
        $turnos_activos = $this->get_where_equals(array(
            'estado_turno' => 2, //2 : estado_turno ingresado
        ));

        //filtrar solo turnos que son del doctor relacionado con la sesion actual
        foreach($turnos_activos as $t) {
            //cargar fila en la que esta el turno actual para ver si el manejador de esa fila (asistente)
            $fila->load($t->fila);

            //verificar que manejador de fila del turno actual es quien inicio sesion
            //verificar que el turno todavia sigue en espera y no es el turno que entro a consulta
            if($fila->asistente == $_SESSION['user_code']) {
                $respuesta = $t;
                break; //solo deberia haber un turno
            }
        }

        return $respuesta;
    }

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

            //cargar fila en la que esta el turno actual para ver si el manejador de esa fila (asistente)
            $f = new Fila();
            $f->load($t->fila);

            //verificar que manejador de fila del turno actual es quien inicio sesion
            //verificar que el turno todavia sigue en espera y no es el turno que entro a consulta
            if($f->asistente == $_SESSION['user_code'] && $t->estado_turno == 1) {
                $respuesta[] = $t;
            }
        }

        return $respuesta;
    }

    public function mostrar_hora() {
        return date('h : i a',strtotime($this->hora_llegada));
    }

    public function mostrar_hora_inicio_consulta() {
        return date('h : i a',strtotime($this->hora_entrada_consulta));
    }

    public function iniciar_consulta() {
        $prev_turno_actual = $this->turno_actual();

        if(isset($prev_turno_actual->cod_fila_turno)) {
            return FALSE;
        }

        //actualizar estado a 2 : estado_turno ingresado
        $this->estado_turno = 2;
        //actualizar hora de entrada al consultorio
        $this->hora_entrada_consulta = mdate("%h:%i:%a",now());
        $this->save();

        return TRUE;
    }

    public function get_turnos_usuario($usuario='') {
        $res = array();
        $query = $this->db->get_where($this::DB_TABLE, array(
            'usuario_movil'  => $usuario,
        ));
        $class = get_class($this);
        foreach ($query->result() as $row) {
            $model = new $class;
            $model->populate($row);
            $res[$row->{$this::DB_TABLE_PK}] = $model;
        }
        return $res;
    }
}
