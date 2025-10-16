<?php

namespace App\Http\Controllers;

use App\Models\Alquiler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AlquilerController extends Controller
{
    public function index()
    {
        $alquiler = Alquiler::all();

        if ($alquiler->isEmpty()) {
            return response()->json([
                'message' => 'No hay alquileres por el momento'
            ]);
        }

        return response()->json([
            'message' => 'Alquileres',
            'data' => $alquiler
        ]);
    }

    public function store(Request $request)
    {

        $validador = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'bicycle_id' => 'required|exists:bicycles,id',
            'direccion_id' => 'required|exists:direcciones,id',
            'start_time' => 'required|date|before_or_equal:2025-10-14',
            'end_time' => 'required|date|after:start_time',
            'valor_principal' => 'required|numeric|min:1000|max:5000',
            'valor_adicional' => 'required|numeric|min:1000',
            'valor_total' => 'required|numeric',
            'metodo_pago' => 'required|in:Efectivo,Transferencia,Tarjeta'
        ]);

        if ($validador->fails()) {
            return response()->json([
                'errros' => $validador->errors()
            ]);
        }

        $alquiler = Alquiler::create([
            'user_id' => $request->user_id,
            'bicycle_id' => $request->bicycle_id,
            'direccion_id' => $request->direccion_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'valor_principal' => $request->valor_principal,
            'valor_adicional' => $request->valor_adicional,
            'valor_total' => $request->valor_total,
            'metodo_pago' => $request->metodo_pago
        ]);

        return response()->json([
            'message' => 'Alquiler exitoso!',
            'data' => $alquiler
        ]);
    }
}
