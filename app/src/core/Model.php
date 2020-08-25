<?php
/**
 *Description: ...
 *Created by: Isaac
 *Date: 7/24/2020
 *Time: 9:10 AM
 */

namespace Zikzay\Core;


use stdClass;
use Zikzay\Database\Database;
use Zikzay\Lib\Util;

abstract class Model
{
    use DatabaseFields;

    protected static $connection;

    protected static $table;

    private static $model;

    public static $data;

    protected static $primaryKey = 'id';

    protected static $keyType = 'int';

    public $created_at;

    public $updated_at;

    public function __construct()
    {
        self::$connection = Database::dbInstance();
        self::$table  = $this->model();
        self::$model = get_class($this);

    }

    private function model()
    {
        $model = get_class($this);

        return Util::objectToSnakeCase($model);
    }

    private static function columns($columns)
    {
       if(empty($columns)) {
           $obj = get_object_vars(new self::$model);
           $obj[self::$primaryKey] = null;

           $columns = array_keys($obj);
       }

       return $columns;
    }

    public static abstract function define(stdClass $field) : stdClass;

    public static function object($id)
    {
        return self::$connection
            ->table(self::$table)
            ->where(self::$primaryKey, $id)
            ->get('class', self::$model);
    }

    public static function all($columns = [])
    {
        return self::$connection
            ->table(self::$table)
            ->select(self::columns($columns))
            ->getAll();
    }

    public static function first($columns = [])
    {
        return self::$connection
            ->table(self::$table)
            ->select(self::columns($columns))
            ->get();
    }

    public static function last($columns = [])
    {
        return self::$connection
            ->table(self::$table)
            ->select(self::columns($columns))
            ->order(1, 'DESC')
            ->get();
    }

    public static function search($filed, $search, $columns = [])
    {
        $search = is_array($search) ? $search[array_key_first($search)] : $search;
        $clause = "$filed = '{$search}'";
        return self::$connection
            ->table(self::$table)
            ->select(self::columns($columns))
            ->where($clause)
            ->get();
    }

    public static function searchOR($filed, $search, $columns = [])
    {
        $search = is_array($search) ? $search[array_key_first($search)] : $search;
        $clause = is_array($filed) ? implode(" = '{$search}' OR ", $filed) . " = '{$search}'" : '';
        return self::$connection
            ->table(self::$table)
            ->select(self::columns($columns))
            ->where($clause)
            ->get();
    }

    public static function searchAnd($filed, $search, $columns = [])
    {
        $search = is_array($search) ? $search[array_key_first($search)] : $search;
        $clause = is_array($filed) ? implode(" = '{$search}' AND ", $filed) . " = '{$search}'" : '';

        return self::$connection
            ->table(self::$table)
            ->select(self::columns($columns))
            ->where($clause)
            ->get();
    }

    public static function find($search, $columns = [])
    {
        $id = self::$primaryKey;
        $search = is_array($search) ? $search[array_key_first($search)] : $search;
        $clause = "{$id} = '{$search}' OR  ";
        $clause .= implode(" = '{$search}' OR ", self::columns('')) . " = '{$search}'";
        return self::$connection
            ->table(self::$table)
            ->select(self::columns($columns))
            ->where($clause)
            ->get();
    }

    public static function findAll($search, $columns = [])
    {
        $clause = is_array($search) ? $search :
            implode(" = '{$search}' OR ", self::columns('')) . " = '{$search}'";

        return self::$connection
            ->table(self::$table)
            ->select(self::columns($columns))
            ->where($clause)
            ->getAll();
    }

    public static function count($where = '')
    {
        return self::$connection
            ->table(self::$table)
            ->where($where)
            ->count();
    }

    public function save() {
        return self::$connection
            ->table(self::$table)
            ->insert(self::$data);
    }

    protected function insert() {
        return self::$connection
            ->table(self::$table)
            ->insert(self::$data);
    }
    public function update(array $where)
    {
        return self::$connection
            ->table(self::$table)
            ->where($where)
            ->update(self::$data);
    }
    public function createUser() {
        return self::$connection
            ->table(self::$table)
            ->insert(self::$data);
    }










}

































































