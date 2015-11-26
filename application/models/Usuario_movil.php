<?php
class Usuario_movil extends MY_Model {

    const DB_TABLE = 'usuario_movil';
    const DB_TABLE_PK = 'cod_usuario_movil';
    const DB_LAST_ID_SEQ = 'usuario_movil_cod_usuario_movil_seq';

    public $username;
    public $password;
    public $telefono;
    //--------------
    public $cedula;
    //--------------
    public $email;
    public $nombre;
    public $apellido;
    public $sexo;
    public $fecha_nacimiento;
    public $cod_usuario_movil;
    public $tipo_sangre;

    public function display_name() {
        return $this->nombre . " " . $this->apellido;
    }
}
