<?php

namespace App\Table;

use PDO;
use App\Connection;

abstract class Table {

    protected $className = null;

    protected $table = null;

    /**
     * Undocumented variable
     *
     * @var PDO
     */
    protected $pdo;

    public function __construct()
    {
        $this->pdo = Connection::getPDO();
        if(is_null($this->className)) {
            throw new \Exception("the class Name is null");
        }
        if(is_null($this->table)) {
            throw new \Exception("the table is null");
        }
    }

    /**
     * Undocumented function
     *
     * @param integer $id
     */
    public function find (int $id) {
        $tableParts = explode("\\", get_called_class());
        $tableName = str_replace('Table', '', end($tableParts));
        if(is_null($this->className)) {
            $this->className = '\\App\\Model\\' . $tableName;
        }
        if(is_null($this->table)) {
            $this->table = strtolower($tableName);
        }
        $query = $this->pdo->prepare("SELECT * FROM " . $this->table . " WHERE id = :id");
        $query->execute(['id' => $id]);
        $query->setFetchMode(PDO::FETCH_CLASS, $this->className);
        $result = $query->fetch();
        
        if($result === false) {
            throw new \Exception("Aucun catégorie ne correspond à cet $id sur la class " . $tableName);
        }
        return $result;
    }

    /**
     * Undocumented function
     *
     * @param string $field
     * @param mixed $value
     * @return boolean
     */
    public function exists (string $field, mixed $value, ?int $except = null): bool
    {
        $sql = "SELECT COUNT(id) FROM {$this->table} WHERE {$field} = ?";
        $params = [$value];
        if(!is_null($except)) {
            $sql .= " AND id != ?";
            $params[] = $except;
        }
        $query = $this->pdo->prepare($sql);
        $query->execute($params);
        return (int)$query->fetch(\PDO::FETCH_NUM)[0] > 0;
    }
}