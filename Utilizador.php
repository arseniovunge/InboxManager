<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Utilizador extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'utilizadores';

    protected $fillable = [
        'nome', 'telefone', 'email', 'palavra_passe', 'tipo',
    ];

    protected $hidden = [
        'palavra_passe', 'remember_token',
    ];

    public function emails()
    {
        return $this->hasMany(Email::class, 'utilizador_id');
    }
}
