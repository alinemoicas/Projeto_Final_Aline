<?php

namespace App\Models\Avaliacao;

use Illuminate\Database\Eloquent\Model;

class Resultado extends Model
{
    protected $fillable = [
        'avaliacao_id',
        'nota',
        'comentario',
    ];

    public function avaliacao()
    {
        return $this->belongsTo(Avaliacao::class);
    }

    public function criterios()
    {
        return $this->hasMany(AvaliacaoCriterio::class);
    }
}
