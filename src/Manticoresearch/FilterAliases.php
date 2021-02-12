<?php


namespace Manticoresearch;

/**
 * Trait FilterAliases
 * @package Manticoresearch
 *
 * @mixin Search
 */
trait FilterAliases
{
    protected static $replaceOperator = [
        '=' => '',
        '>=' => 'gte',
        '>' => 'gt',
        '<' => 'lt',
        '<=' => 'lte',
    ];

    public function where($attr, $op, $value = null, $boolean = 'AND'): self
    {
        if (is_null($value)) {
            $value = $op;
            $op = '=';
        }

        $op = self::$replaceOperator[$op] ?? '';

        if ($boolean === 'OR') {
            return $this->orFilter($attr, $op, $value);
        }

        return $this->filter($attr, $op, $value);
    }

    public function orWhere($attr, $op, $value = null): self
    {
        return $this->where($attr, $op, $value = null);
    }

    public function whereNot($attr, $op, $value = null): self
    {
        return $this->where($attr, $op, $value = null);
    }

    public function whereIn($attr, array $values, $boolean = 'AND'): self
    {
        if ($boolean === 'OR') {
            return $this->orFilter($attr, 'in', $values);
        }

        return $this->filter($attr, 'in', $values);
    }

    public function orWhereIn($attr, array $values): self
    {
        return $this->whereIn($attr, $values, 'OR');
    }
}