<?php
class Consulta extends MY_Model {
    const DB_TABLE = 'consulta';
    const DB_TABLE_PK = 'cod_consulta';
    const DB_LAST_ID_SEQ = 'consulta_cod_consulta_seq';

    public $cod_consulta;
    public $hora_llegada;
    public $hora_salida;
    public $es_cita;
    public $doctor;

    public function tiempo_estimado($cod_doctor) {
        $res = array();
        $this->db->select('avg(hora_salida-hora_llegada) prom');
        $resul = $this->db->get_where($this::DB_TABLE, array(
            'doctor'  => $cod_doctor
        ));
        return $resul->row()->prom;
    }
}
