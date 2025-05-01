<?php

namespace App\Http\Controllers;

use App\Models\Utilizador;

class AdminViewController extends Controller
{
    public function index()
    {
        $utilizadores = Utilizador::withCount([
            'emails as total_emails_enviados' => fn($q) => $q->where('tipo', 'enviado'),
            'emails as total_emails_recebidos' => fn($q) => $q->where('tipo', 'recebido'),
        ])->get();

        return view('dashboard', compact('utilizadores'));
    }
}
