<?php

namespace App;

use Exception;
use PDO;

class QueryBuilder {
    
    private $select = ['*'];

    private string $from;

    private array $orderBy = [];

    private int $limit;

    private int $offset;

    private int $page;

    private string $where;

    private $fetch;

    private $params = [];

    private $pdo;

    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo;
    }

    public function from (string $table, string $alias = null): self
    {
        $this->from = is_null($alias) ? "$table" : "$table $alias";
        return $this;
    }

    public function orderBy(string $key, string $sort): self
    {
        $sort = strtoupper($sort);
        if(!in_array($sort, ['ASC', 'DESC'])) {
            $this->orderBy[] = $key;
        } else {
            $this->orderBy[] = "$key $sort";
        }
        return $this;
    }

    public function limit(int $limit): self
    {
        $this->limit = $limit;
        return $this; 
    }

    public function offset(int $offset): self
    {
        if(is_null($this->limit)) {
            throw new Exception('Impossible de définir un offset sans définir limit');
        }
        $this->offset = $offset;
        return $this;
    }

    public function page(int $page): self
    {
        $this->page = $page;
        return $this; 
    }

    public function where(string $where): self
    {
        $this->where = $where;
        return $this; 
    }

    public function setParam(string $key, $value): self
    {
        $this->params[$key] = $value;
        return $this; 
    }

    public function select(...$params): self {
        if(is_array($params[0])) {
            $params = $params[0];
        }
        if($this->select === ['*']) {
            $this->select = $params;
        } else {
            $this->select = array_merge($this->select, $params);
        }
        return $this;
    }

    public function fetch(string $key): ?string {
        $query = $this->pdo->prepare($this->toSQL());
        $query->execute($this->params);
        $result = $query->fetch();
        if($result === false) {
            return null;
        }
        return $result[$key] ?? null;
    }

    public function fetchAll(): array {
        try {
            $query = $this->pdo->prepare($this->toSQL());
            $query->execute($this->params);
            $result = $query->fetchAll();
            return $result;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function count() {
        $query = clone $this;
        return (int)$query->select('COUNT(id) count')->fetch('count');
    }



    public function toSQL() {

        $sql = !empty($this->fetch) ? "SELECT {$this->fetch} FROM {$this->from}" : "SELECT " . implode(', ', $this->select) . " FROM {$this->from}";
        // $sql = "SELECT {$this->select} FROM {$this->from}";
        if(!empty($this->where)) {
            $sql .= " WHERE {$this->where}";
        }
        if(!empty($this->orderBy)) {
            $sql .= " ORDER BY " . implode(', ', $this->orderBy);
        }
        if(!empty($this->limit)) {
            $sql .= " LIMIT " . $this->limit;
        }

        if(!empty($this->offset)) {
            $sql .= " OFFSET " . $this->offset;
        }

        if(!empty($this->page)) {
            $offset = ($this->page - 1) * $this->limit;
            $sql .= " OFFSET " . $offset;
        }
        return $sql;
    }
}