<?php

namespace App\Models\Avaliacao;

use Illuminate\Database\Eloquent\Model;
use App\Models\Funcionario;

class Avaliacao extends Model
{
    protected $table = 'avaliacoes';

    protected $fillable = [
        'funcionario_id',   // avaliado
        'avaliador_id',     // chefe
        'data',
        'descricao',
    ];

    /**
     * Funcionário avaliado
     */
    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class, 'funcionario_id');
    }

    /**
     * Chefe avaliador
     */
    public function avaliador()
    {
        return $this->belongsTo(Funcionario::class, 'avaliador_id');
    }

    /**
     * Critérios avaliados nesta avaliação
     */
    public function criterios()
    {
        return $this->belongsToMany(Criterio::class, 'avaliacao_criterios')
                    ->withPivot('peso_id', 'nota', 'observacao')
                    ->withTimestamps();
    }

    /**
     * Resultado final consolidado
     */
    public function resultado()
    {
        return $this->hasOne(Resultado::class);
    }
}