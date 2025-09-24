<?php

namespace App\Models\Avaliacao;

use Illuminate\Database\Eloquent\Model;

class Peso extends Model
{
    protected $fillable = [
        'valor',   // Ex: 1 a 5 ou percentual
        'descricao',
    ];

    public function avaliacaoCriterios()
    {
        return $this->hasMany(AvaliacaoCriterio::class);
    }
}
