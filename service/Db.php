<?php

namespace app\service;
use app\traits\Tsingletone;

class Db
{
    use Tsingletone;
    private $connect = null;
    private $config =
        [
            'mysql'   => 'mysql',
            'host'    => 'localhost:3308',
            'dbname'  => 'example',
            'user'    => 'root',
            'pass'    => '',
            'charset' => 'utf8',
        ];

    public function getConnection()
    {
        if ($this->connect === null) {
            $this->connect = new \PDO(
                $this->prepareDnsString(),
                $this->config['user'],
                $this->config['pass']);
        }
        $this->connect->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        $this->connect->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        return $this->connect;
    }

    private function prepareDnsString()
    {
        return sprintf('%s:host=%s;dbname=%s;charset=%s',
            $this->config['mysql'],
            $this->config['host'],
            $this->config['dbname'],
            $this->config['charset']
        );
    }

    private function query($sql, $param = [])
    {
        $stmn = $this->getConnection()->prepare($sql);
        $stmn->execute($param);
        return $stmn;
    }

    public function queryOneObject($sql, $param, $class)
    {
        $stmn = $this->query($sql, $param);
        $stmn->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $class);
        return $stmn->fetch();
    }

    public function queryAll($sql, $param = [])
    {
        $stmn = $this->query($sql, $param);
        return $stmn->fetchAll();
    }

    public function execute($sql, $params)
    {
        $this->query($sql, $params);
        return true;
    }

    public function lastInsertId()
    {
        return $this->getConnection()->lastInsertId();
    }
}