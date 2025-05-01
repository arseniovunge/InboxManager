<?php

namespace App\Http\Controllers\Api;

use App\Models\Anexo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AnexoController extends Controller
{
    public function index()
    {
        return Anexo::with('email')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'email_id' => 'required|exists:emails,id',
            'nome_ficheiro' => 'required|string',
            'tipo_ficheiro' => 'required|string',
            'caminho' => 'required|string',
        ]);

        $anexo = Anexo::create($request->all());

        return response()->json($anexo, 201);
    }

    public function show($id)
    {
        $anexo = Anexo::with('email')->findOrFail($id);
        return response()->json($anexo);
    }

    public function update(Request $request, $id)
    {
        $anexo = Anexo::findOrFail($id);
        $anexo->update($request->all());

        return response()->json($anexo);
    }

    public function destroy($id)
    {
        Anexo::destroy($id);
        return response()->json(['mensagem' => 'Anexo eliminado com sucesso']);
    }
}
