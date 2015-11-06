<?php
class Cita extends MY_Model {

    const DB_TABLE = 'cita';
    const DB_TABLE_PK = 'cod_cita';
    const DB_LAST_ID_SEQ = 'cita_cod_cita_seq';

    public $hora_programada;
    public $fecha;
    public $cliente_presente;
    public $doctor;
    public $usuario_movil;
    public $estado_cita;
}
