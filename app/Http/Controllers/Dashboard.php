<?php

namespace App\Http\Controllers;

use App\Models\Local;
use Illuminate\Http\Request;
use Inertia\Inertia;

class Dashboard extends Controller
{
    public function index()
    {
        $locales = Local::withCount(['users', 'guidesOrigin', 'guidesDestination', 'sales'])->get();

        $data = $locales->map(function ($local) {
            return [
                'local' => $local->only(['id', 'name']),
                'total_users' => $local->users_count,
                'total_guias_enviadas' => $local->guides_origin_count,
                'total_guias_recibidas' => $local->guides_destination_count,
                'total_ventas' => $local->sales_count,
            ];
        });

        return Inertia::render('Dashboard', [
            'locales' => $data,
        ]);
    }
}
