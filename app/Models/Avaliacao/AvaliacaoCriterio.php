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
        'resultado_id',
    ];

    public function avaliacao()
    {
        return $this->belongsTo(Avaliacao::class);
    }

    public function criterio()
    {
        return $this->belongsTo(Criterio::class);
    }

    public function peso()
    {
        return $this->belongsTo(Peso::class);
    }

    public function resultado()
    {
        return $this->belongsTo(Resultado::class);
    }
}
