<?php

namespace App\Http\Controllers\Api;

use App\Models\Utilizador;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UtilizadorController extends Controller
{
    public function index()
    {
        return Utilizador::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string',
            'telefone' => 'required|string',
            'email' => 'required|email|unique:utilizadores',
            'palavra_passe' => 'required|string|min:6',
        ]);

        $utilizador = Utilizador::create([
            'nome' => $request->nome,
            'telefone' => $request->telefone,
            'email' => $request->email,
            'palavra_passe' => Hash::make($request->palavra_passe),
            'tipo' => 'comum',
        ]);

        return response()->json($utilizador, 201);
    }

    public function show($id)
    {
        return Utilizador::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $utilizador = Utilizador::findOrFail($id);
        $utilizador->update($request->all());

        return response()->json($utilizador);
    }

    public function destroy($id)
    {
        Utilizador::destroy($id);
        return response()->json(['mensagem' => 'Utilizador eliminado com sucesso']);
    }
}
