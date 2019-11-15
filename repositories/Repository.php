<?php

namespace app\repositories;

use app\service\Db;

abstract class Repository
{

    protected $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    public function getOne($id)
    {
        $tableName = $this->tableName();
        $sql = "SELECT * FROM {$tableName} WHERE id= :id";
        return $this->db->queryOneObject($sql, ['id' => $id], get_called_class());
    }

    public function getAll()
    {
        $tableName = $this->tableName();
        $sql = "SELECT * FROM {$tableName}";
        return $this->db->queryAll($sql);
    }

    public function delete()
    {
        $tableName = $this->tableName();
        $sql = "DELETE FROM {$tableName} WHERE `id` = :id";
        $this->db->execute($sql, [':id' => $this->id]);
    }

    public function safe()
    {
        if ($this->id === null) {
            $this->insert();
            return;
        }
        $this->update();

    }

    protected function insert()
    {
        $param = [];
        $content = [];
        foreach ($this as $key => $value) {
            if ($key === 'db' || $key === 'id') {
                continue;
            }
            $param[":{$key}"] = $value;
            $content[] = "`$key`";
        }
        $paramName = implode(", ", $content);
        $valueName = implode(", ", array_keys($param));
        $tableName = $this->tableName();
        $sql = "INSERT INTO {$tableName} ({$paramName}) VALUES ({$valueName})";
        $this->db->execute($sql, $param);
        $this->id = $this->db->lastInsertId();

    }

    protected function update()
    {
        $param = [];
        $content = [];
        foreach ($this as $key => $value) {
            if ($key === 'db' || $key === 'id') {
                continue;
            }
            $param[":{$key}"] = $value;
            $content[] = "`$key`= :$key";

        }
        $paramName = implode(", ", $content);
        $tableName = $this->tableName();
        $sql = "UPDATE {$tableName} SET {$paramName} WHERE `id`={$this->id}";
        $this->db->execute($sql, $param);
    }

    public function getLimit($from, $limit)
    {
        $tableName = $this->tableName();
        $sql = "SELECT * FROM {$tableName} LIMIT :from, :limit";
        return $this->db->queryAll($sql, [':from' => $from, ':limit' => $limit]);
    }

    abstract function tableName();
}