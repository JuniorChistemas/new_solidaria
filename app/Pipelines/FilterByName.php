<?php

namespace App\Pipelines;
use Closure;
use Illuminate\Database\Eloquent\Builder;

class FilterByName
{
  public function __construct(private ?string $name) {}
  public function __invoke(Builder $builder, Closure $next)
  {
    if (!$this->name) {
      return $next($builder);
    }
    $builder->whereLike('name', "%$this->name%");
    return $next($builder);
  }
}
