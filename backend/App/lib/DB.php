<?php

namespace App\lib;

use PDO;

/****
 * $pdo = new PDO($dsn, $user, $password);
 * $db = new Db($pdo);
 *
 * // Выборка одного значения
 * $count = $db->queryValue('SELECT COUNT(*) FROM users');
 *
 * // Выборка набора записей
 * $users = $db->queryRows('SELECT * FROM users WHERE name LIKE ?', array('%username%'));
 *
 * // Выборка одной записи
 * $user = $db->queryRow('SELECT * FROM users WHERE id=:id', array(':id' => 123));
 *
 * // Добавление записи (INSERT) и получение значения поля AUTO_INCREMENT
 * $newUserId = $db->insert('users', array('name' => 'NewUserName', 'password' => 'zzxxcc'));
 *
 * // Изменение записи (UPDATE)
 * $db->update('users', array('name' => 'UpdatedName'), 'id=:id', array(':id' => $newUserId));
 ***/
class DB
{

    protected $db;

    public function __construct($file = null)
    {

//        if(empty(self::$pdo)){
//            self::connect();
//        }

        try {
            $config = require realpath(dirname(__FILE__) . '/../../config/database.php');

            foreach ($config[DBI] as $key => $val) {
                if (is_int($key)) {
                    $dsn[] = $val;
                } else {
                    $auth[$key] = $val;
                }
            }
            $user = null;
            $pass = null;
            isset($auth) ? extract($auth) : null;
            $this->db = new PDO(implode(';', $dsn), $user, $pass);
        } catch (\PDOException $e){
            return $e->getMessage();
        }
    }

//    static public function connect(){
//
//    }


    public function insert($table, $fields, $insertParams = null)
    {
        try
        {
            $result = null;
            $names = '';
            $vals = '';

            foreach ($fields as $name => $val)
            {
                if (isset($names[0])) {
                    $names .= ', ';
                    $vals .= ', ';
                }
                $names .= $name;
                $vals .= ':' . $name;
            }

            $ignore = isset($insertParams['ignore']) && $insertParams['ignore']? 'IGNORE': '';

            $sql = "INSERT $ignore INTO " . $table . ' (' . $names . ') VALUES (' . $vals . ')';

            $rs = $this->db->prepare($sql);

            foreach ($fields as $name => $val)
            {
                $rs->bindValue(':' . $name, $val);
            }

            if ($rs->execute())
            {
                $result = $this->db->lastInsertId(null);
            }

            return $result;
        }
        catch(Exception $e)
        {
            $this->report($e);
        }
    }

    // Returns true/false
    public function update($table, $fields, $where, $params = null)
    {
        try
        {
            $sql = 'UPDATE ' . $table . ' SET ';
            $first = true;

            foreach (array_keys($fields) as $name)
            {
                if (!$first)
                {
                    $first = false;
                    $sql .= ', ';
                }

                $first = false;
                $sql .= $name . ' = :_' . $name;
            }

            if (!is_array($params))
            {
                $params = array();
            }

            $sql .= ' WHERE ' . $where;
            $rs = $this->db->prepare($sql);

            foreach ($fields as $name => $val)
            {
                $params[':_' . $name] = $val;
            }

            $result = $rs->execute($params);

            return $result;
        }
        catch(Exception $e)
        {
            $this->report($e);
        }
    }

    public function queryValue($query, $params = null)
    {
        try
        {
            $result = null;
            $stmt = $this->db->prepare($query);

            if ($stmt->execute($params))
            {
                $result = $stmt->fetchColumn();
                $stmt->closeCursor();
            }

            return $result;
        }
        catch(Exception $e)
        {
            $this->report($e);
        }
    }

    public function queryValues($query, $params = null)
    {
        try
        {
            $result = null;
            $stmt = $this->db->prepare($query);

            if ($stmt->execute($params))
            {
                $result = array();

                while ($row = $stmt->fetch(PDO::FETCH_NUM))
                {
                    $result[] = $row[0];
                }
            }
            return $result;
        }
        catch(Exception $e)
        {
            $this->report($e);
        }
    }


    public function queryRow($query, $params = null, $fetchStyle = PDO::FETCH_ASSOC, $classname = null)
    {
        $rows = $this->queryRowOrRows(true, $query, $params, $fetchStyle, $classname);

        return $rows;
    }


    public function queryRows($query, $params = null, $fetchStyle = PDO::FETCH_ASSOC, $classname = null)
    {
        $rows = $this->queryRowOrRows(false, $query, $params, $fetchStyle, $classname);

        return $rows;
    }


    private function queryRowOrRows($singleRow, $query, $params = null, $fetchStyle = PDO::FETCH_ASSOC, $classname = null)
    {
        try
        {

            $result = null;
            $stmt = $this->db->prepare($query);

            if($classname)
            {
                $stmt->setFetchMode($fetchStyle, $classname);
            }
            else
            {
                $stmt->setFetchMode($fetchStyle);
            }

            if ($stmt->execute($params))
            {
                $result = $singleRow? $stmt->fetch(): $stmt->fetchAll();
                $stmt->closeCursor();
            }

            return $result;
        }
        catch(Exception $e)
        {
            $this->report($e);
        }
    }


    public function quote($str)
    {
        return $this->db->quote($str);
    }


    public function quoteArray($arr)
    {
        $result = array();

        foreach ($arr as $val)
        {
            $result[] = $this->db->quote($val);
        }

        return $result;
    }


    public function quoteImplodeArray($arr)
    {
        return implode(',', $this->quoteArray($arr));
    }


    // returns true/false
    public function sql($query, $params = null)
    {
        try
        {
            $result = null;
            $stmt = $this->db->prepare($query);
            return $stmt->execute($params);
        }
        catch(Exception $e)
        {
            $this->report($e);
        }
    }

    public function query($sql, $params){
        return $this->sql($sql, $params);
    }


    private function report($e)
    {
        throw $e;
    }

    public function exec($query)
    {
        try
        {
            return $this->db->exec($query);
        }
        catch(Exception $e)
        {
            $this->report($e);
        }
    }


}

