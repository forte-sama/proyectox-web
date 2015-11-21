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

    public function display_hour() {
        $ar = explode(":",$this->hora_programada);

        $ar[0] = ($ar[0] == 0 ? 24 : $ar[0]);

        if($ar[0] > 12 && $ar[0] != 24) {
            return ($ar[0] - 12) . " : " . $ar[1] . " PM";
        }
        else if($ar[0] == 24) {
            return "12 : " . $ar[1] . " AM";
        }
        else if($ar[0] == 12) {
            return "12 : " . $ar[1] . " PM";
        }
        else{
            return $ar[0] . " : " . $ar[1] . " AM";
        }
    }

}
