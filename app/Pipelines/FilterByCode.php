<?php

namespace App\Pipelines;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class FilterByCode
{
  public function __construct(private ?string $code) {}


  public function __invoke(Builder $builder, Closure $next)
  {
    if (!$this->code) {
      return $next($builder);
    }
    $builder->whereLike('code', "$this->code%");
    return $next($builder);
  }
}
