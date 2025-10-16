<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Dotenv\Validator;
use Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();

        return response()->json([
            'message' => 'LISTA DE USUARIOS',
            'data' => $user
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);

        if (!$id) {
            return response()->json(['message' => 'USUARIO NO ENCONTRADO']);
        }

        return response()->json([
            'message' => 'Usuario ' . $user->name,
            'data' => $user
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'NO SE ENCONTRO NINGUN USUARIO']);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'rol_id' => 'exists:rols,id',
                'name' => 'string|min:3',
                'email' => 'email|unique:users,email',
                'password' => 'min:6',
                'estrato' => 'required'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errros' => $validator->errors()]);
        }

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('email')) {
            $user->email = $request->email;
        }

        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->has('estrato')) {
            $user->estrato = $request->estrato;
        }

        $user->save();

        return response()->json([
            'message' => 'SU CAMBIO HA SIDO EXITOSO',
            'data' => $user
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        $auth = Auth::user();

        if (!$auth || $auth->rol_id !== 1) {
            return response()->json([
                'message' => 'ACCESSO NO AUTORIZO'
            ]);
        }

        if (!$user) {
            return response()->json(['message' => 'NO SE ENCONTRO NINGUN USUARIO']);
        }

        $user->tokens()->delete();

        $user->delete();

        return response()->json([
            'message' => 'USUARIO ELIMINADO',
            'data' => $user
        ]);
    }
}
