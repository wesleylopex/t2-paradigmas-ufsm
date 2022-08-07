<?php

class MY_Model extends CI_Model {
  protected $table;
  protected $primary;
  protected $field_order;
  protected $type_order;

  public function __construct () {
    parent::__construct();
  }

  public function __call ($method, $arguments) {
    if (method_exists($this->db, $method)) {
      return call_user_func_array(array($this->db, $method), $arguments);
    }
  }

  public function save (array $data) {
    if (array_key_exists($this->primary, $data) && !empty($data[$this->primary])) {
      return $this->update($data);
    }

    unset($data[$this->primary]);

    return $this->create($data);
  }

  public function create ($data)  {
    if ($this->db->insert($this->table, $data)) {
      return $this->db->insert_id();
    }

    return false;
  }

  public function update ($data) {
    if (!array_key_exists('id', $data)) {
      return false;
    }
    
    $response = $this->db->update($this->table, $data, [$this->primary => $data['id']]);

    return (bool) $response;
  }

  public function updateWhere ($data, $where) {
    $response = $this->db->update($this->table, $data, $where);
    return (bool) $response;
  }

  public function delete ($id) {
    if (!$id) {
      return false;
    }

    $where = [$this->primary => $id];
    $response = $this->db->delete($this->table, $where);

    return (bool) $response;
  }

  public function deleteWhere ($where) {
    if (!$where) {
      return false;
    }

    $response = $this->db->delete($this->table, $where);

    return (bool) $response;
  }

  public function getByPrimary ($id) {
    if (!$id) {
      return null;
    }

    $where = [$this->primary => $id];
    $query = $this->db->get_where($this->table, $where);

    if ($query->num_rows() == 1) {
      return $query->row();
    }

    return null;
  }

  public function getRowWhere ($where) {
    if (!$where) {
      return null;
    }

    $query = $this->db->get_where($this->table, $where);

    if ($query->num_rows() == 1) {
      return $query->row();
    }

    return null;
  }

  public function getAll ($limit = null, $offset = null) {
    $query = $this->db->order_by($this->field_order, $this->type_order)->get($this->table, $limit, $offset);
    return $query->result();
  }

  public function getAllWhere ($where = null, $limit = null, $offset = null, $field_order = null, $type_order = null, $escape = true) {
    $query = $this->db->order_by($field_order == null ? $this->table . '.' . $this->field_order : $this->table . '.' . $field_order, $type_order == null ? $this->type_order : $type_order);

    $query = $query->where($where, '', $escape);
    $query = $query->get($this->table, $limit, $offset);

    return $query->result();
  }

  public function count (?array $where = []) {
    if (!empty($where)) {
      return $this->db->count_all($this->table);
    }

    return $this->db->where($where)->count_all_results($this->table);
  }

  public function getLast () {
    $query = $this->db->get($this->table, 1, 0);
    
    if ($query->num_rows() == 1) {
      return $query->row();
    }

    return false;
  }

  public function getLastWhere ($where = null, $field_order = null, $type_order = null, $escape = true) {
    $query = $this->db->order_by($field_order == null ? $this->table . '.' . $this->field_order : $this->table . '.' . $field_order, $type_order == null ? $this->type_order : $type_order);

    $query = $query->where($where, '', $escape);
    $query = $query->get($this->table, 1, 0);

    if ($query->num_rows() == 1) {
      return $query->row();
    }
  }
}
