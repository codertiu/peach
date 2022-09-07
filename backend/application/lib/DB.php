<?php

namespace application\lib;

use PDO;

class DB
{
    protected $db;

    public function __construct()
    {
        $config = require 'application/config/database.php';
        foreach ($config[SHAFTOLI_DB] as $key => $val) {
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
    }

    public function query($sql, $params = [])
    {
        $stmt = $this->db->prepare($sql);
        if (!empty($params)) {
            foreach ($params as $key => $val) {
                $stmt->bindValue(':'.$key, $val);
            }
        }
        $stmt->execute();
        return $stmt;
    }

    public function rows($sql, $params = [])
    {
        $result = $this->query($sql, $params);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function column($sql, $params = [])
    {
        $result = $this->query($sql, $params);
        return $result->fetchColumn();
    }
}