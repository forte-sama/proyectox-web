<?php
class Estado_cita extends MY_Model {
    const DB_TABLE = 'estado_cita';
    const DB_TABLE_PK = 'cod_estado';
    const DB_LAST_ID_SEQ = 'estado_cita_cod_estado_seq';

    public $cod_estado;
    public $descripcion_estado;
}
