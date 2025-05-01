<?php

namespace App\Http\Controllers\Api;

use App\Models\Resposta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RespostaController extends Controller
{
    public function index()
    {
        return Resposta::with('email', 'utilizador')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'email_id' => 'required|exists:emails,id',
            'utilizador_id' => 'required|exists:utilizadores,id',
            'mensagem' => 'required|string',
        ]);

        $resposta = Resposta::create($request->all());

        return response()->json($resposta, 201);
    }

    public function show($id)
    {
        return Resposta::with('email', 'utilizador')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $resposta = Resposta::findOrFail($id);
        $resposta->update($request->all());

        return response()->json($resposta);
    }

    public function destroy($id)
    {
        Resposta::destroy($id);
        return response()->json(['mensagem' => 'Resposta eliminada com sucesso']);
    }
}
