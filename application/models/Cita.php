<?php
class Cita extends MY_Model {

    const DB_TABLE = 'cita';
    const DB_TABLE_PK = 'cod_cita';
    const DB_LAST_ID_SEQ = 'cita_cod_cita_seq';

    public $cod_cita;
    public $hora_programada;
    public $fecha;
    public $cliente_presente;
    public $doctor;
    public $usuario_movil;
    public $telefono;
    public $estado_cita;

    public function get($limit=0,$offset=0,$parent_get=TRUE){
      if ($parent_get){
        return parent::get($limit,$offset);
      }
      else{
        $ret_val = array();
        $query = $this->db->get_where($this::DB_TABLE, array(
            "fecha" => $this->fecha,
            "doctor"=> $this->doctor
        ));
        return $query->result();
      }

}

}
