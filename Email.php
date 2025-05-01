<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Email extends Model
{
    use HasFactory;

    protected $fillable = [
        'utilizador_id', 'remetente', 'assunto', 'corpo', 'recebido_em',
    ];

    public function utilizador()
    {
        return $this->belongsTo(Utilizador::class);
    }

    public function anexos()
    {
        return $this->hasMany(Anexo::class);
    }
}
