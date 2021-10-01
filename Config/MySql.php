<?php

namespace Config;

use Config\Interfaces\IQueryBuilder;
use Exception;
use stdClass;

class MySql implements IQueryBuilder{

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
        $this->query->where[] = "$field $operator $value";

        return $this;
    }

    public function join(string $table, string $field_1, string $field_2): IQueryBuilder{
        if(!in_array($this->query->type, ['select'])){
            throw new Exception("Error Processing Request", 1);
        }
        $this->query->inner[] = "$table ON $field_1 = $field_2";

        return $this;
    }

}