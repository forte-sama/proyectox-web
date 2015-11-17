<?php
class Fila_turno extends MY_Model {

    const DB_TABLE = 'fila_turno';
    const DB_TABLE_PK = 'cod_fila_turno';
    const DB_LAST_ID_SEQ = 'fila_turno_cod_fila_turno_seq';

    public $cod_fila_turno;
    public $usuario_movil;
    public $telefono;
    public $fila;
    public $hora_llegada;
    public $cita;
}
