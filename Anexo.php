<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Anexo extends Model
{
    use HasFactory;

    protected $fillable = [
        'email_id', 'nome_ficheiro', 'tipo_ficheiro', 'caminho',
    ];

    public function email()
    {
        return $this->belongsTo(Email::class);
    }
}
