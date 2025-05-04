<?php

namespace App\Http\Controllers\Inputs;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Laboratory;
use App\Models\Product;
use App\Models\Local;
use App\Models\Supplier;
use App\Models\TypeMovement;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class SelectController extends Controller
{
    // get laboratory list
    public function getLaboratoryList()
    {
        $laboratory = Laboratory::select('id', 'name')
            ->orderBy('id')
            ->get();
        return response()->json($laboratory);
    }
    // get category list
    public function getCategoryList()
    {
        $category = Category::select('id', 'name')
            ->orderBy('id')
            ->get();
        return response()->json($category);
    }
          // Obtener lista de productos
          public function getProductList()
          {
              $users = Product::select('id', 'name')
                  ->orderBy('name')
                  ->get();
              return response()->json($users);
          }

    // Obtener lista de proveedores
    public function getSuppliers()
    {
        $suppliers = Supplier::select('id', 'name')
            ->orderBy('name')
            ->get();
        return response()->json($suppliers);
    }

    // Obtener lista de usuarios
    public function getUsers()
    {
        $users = User::select('id', 'name')
            ->where('status', 1)
            ->orderBy('name')
            ->get();
        return response()->json($users);
    }

    // Obtener tipos de movimiento
    public function getMovementTypes()
    {
        $types = TypeMovement::select('id', 'nombre')
            ->orderBy('nombre')
            ->get();
        return response()->json($types);
    }

    public function getLocalList()
    {
        $local = Local::select('id', 'name')
            ->where('status', 1)
            ->orderBy('id')
            ->get();
        return response()->json($local);
    }

    public function getRoleList()
    {
        $roles = Role::select('id', 'name')
            ->orderBy('id')
            ->get();
        return response()->json($roles);
    }
}
