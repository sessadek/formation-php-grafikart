<?php

namespace App;

use PDO;

class QueryBuilder {
    
    private $select;

    private string $from;

    private array $orderBy = [];

    private int $limit;

    private int $offset;

    private int $page;

    private string $where;

    private $fetch;

    private $params;

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

    public function setParam($key, $value): self
    {
        $this->params[$key] = $value;
        return $this; 
    }

    public function select(...$params) {
        foreach($params as $param) {
            if(is_array($param)) {
                $this->select[] = implode(', ', $param);
            } else {
                $this->select[] = $param;
            }
        }
        return $this;
    }

    public function fetch(PDO $pdo, string $key): ?string {
        $query = $pdo->prepare($this->toSQL());
        $query->execute($this->params);
        $result = $query->fetch();
        if($result === false) {
            return null;
        }
        return $result[$key] ?? null;
    }

    public function count(PDO $pdo) {
        $query = clone $this;
        return (int)$query->select('COUNT(id) count')->fetch($pdo, 'count');
    }



    public function toSQL() {
        
        $this->select = !empty($this->select) ? implode(', ', $this->select) : "*";

        $sql = !empty($this->fetch) ? "SELECT {$this->fetch} FROM {$this->from}" : "SELECT {$this->select} FROM {$this->from}";
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