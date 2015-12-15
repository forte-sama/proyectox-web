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
    public $num_turno;

    public function asignar_nuevo_num_turno($cod_asistente) {
        $this->load->model(array('Fila'));

        if(isset($cod_asistente) && !empty($cod_asistente)) {
            $fila = new Fila();
            $fila->load_by('asistente',$cod_asistente);

            return $this->turnos_anteriores($fila->cod_fila) + 1;
        }

        return -1;
    }

    private function turnos_anteriores($cod_fila) {
        $this->load->model(array('Fila','Cita'));

        $fila = new Fila();
        $fila->load($cod_fila);

        $sql = "SELECT max(num_turno) as maximo FROM fila_turno WHERE fila={$cod_fila} AND num_turno != -1";
        $query = $this->db->query($sql);

        if(isset($query->result()[0]->maximo) && !empty($query->result()[0]->maximo))
            return $query->result()[0]->maximo;

        return 0;
    }

    public function cantidad_turnos_anteriores() {

        $sql = "SELECT count(*) as cant
                FROM fila_turno
                WHERE fila = {$this->fila}
                AND num_turno < {$this->num_turno}
                AND estado_turno = 1";

        $cantidad = $this->db->query($sql)->result()[0]->cant;

        $sql2 = "SELECT count(*) as cant
                FROM fila_turno
                WHERE fila = {$this->fila}
                AND estado_turno = 2";

        $cant = $this->db->query($sql2)->result()[0]->cant;

        return ($cant != 0 ? $cantidad + 1 : $cantidad);
    }

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
        $this->load->Model('Cita','Fila','Asistente');

        $respuesta = array();

        //obtener todos los turnos
        $turnos = $this->get();

        //filtrar solo turnos que son del doctor relacionado con la sesion actual
        foreach($turnos as $t) {
            //cargar fila en la que esta el turno actual para ver si el manejador de esa fila (asistente)
            $f = new Fila();
            $f->load($t->fila);

            $asist = new Asistente();
            $asist->load($f->asistente);

            //verificar que manejador de fila del turno actual es quien inicio sesion
            //verificar que el turno todavia sigue en espera y no es el turno que entro a consulta
            if(($f->asistente == $_SESSION['user_code'] || $asist->doctor_cod_doctor == $_SESSION['user_code']) && $t->estado_turno == 1) {
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
            'estado_turno !=' => 2
        ));

        $class = get_class($this);

        foreach ($query->result() as $row) {
            $model = new $class;
            $model->populate($row);
            $res[$row->{$this::DB_TABLE_PK}] = $model;
        }

        return $res;
    }

    public function sacar_fila() {
        if($this->cita != 1) {
            $this->load->model('Cita');

            $cita = new Cita();
            $cita->load($this->cita);
            $cita->estado_cita = 2;
            $cita->save();
        }

        $this->delete();
    }
}
