<?php

class Model {

    protected $table;
    protected $limit;
    protected $db;
//
    public function __construct($args = array()) {
        
        $defaults = array(
            'limit' => 0
        );

        $args = array_merge($defaults, $args);

        if(!isset($args['table'])) {
            throw new Exception('Table not defined.');
        }
        
        extract($args);

        $this->table = $table;
        $this->limit = $limit;

        $db_object = Database::get_instance();
        $this->db = $db_object::get_db();
    }
    
    
//    public static function find($ids) {
//        
//        if(!is_array($ids)) {
//            $ids = array($ids);
//        }
//        
//        $defaults = array(
//            'table' => strtolower(get_called_class()).'s',
////            'limit' => $this->limit,
//            'where' => 'WHERE id IN ('.implode(',', $ids).')',
//            'columns' => '*',
//        );
//        
//        extract($defaults);
//        
//        $query = "SELECT {$columns} FROM {$table} {$where}";
//        
//        return self::executeQuery($query);
//    }
//    
//    
//    public static function where($constraint) {
//        
//    }
//    
//    private static function executeQuery($query) {
//        return self::db()->query($query);
//    }
//    
//    public static function get($result_set) {
//        $results = array();
//
//        if(!empty($result_set) && $result_set->num_rows > 0) {
//            while($row = $result_set->fetch_assoc()) {
//                $results[] = $row;
//            }
//        }
//
//        return $results;
//    }
//    
//    public static function first($result_set) {
//        return $result_set->fetch_assoc();
//    }
//    
//    public static function all() {
//        
//        $query("SELECT * FROM $table");
//        
//        $result_set = self::executeQuery($query);
//        
//        return self::get($result_set);
//    }
//    
//    private static function db() {
//        $db_object = Database::get_instance();
//        return $db_object::get_db();
//    }

    public function get($id) {
        return $this->find(array('where' => 'id = '.$id));
    }

    public function get_by_name($name) {
        return $this->find(array('where' => "name = '".$name."'"));
    }

    public function update($element) {
        if(!isset($element['id'])) {
            throw new Exception('Wrong model set.');
        }

        $query = "UPDATE {$this->table} SET ";

        foreach($element as $key => $value) {
            if($key === 'id') {
                continue;
            }
            $query .= "$key = '".$this->db->real_escape_string($value)."',";
        }

        $query = rtrim($query, ',');

        $query .= " WHERE id = {$element['id']}";

        $this->db->query($query);

        return $this->db->affected_rows;
    }

    public function add($element) {
        $keys = array_keys($element);
        $values = array();

        foreach($element as $key => $value) {
            $values[] = "'".$this->db->real_escape_string($value)."'";
        }

        $keys = implode($keys, ',');
        $values = implode($values, ',');

        $query = "INSERT INTO {$this->table}($keys) VALUES($values)";

        $this->db->query($query);

        return $this->db->affected_rows;
    }

    public function find($args = array()) {
        $defaults = array(
            'table' => $this->table,
            'limit' => $this->limit,
            'where' => '',
            'columns' => '*',
        );

        $args = array_merge($defaults, $args);
        
        extract($args);
        
        $query = "SELECT {$columns} FROM {$table}";

        if(!empty($where)) {
            $query .= " WHERE $where";
        }

        if(!empty($limit)) {
            $query .= " LIMIT $limit";
        }
        
        $result_set = $this->db->query($query);

        $results = $this->process_results($result_set);

        return $results;
    }

    protected function process_results($result_set) {
        $results = array();

        if(!empty($result_set) && $result_set->num_rows > 0) {
            while($row = $result_set->fetch_assoc()) {
                $results[] = $row;
            }
        }

        return $results;
    }

}
