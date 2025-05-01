<?php
namespace App\Http\Controllers\Api;

use App\Models\Email;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmailController extends Controller
{
    public function index()
    {
        return Email::with('utilizador', 'anexos')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'utilizador_id' => 'required|exists:utilizadores,id',
            'tipo' => 'required|in:enviado,recebido', // ✅ novo campo
            'remetente' => 'required|string',
            'assunto' => 'required|string',
            'corpo' => 'required|string',
            'recebido_em' => 'required|date',
        ]);

        $email = Email::create($request->only([
            'utilizador_id', 'tipo', 'remetente', 'assunto', 'corpo', 'recebido_em'
        ]));

        return response()->json($email, 201);
    }

    public function show($id)
    {
        $email = Email::with('utilizador', 'anexos')->findOrFail($id);
        return response()->json($email);
    }

    public function update(Request $request, $id)
    {
        $email = Email::findOrFail($id);

        $request->validate([
            'tipo' => 'in:enviado,recebido',
            'remetente' => 'string',
            'assunto' => 'string',
            'corpo' => 'string',
            'recebido_em' => 'date',
        ]);

        $email->update($request->only([
            'tipo', 'remetente', 'assunto', 'corpo', 'recebido_em'
        ]));

        return response()->json($email);
    }

    public function destroy($id)
    {
        Email::destroy($id);
        return response()->json(['mensagem' => 'Email eliminado com sucesso']);
    }
}

