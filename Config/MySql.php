<?php

namespace Config;

use Config\Interfaces\IQueryBuilder;
use Exception;
use stdClass;

class MySql extends Connection implements IQueryBuilder{

    protected $query;

    public function reset(): void{
        $this->query = new stdClass();
    }

    public function select(string $table, array $fields = ['*']): IQueryBuilder
    {
        $this->reset();
        $this->query->base = "SELECT ".implode(", ", $fields)." FROM ".$table;
        $this->query->type = 'select';
        
        return $this;
    }

    public function where(string $field, string $value, string $operator = "="): IQueryBuilder{
        if(!in_array($this->query->type, ['select', 'update', 'delete'])){
            throw new Exception("WHERE solo puede ser agregado a SELECT, UPDATE, DELETE");
        }
        $this->query->where[] = "$field $operator '$value'";

        return $this;
    }

    public function orWhere(string $field, string $value, string $operator = "="): IQueryBuilder{
        if(!in_array($this->query->type, ['select', 'update', 'delete'])){
            throw new Exception("WHERE solo puede ser agregado a SELECT, UPDATE, DELETE");
        }
        $this->query->orWhere[] = "$field $operator '$value'";

        return $this;
    }

    public function isNull(string $field): IQueryBuilder{
        if(!in_array($this->query->type, ['select'])){
            throw new Exception("Error Processing Request", 1);
        }

        $this->query->where[] = "$field IS NULL";
        return $this;
    }

    public function isNotNull(string $field): IQueryBuilder {
        if(!in_array($this->query->type, ['select'])){
            throw new Exception("Error Processing Request", 1);
        }
        $this->query->where[] = "$field IS NOT NULL";
        
        return $this;
    }

    public function join(string $table, string $field_1, string $field_2): IQueryBuilder{
        if(!in_array($this->query->type, ['select'])){
            throw new Exception("Error Processing Request", 1);
        }
        $this->query->inner[] = "$table ON $field_1 = $field_2";

        return $this;
    }

    public function leftJoin(string $table, string $field_1, string $field_2): IQueryBuilder{
        if(!in_array($this->query->type, ['select'])){
            throw new Exception("Error Processing Request", 1);
        }
        $this->query->left[] = "$table ON $field_1 = $field_2";

        return $this;
    }

    public function limit(int $start, int $offset): IQueryBuilder
    {
        if(!in_array($this->query->type, ['select'])){
            throw new Exception("LIMIT solo puede ser agregdo a SELECT");
        }
        $this->query->limit = " LIMIT ".$start.", ".$offset;

        return $this;
    }

    public function order(string $field, string $type): IQueryBuilder
    {
        return $this;
    }

    public function getSQL(): string
    {
        $query = $this->query;
        $sql = $this->query->base;
        if(isset($query->inner)){
            $sql .= " INNER JOIN ".implode(' INNER JOIN ', $query->inner);
        }
        if(isset($query->left)){
            $sql .= " LEFT JOIN ".implode(' LEFT JOIN ', $query->left);
        }
        if(!empty($query->where)){
            if(str_contains($sql, 'WHERE')){
                $sql .= " AND ".implode(' AND ', $query->where);
            }else{
                $sql .= " WHERE ".implode(' AND ', $query->where);
            }
        }
        if(!empty($query->orWhere)){
            if(str_contains($sql, 'WHERE')){
                $sql .= " OR ".implode(' OR ', $query->orWhere);
            }else{
                $sql .= " WHERE ".implode(' OR ', $query->orWhere);
            }
        }
        if(isset($query->limit)){
            $sql .= $query->limit;
        }
        return $sql;
    }

    public function exec(){
        $sql = $this->getSQL();
        $data = $this->getData($sql);
        return $data;
    }

    public function first()
    {
        $sql = $this->getSQL();
        $data = $this->getSingle($sql);
        return $data;
    }

    

}