<?php

class Doctor extends MY_Model {

    const DB_TABLE = 'doctor';
    const DB_TABLE_PK = 'cod_doctor';
    const DB_LAST_ID_SEQ = 'doctor_cod_doctor_seq';

    public $username;
    public $password;
    public $telefono;
    public $email;
    public $nombre;
    public $apellido;
    public $sexo;
    public $fecha_nacimiento;
    public $cod_doctor;
    public $titulo;
}
