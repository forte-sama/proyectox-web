<?php
class Asistente extends MY_Model {

    const DB_TABLE = 'asistente';
    const DB_TABLE_PK = 'cod_asistente';
    const DB_LAST_ID_SEQ = 'asistente_cod_asistente_seq';

    public $username;
    public $password;
    public $telefono;
    public $email;
    public $nombre;
    public $apellido;
    public $sexo;
    public $fecha_nacimiento;
    public $cod_asistente;
    public $doctor_cod_doctor;
}
