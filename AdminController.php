<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Utilizador;
use App\Models\Email;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Total geral de utilizadores
        $totalUtilizadores = Utilizador::count();

        // Contar emails enviados e recebidos por cada utilizador
        $metricas = Utilizador::withCount([
            'emails as total_emails_enviados' => function ($query) {
                $query->where('tipo', 'enviado');
            },
            'emails as total_emails_recebidos' => function ($query) {
                $query->where('tipo', 'recebido');
            },
        ])->get(['id', 'nome', 'email']);

        return response()->json([
            'total_utilizadores' => $totalUtilizadores,
            'utilizadores' => $metricas
        ]);
    }

    public function gerarRelatorio($id)
    {
        $utilizador = Utilizador::findOrFail($id);

        $emails = Email::where('utilizador_id', $id)
                    ->orderBy('recebido_em', 'desc')
                    ->get();

        $enviados = $emails->where('tipo', 'enviado')->count();
        $recebidos = $emails->where('tipo', 'recebido')->count();

        $pdf = Pdf::loadView('pdf.relatorio_utilizador', compact('utilizador', 'emails', 'enviados', 'recebidos'));

        return $pdf->download("relatorio_{$utilizador->nome}.pdf");
    }
}
