<?php

namespace App\Http\Controllers\Inputs;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Laboratory;
use Illuminate\Http\Request;

class SelectController extends Controller
{
    // get laboratory list
    public function getLaboratoryList(){
        $laboratory = Laboratory::select('id', 'name')
            ->orderBy('id')
            ->get();
        return response()->json($laboratory);
    }
    // get category list
    public function getCategoryList(){
        $category = Category::select('id', 'name')
            ->orderBy('id')
            ->get();
        return response()->json($category);
    }
}

