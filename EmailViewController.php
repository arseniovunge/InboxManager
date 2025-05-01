<?php
namespace App\Http\Controllers;

use App\Models\Email;

class EmailViewController extends Controller
{
    public function index()
    {
        $emails = Email::latest()->paginate(10);
        return view('emails.index', compact('emails'));
    }

    public function create()
    {
        return view('emails.create');
    }

    public function show($id)
    {
        $email = Email::findOrFail($id);
        return view('emails.show', compact('email'));
    }
    public function store(Request $request)
{
    $request->validate([
        'utilizador_id' => 'required|exists:utilizadores,id',
        'tipo' => 'required|in:enviado',
        'remetente' => 'required|string|email',
        'assunto' => 'required|string',
        'corpo' => 'required|string',
        'recebido_em' => 'required|date',
    ]);

    Email::create($request->all());

    return redirect()->route('emails.index')->with('sucesso', 'Email enviado com sucesso!');
}
}
