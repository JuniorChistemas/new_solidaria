<?php

namespace App\Pipelines\Sales;

use Closure;
use Illuminate\Support\Facades\Auth;

class ValidateStock
{

  public function __invoke($saleData, Closure $next)
  {
    $localId = Auth::user()->local_id ?? 1;
  }
}
