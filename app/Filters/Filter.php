<?php

namespace App\Filters;

use DeepCopy\Exception\PropertyException;
use Exception;
use Illuminate\Http\Request;

abstract class Filter
{
  protected array $allowedOperatorsFields = [];

  protected array $transalateOperatorsFields = [
    'gt' => '>',
    'gte' => '>=',
    'lt' => '<',
    'lte' => '<=',
    'eq' => '=',
    'ne' => '!=',
    'in' => 'in',
  ];

  public function filter(Request $request)
  {
    $where = [];
    $whereIn = [];

    if (empty($this->allowedOperatorsFields)) {
      throw new PropertyException("Property allowedOperatorsfields is empty");
    }

    foreach ($this->allowedOperatorsFields as $param => $operators) {
      $queryOperator = $request->query($param);
      if ($queryOperator) {
        foreach ($queryOperator as $operator => $value) {
          if (!in_array($operator, $operators)) {
            throw new Exception("{$param} does not have {$operator} operator");
          }

          if (str_contains($value, '[')) {
            $whereIn[] = [
              $param,
              explode(',', str_replace(['[', ']'], ['', ''], $value)),
              $value
            ];
          } else {
            $where[] = [
              $param,
              $this->transalateOperatorsFields[$operator],
              $value
            ];
          }
        }
      }
    }

    if (empty($where) && empty($whereIn)) {
      return [];
    }

    return [
      'where' => $where,
      'whereIn' => $whereIn
    ];
  }
}
