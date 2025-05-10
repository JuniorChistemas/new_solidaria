<?php

namespace App\Pipelines\Guides;

use App\Models\Guide;
use Closure;
use Illuminate\Support\Facades\Log;

class CreateGuide
{
  public function __invoke($guideData, Closure $next)
  {
    // create a new guide
    $guide = Guide::create([
      'origin_local_id' => $guideData['origin_local_id'],
      'destination_local_id' => $guideData['destination_local_id'],
      'type_movement_id' => $guideData['type_movement_id'],
      'code' => $guideData['code'],
      'status' => $guideData['status'],
      'sent_at' => $guideData['sent_at'],
    ]);
    // // add guide al request    
    $guideData['guide_model'] = $guide;
    Log::info('CreateGuide pipeline started');
    return $next($guideData);
  }
}
