<?php

namespace App\Pipelines\Sales;

use Closure;
use Illuminate\Support\Facades\Log;

class SendSunat
{
  public function __invoke($saleData, Closure $next)
  {
    Log::info('Enviando a sunat');
    return $next($saleData);
  }
}
