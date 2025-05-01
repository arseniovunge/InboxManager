<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CodigoMFA extends Model
{
    use HasFactory;

    protected $table = 'codigos_mfa';

    protected $fillable = [
        'utilizador_id', 'codigo', 'expira_em'
    ];

    public function utilizador()
    {
        return $this->belongsTo(Utilizador::class);
    }
}
