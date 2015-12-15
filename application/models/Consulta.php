<?php
class Consulta extends MY_Model {
    const DB_TABLE = 'consulta';
    const DB_TABLE_PK = 'cod_consulta';
    const DB_LAST_ID_SEQ = 'consulta_cod_consulta_seq';

    public $cod_consulta;
    public $fecha;
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

    public function estadisticas_dias($cod_doctor) {
        $sql = "SELECT avg(date_part('minute',hora_salida - hora_llegada)) duracion, date_part('day',fecha) dia
                FROM consulta
                WHERE doctor={$_SESSION['user_code']}
                AND date_part('month',fecha) = date_part('month',localtimestamp)
                GROUP BY date_part('day',fecha)";
        $query = $this->db->query($sql);

        $res = array();

        $res['element']   = 'grafica_consulta';
        $res['data']      = $query->result();
        $res['xkey']      = 'dia';
        $res['ykeys']     = array('duracion');
        $res['labels']    = array('Duracion');
        $res['parseTime'] = FALSE;

        return $res;
    }

    public function estadisticas_meses($cod_doctor) {
        $sql = "SELECT avg(duracion) duracion,
                       date_part('month',fecha) fecha
                FROM (SELECT date_part('minute',hora_salida - hora_llegada) duracion, fecha
                      FROM consulta
                      WHERE doctor={$cod_doctor}) as t
                WHERE date_part('year',fecha) = date_part('year',localtimestamp)
                GROUP BY date_part('month',fecha)";
        $query = $this->db->query($sql);

        $res = array();

        $res['element']   = 'grafica_consulta';
        $res['data']      = $query->result();
        $res['xkey']      = 'mes';
        $res['ykeys']     = array('duracion');
        $res['labels']    = array('Duracion');
        $res['parseTime'] = FALSE;

        return $res;
    }
}
