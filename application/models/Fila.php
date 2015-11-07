<?php
class Fila extends MY_Model {

    const DB_TABLE = 'fila';
    const DB_TABLE_PK = 'cod_fila';
    const DB_LAST_ID_SEQ = 'fila_cod_fila_seq';

    public $fecha;
    public $estado;
    public $asistente;
}
