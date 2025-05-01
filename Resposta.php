<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Resposta extends Model
{
    use HasFactory;

    protected $fillable = ['email_id', 'utilizador_id', 'mensagem', 'respondido_em'];

    public function email()
    {
        return $this->belongsTo(Email::class);
    }

    public function utilizador()
    {
        return $this->belongsTo(Utilizador::class);
    }
}
