<?php

class MY_Model extends CI_Model {
    const DB_TABLE = 'abstract';
    const DB_TABLE_PK = 'abstract';
    const DB_LAST_ID_SEQ = 'abstract';

    /**
     * Create record.
     */
    private function insert() {
        $this->db->query("select nextval('" . $this::DB_LAST_ID_SEQ . "')");
        $this->{$this::DB_TABLE_PK} = $this->db->insert_id($this::DB_LAST_ID_SEQ);
        $this->db->insert($this::DB_TABLE, $this);
    }

    /**
     * Update record.
     */
    private function update() {
        $this->db->where($this::DB_TABLE_PK, $this->{$this::DB_TABLE_PK});
        $this->db->update($this::DB_TABLE, $this);
    }

    /**
     * Populate from an array or standard class.
     * @param mixed $row
     */
    public function populate($row) {
        foreach ($row as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * Load from the database.
     * @param int $id
     */
    public function load($id) {
        $query = $this->db->get_where($this::DB_TABLE, array(
            $this::DB_TABLE_PK => $id,
        ));
        if($query->num_rows() > 0){
            $this->populate($query->row());
        }
    }

    /**
     * Load from the database.
     * @param string $column
     * @param var $target
     */
    public function load_by($column, $target) {
        $query = $this->db->get_where($this::DB_TABLE, array(
            $column => $target,
        ));
        if($query->num_rows() > 0){
            $this->populate($query->row());
        }
    }

    /**
     * Delete the current record.
     */
    public function delete() {
        $this->db->delete($this::DB_TABLE, array(
           $this::DB_TABLE_PK => $this->{$this::DB_TABLE_PK},
       ));
        unset($this->{$this::DB_TABLE_PK});
    }

    /**
     * Save the record.
     */
    public function save() {
        if (isset($this->{$this::DB_TABLE_PK})) {
            $this->update();
        }
        else {
            $this->insert();
        }
    }

    /**
     * Get an array of Models with an optional limit, offset.
     *
     * @param int $limit Optional.
     * @param int $offset Optional; if set, requires $limit.
     * @return array Models populated by database, keyed by PK.
     */
    public function get($limit = 0, $offset = 0) {
        if ($limit) {
            $query = $this->db->get($this::DB_TABLE, $limit, $offset);
        }
        else {
            $query = $this->db->get($this::DB_TABLE);
        }
        $ret_val = array();
        $class = get_class($this);
        foreach ($query->result() as $row) {
            $model = new $class;
            $model->populate($row);
            $ret_val[$row->{$this::DB_TABLE_PK}] = $model;
        }
        return $ret_val;
    }

    public function get_where_equals($column_target_array){
        $res = array();

        $query = $this->db->get_where($this::DB_TABLE, $column_target_array);

        $class = get_class($this);
        foreach ($query->result() as $row) {
            $model = new $class;
            $model->populate($row);
            $res[$row->{$this::DB_TABLE_PK}] = $model;
        }

        return $res;
    }
}
