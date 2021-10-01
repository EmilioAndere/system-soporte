<?php

namespace Config\Interfaces;

interface IQueryBuilder{

    public function select(string $table, array $fields = ['*']): IQueryBuilder;
    public function where(string $field, string $value, string $operator = "="): IQueryBuilder;
    public function join(string $table, string $field_1, string $field_2): IQueryBuilder;

}