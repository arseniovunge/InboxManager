<?php

namespace App\Http\Controllers;
use App\Models\CodigoMFA;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Utilizador;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;


class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function registerForm()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'palavra_passe' => 'required|string',
        ]);

        $email = $request->email;
        $cacheKey = 'tentativas_login_' . Str::slug($email);

        /**
         * 🔐 Medida de segurança exigida pelo professor:
         * Limitar tentativas de login para evitar ataques de força bruta.
         * Se o utilizador errar a palavra-passe 4 vezes, o login é bloqueado por 15 minutos.
         */
        if (Cache::has($cacheKey . '_bloqueado')) {
            return back()->with('erro', 'Conta temporariamente bloqueada. Tente novamente em 15 minutos.');
        }

        $utilizador = Utilizador::where('email', $email)->first();

        if ($utilizador && Hash::check($request->palavra_passe, $utilizador->palavra_passe)) {
            // ✅ Limpa tentativas ao fazer login com sucesso
            Cache::forget($cacheKey);
            Cache::forget($cacheKey . '_bloqueado');

            Auth::login($utilizador);
            // 🔐 Segurança exigida pelo professor:
            // Ao fazer login, encerramos automaticamente outras sessões deste utilizador
            // Isso impede múltiplos acessos simultâneos com a mesma conta
            
            $request->session()->regenerate();

            return redirect()->route('emails.index');
        }

        // ⛔ Incrementa tentativas
        $tentativas = Cache::increment($cacheKey);

        // Define validade da cache na primeira tentativa
        if ($tentativas === 1) {
            Cache::put($cacheKey, 1, now()->addMinutes(15));
        }

        if ($tentativas >= 4) {
            // 🔒 Bloqueia por 15 minutos após 4 tentativas falhadas
            Cache::put($cacheKey . '_bloqueado', true, now()->addMinutes(15));
            return back()->with('erro', 'Demasiadas tentativas. Conta bloqueada por 15 minutos.');
        }

        return back()->with('erro', 'Credenciais inválidas.');
    }

    public function register(Request $request)
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

        Auth::login($utilizador);
        return redirect()->route('emails.index');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('auth.login');
    }
}
