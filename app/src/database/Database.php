<?php
/**
 *Description: ...
 *Created by: Isaac
 *Date: 7/23/2020
 *Time: 11:13 AM
 */
namespace Zikzay\Database;

use PDO;
use PDOException;

class Database
{
    private $db = null, $sql = null, $params = null, $limit = null;
    private $select = '';
    private $like = '';
    private $order = '';
    private $where = '';
    private $table = '';
    private $referenceAttrs = '';
    private $column = '';
    private static $dbInstance = null;
    private $attributes = '';
    private $index = '';

    private function __construct()
    {
        try {
            $options = [
                PDO::ATTR_CASE => PDO::CASE_NATURAL,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_ORACLE_NULLS => PDO::NULL_NATURAL,
                PDO::ATTR_STRINGIFY_FETCHES => false,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $this->db = new PDO(DB_DRIVER . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD, $options);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        return $this;
    }

    public static function dbInstance()
    {
        if (!isset(self::$dbInstance)) {
            self::$dbInstance = (new self());
        }
        return self::$dbInstance;
    }

    public function createDatabase()
    {
        $this->sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
        if (!isset(self::$dbInstance)) {
            self::$dbInstance = (new self());
        }
        return self::$dbInstance;
    }

    public function table($table){
        $this->table = TABLE_PREFIX . $table;
        return $this;
    }

    public function select($field1, $field2 = null, $field3 = null, $field4 = null, $field5 = null,
                           $field6 = null, $field7 = null, $field8 = null, $field9 = null, $field10 = null) {
        $this->select = '';
        if(is_array($field1)) {
            foreach ($field1 as $key => $field) {
                $this->select .= $field;
                if(array_key_last($field1) != $key) $this->select .= ', ';
            }
        } else {
            if(isset($field1)) $this->select .= $field1;
            if(isset($field2)) $this->select .= ', ' . $field2;
            if(isset($field3)) $this->select .= ', ' . $field3;
            if(isset($field4)) $this->select .= ', ' . $field4;
            if(isset($field5)) $this->select .= ', ' . $field5;
            if(isset($field6)) $this->select .= ', ' . $field6;
            if(isset($field7)) $this->select .= ', ' . $field7;
            if(isset($field8)) $this->select .= ', ' . $field8;
            if(isset($field9)) $this->select .= ', ' . $field9;
            if(isset($field10)) $this->select .= ', ' . $field10;
        }

        return $this;
    }

    public function get($resultMode = null, $class = null) {
        return $this->execute('single', $resultMode, $class);
    }

    public function getAll($resultMode = null, $class = null){
        return $this->execute('all', $resultMode, $class);
    }

    public function next($resultMode = null, $class = null){
        return $this->execute(null, $resultMode, $class);
    }

    public function count(){
        return $this->execute('count', null, null);
    }

    private function execute($type, $resultMode = null, $class = null) {
        $this->prepareSelectQuery();
        $query = $this->query();
        $mode = $this->resultMode($resultMode);
        if($class){
            $query->setFetchMode($mode, $class);
        }else {
            $query->setFetchMode($mode);
        }
        switch ($type) {
            case 'all':
                return $query->fetchAll();
                break;
            case 'single':
                return $query->fetch();
                break;
            case 'count':
                return $query->rowCount();
            default:
                return $query->nextRowset();
        }
    }

    private function prepareSelectQuery(){
//        if($this->sql == null) {

            $this->sql = "SELECT ";
            if ($this->select != '') $this->sql .= $this->select; else $this->sql .= " * ";

            $this->sql .= " FROM " . $this->table;

            if ($this->where != '' || $this->like != '') {
                $this->sql .= " WHERE ";
                $this->sql .= $this->where;
                $this->sql .= $this->like;
            }

            if ($this->order != '') $this->sql .= " ORDER BY " . $this->order;

            if ($this->limit != null) $this->sql .= " LIMIT " . $this->limit;
//        }
    }

    private function resultMode($resultMode)
    {
        $mode = null;
        switch ($resultMode) {
            case 'array':
                $mode = PDO::FETCH_ASSOC;
                break;

            case 'object':
                $mode = PDO::FETCH_OBJ;
                break;

            case 'index':
                $mode = PDO::FETCH_NUM;
                break;

            case 'both':
                $mode = PDO::FETCH_BOTH;
                break;

            case 'class':
                $mode = PDO::FETCH_CLASS;
                break;

            default:
                $mode = PDO::FETCH_OBJ;
        }
        return $mode;
    }

    public function whereArray(array $paramsPair, array $operators, array $conditions = [])
    {
        $i = 0;
        foreach ($paramsPair as $key => $value) {
            if ($i > 0) $this->where .= " {$conditions[$i - 1]} ";
            $this->where .= "{$key} ";
            $this->where .= "{$operators[$i]} ?";
            $this->params[] = $value;
            $i++;
        }
    }

    public function where($clause, string $arg1 = null, string $arg2 = null)
    {
        $this->params = null;
        $this->where = '';
        $this->analyseWhere ($clause,  $arg1, $arg2);
        return $this;
    }

    public function orWhere($clause, string $arg1 = null, string $arg2 = null)
    {
        $this->analyseWhere ($clause,  $arg1, $arg2, 'OR');
        return $this;
    }

    public function andWhere($clause, string $arg1 = null, string $arg2 = null)
    {
        $this->analyseWhere ($clause,  $arg1, $arg2, 'AND');
        return $this;
    }

    private function analyseWhere ($clause, string $arg1 = null, string $arg2 = null, $condition = null) {
        $this->where .= $condition != null ? " {$condition} " : '';
        if(is_array($clause)){
            foreach ($clause as $key => $value) {
                $this->where .= "{$key} = ?";
                $this->params[] = $value;
            }
        } else {
            if($arg1 && $arg2) {
                $this->where = "{$clause} {$arg1} ? ";
                $this->params[] = $arg2;

            } else if($arg1) {
                $this->where = "{$clause} = ? ";
                $this->params[] = $arg1;

            } else {
                $hasQuotes = explode("'", $clause);
                $noQuotes = explode(" ", $clause);

                if(count($hasQuotes) > 2) {
                    $this->whereHasQuote($hasQuotes);

                }else if(count($noQuotes) > 2) {
                    $this->whereNoQuote($noQuotes);
                }
            }
        }
    }

    private function whereHasQuote($hasQuotes) {
        foreach ($hasQuotes as $key => $hasQuote) {
            if($key % 2 == 0) {
                if(array_key_last($hasQuotes) != $key) {
                    $this->where .= $hasQuote . ' ? ';
                }
            } else {
                $this->params[] = trim($hasQuote);
            }
        }
    }

    private function whereNoQuote($noQuotes) {
        $e = 1;
        for ($i = 0; $i < count($noQuotes); $i++) {

            if($i == (($e * 4) - 2)) {
                $this->where .= ' ? ';
                $this->params[] = $noQuotes[$i];
                $e++;

            } else $this->where .= ' ' . $noQuotes[$i];
        }
    }

    public function order($fields, $direction = null) {
        if(is_array($fields)) {
            foreach ($fields as $key => $field) {
                $this->order .= $field;
                if(is_array($direction)) {
                    $this->order .= isset($direction[$key]) ? ' ' . $direction[$key] . ', ' : ', ';

                } else $this->order .= isset($direction) ? ' ' . $direction . ', ' : ', ';
            }
        } else {
            $this->order .= $fields;
            $this->order .= isset($direction) ? ' ' . $direction . ', ' : ', ';
        }
        $this->order = rtrim($this->order, ', ');

        return $this;
    }

    public function limit($max, $offset = 0) {
        $this->limit = "{$offset}, {$max}";
        return $this;
    }

    public function like($field, $value) {
        $this->params[]  = $value;
        if($this->where == '' && $this->like == ''){
            $this->like .= "{$field} LIKE %?%";
        }else {
            $this->like .= ", {$field} LIKE  %?%";
        }
        return $this;
    }

    public function likeStart($field, $value) {
        $this->params[]  = $value;
        if($this->where == '' && $this->like == ''){
            $this->like .= "{$field} LIKE ?%";
        }else {
            $this->like .= ", {$field} LIKE  ?%";
        }
    }

    public function likeEnd($field, $value) {
        $this->params[]  = $value;
        if($this->where == '' && $this->like == ''){
            $this->like .= "{$field} LIKE %?";
        }else {
            $this->like .= ", {$field} LIKE  %?";
        }
    }

    public function insert(array $data) {
        $query = $lastId = null;
        if(isset($data[0])) {
            foreach ($data as $datum) {
                $query[] = $this->performInsert($this->table, $datum);
                $lastId[] = $this->db->lastInsertId();
            }
        }else {
            $query = $this->performInsert($this->table, $data);
            $lastId = $this->db->lastInsertId();
        }
        return $lastId ? $lastId : null;
    }

    public function update(array $data) {
        $rowCount = null;
        $query = $this->performUpdate($this->table, $data);
        $rowCount = $query->rowCount();

        return $rowCount;
    }

    private function performUpdate(string $table, array $data) {
        $attributes = '';
        $where = null;
        $params = [];
        foreach($data as $column => $value) {
            $attributes .= '`' . $column . '` = ?, ';
            $params[] = $value;
        }
        if($this->where == '') {
            $where = 1;
        }else {
            foreach ($this->params as $param) {
                $params[] = $param;
                $where = $this->where;
            }
        }
        $attributes = rtrim($attributes, ', ');
        $this->params = $params;

        $this->sql = "UPDATE {$table} SET {$attributes} WHERE {$where}";
//        dnd($this->sql);
        return $this->query();
    }

    private function performInsert(string $table, array $data) {

        $sqlArray = $this->performBinding($data);

        $attributes = $sqlArray['attributes'];
        $params = $sqlArray['params'];
        $this->params = $sqlArray['values'];

        $this->sql = "INSERT INTO {$table} ({$attributes}) VALUES ({$params})";
        return $this->query();
    }

    private function performBinding(array $data) : array {
        $attributes = '';
        $params = '';
        $values = [];

        foreach($data as $column => $value) {
            $attributes .= '`' . $column . '`, ';
            $params .= '?, ';
            $values[] = $value;
        }
        $attributes = rtrim($attributes, ', ');
        $params = rtrim($params, ', ');

        
        return ['attributes' => $attributes, 'params' => $params, 'values' => $values];
    }

    public function query() {
        if($query = $this->db->prepare($this->sql)) {

            if($query->execute($this->params)) {
                return $query;
            }
        }
        return false;
    }

    public function getPrimaryKey()
    {
        $this->sql = "SELECT GROUP_CONCAT(COLUMN_NAME) AS primary_key FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = '".
            DB_NAME .
            "' AND CONSTRAINT_NAME='PRIMARY' AND TABLE_NAME = '"
            . $this->table. "'";

        return $this->query()->fetch(PDO::FETCH_OBJ)->primary_key;
    }

    public function create($id = 'id', $type = 'INT', $auto = true)
    {
        try {
            $auto_inc = (trim($type) == 'INT NOT NULL' && $auto) ? $auto_inc = 'AUTO_INCREMENT' : '';
            $this->sql = "CREATE TABLE IF NOT EXISTS " .
                "{$this->table} ({$id} {$type} {$auto_inc} , "
                . "PRIMARY KEY ({$id}))  ENGINE=INNODB;";
            $this->query();
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public function remove()
    {
        if($this->index != '') {
            $this->sql = "ALTER TABLE `{$this->table}` DROP INDEX `{$this->index}`;";

        }else if($this->column != '') {
            $this->sql = "ALTER TABLE {$this->table} DROP COLUMN {$this->column};";

        } else {
            $this->sql = "DROP TABLE IF EXISTS {$this->table}";
        }
        return $this->query();
    }

    public function column($column, $attributes = [])
    {
        $this->column = $column;
        $this->attributes =  $attributes;

        return $this;
    }

    public function add()
    {
        $this->sql = "ALTER TABLE `{$this->table}` ";
        if($this->referenceAttrs != ''){
            $this->sql = "ALTER TABLE `{$this->table}`  ADD `{$this->column}` {$this->attributes},  ADD INDEX (`{$this->column}`);";
            $this->query();
            $this->sql = "ALTER TABLE `{$this->table}`  ADD FOREIGN KEY (`{$this->column}`) {$this->referenceAttrs};";
        }else {
            $both = ($this->attributes != '' & $this->index != '') ? $both = ',' : '';
            if ($this->attributes != '') {
                $this->sql .= " ADD `{$this->column}` {$this->attributes}" . $both;
            }
            if ($this->index != '') {
                $this->sql .= " ADD INDEX (`{$this->index}`)";
            }
        }
        return $this->query();
    }

    public function index($column)
    {
        $this->index = $column;
        return $this;
    }

    public function foreignKey($referenceAttrs)
    {
        $this->referenceAttrs = $referenceAttrs;
        return $this;
    }
}

/**
 * ALTER TABLE `test_student` ADD INDEX(`subjects`);"?
 * `ALTER TABLE ``test_student`` DROP INDEX ``student_id``;`
 * ALTER TABLE `test_student` CHANGE `id` `user_id` VARCHAR(16) NOT NULL;
 * ALTER TABLE `test_student` CHANGE `id` `user_id` INT(11) NOT NULL AUTO_INCREMENT;
 *
 * ALTER TABLE `test_student` ADD `subjects` INT NOT NULL AFTER `student_id`, ADD PRIMARY KEY (`subjects`);
 * ALTER TABLE `test_student` ADD `subjects` INT NOT NULL AFTER `student_id`, ADD UNIQUE `unique` (`subjects`);
 * ALTER TABLE `test_student` ADD `subjects` INT NOT NULL AFTER `student_id`, ADD INDEX (`subjects`);
 * ALTER TABLE `test_student` ADD `subjects` INT NOT NULL AFTER `student_id`;
 * ALTER TABLE `test_student` ADD `subjects` VARCHAR(16) NOT NULL AFTER `student_id`;
 *
 * ALTER TABLE `test_student` ADD `subjects` INT NOT NULL AUTO_INCREMENT AFTER `student_id`, ADD PRIMARY KEY (`subjects`);
 */