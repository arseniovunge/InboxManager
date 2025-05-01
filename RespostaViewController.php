<?php

namespace App\Http\Controllers;

use App\Models\Resposta;
use Illuminate\Http\Request;

class RespostaViewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email_id' => 'required|exists:emails,id',
            'utilizador_id' => 'required|exists:utilizadores,id',
            'mensagem' => 'required|string',
        ]);

        Resposta::create([
            'email_id' => $request->email_id,
            'utilizador_id' => $request->utilizador_id,
            'mensagem' => $request->mensagem,
            'respondido_em' => now(),
        ]);

        return redirect()->back()->with('sucesso', 'Resposta enviada com sucesso!');
    }
}
