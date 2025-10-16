<?php

namespace App\Http\Controllers;

use App\Models\Bicycle;
use Illuminate\Http\Request;

class BicycleController extends Controller
{
    public function index()
    {
        $bicycle = Bicycle::all();

        return response()->json([
            'message' => 'LISTA DE BICICLETAS',
            'data' => $bicycle
        ]);
    }
}

