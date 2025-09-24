<?php

namespace App\Models\Avaliacao;

use Illuminate\Database\Eloquent\Model;

class Criterio extends Model
{
    protected $fillable = [
        'nome',
        'descricao',
    ];

    public function avaliacoes()
    {
        return $this->belongsToMany(Avaliacao::class, 'avaliacao_criterios')
                    ->withPivot('peso_id', 'resultado_id')
                    ->withTimestamps();
    }
}
