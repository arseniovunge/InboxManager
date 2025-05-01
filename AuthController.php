<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Utilizador;
use App\Models\CodigoMFA;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AuthController extends Controller
{
    // ✅ Registro de novo utilizador
    public function registar(Request $request)
    {
        $request->validate([
            'nome' => 'required|string',
            'telefone' => 'required|string',
            'email' => 'required|email|unique:utilizadores',
            'palavra_passe' => 'required|string|min:6',
        ]);

        $tipo = Utilizador::count() === 0 ? 'administrador' : 'comum';

        $utilizador = Utilizador::create([
            'nome' => $request->nome,
            'telefone' => $request->telefone,
            'email' => $request->email,
            'palavra_passe' => Hash::make($request->palavra_passe),
            'tipo' => $tipo,
        ]);

        return response()->json(['mensagem' => 'Conta criada com sucesso', 'utilizador' => $utilizador], 201);
    }

    // ✅ Login: envia código MFA para o email
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'palavra_passe' => 'required|string',
        ]);

        $utilizador = Utilizador::where('email', $request->email)->first();

        if (!$utilizador || !Hash::check($request->palavra_passe, $utilizador->palavra_passe)) {
            return response()->json(['erro' => 'Credenciais inválidas'], 401);
        }

        // Gerar código MFA
        $codigo = rand(100000, 999999);
        $expira_em = Carbon::now()->addMinutes(5);

        CodigoMFA::create([
            'utilizador_id' => $utilizador->id,
            'codigo' => $codigo,
            'expira_em' => $expira_em,
        ]);

        // Enviar código por email
        Mail::raw("Seu código de verificação é: $codigo (válido por 5 minutos)", function ($message) use ($utilizador) {
            $message->to($utilizador->email)
                    ->subject('Código MFA - InboxManager');
        });

        return response()->json(['mensagem' => 'Código MFA enviado para o email']);
    }

    // ✅ Verifica o código e retorna acesso
    public function verificarCodigo(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'codigo' => 'required|string',
        ]);

        $utilizador = Utilizador::where('email', $request->email)->first();

        if (!$utilizador) {
            return response()->json(['erro' => 'Utilizador não encontrado'], 404);
        }

        $codigo = CodigoMFA::where('utilizador_id', $utilizador->id)
                    ->where('codigo', $request->codigo)
                    ->where('expira_em', '>', Carbon::now())
                    ->latest()
                    ->first();

        if (!$codigo) {
            return response()->json(['erro' => 'Código inválido ou expirado'], 403);
        }

        // Apagar o código após uso
        $codigo->delete();

        // Gerar token de acesso (simples - para testes)
        $token = Str::random(60);

        return response()->json([
            'mensagem' => 'Autenticação bem-sucedida',
            'utilizador' => $utilizador,
            'token_fake' => $token // Troque por Sanctum ou Passport no futuro
        ]);
    }
}

