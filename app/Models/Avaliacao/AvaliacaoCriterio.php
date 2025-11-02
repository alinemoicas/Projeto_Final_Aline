<?php

namespace App\Models\Avaliacao;

use Illuminate\Database\Eloquent\Model;

class AvaliacaoCriterio extends Model
{
    protected $table = 'avaliacao_criterios';

    protected $fillable = [
        'avaliacao_id',
        'criterio_id',
        'peso_id',
        'nota',
        'observacao',
    ];

    /**
     * Relacionamento com Avaliação
     */
    public function avaliacao()
    {
        return $this->belongsTo(Avaliacao::class);
    }

    /**
     * Relacionamento com Critério
     */
    public function criterio()
    {
        return $this->belongsTo(Criterio::class);
    }

    /**
     * Relacionamento com Peso
     */
    public function peso()
    {
        return $this->belongsTo(Peso::class);
    }
}
