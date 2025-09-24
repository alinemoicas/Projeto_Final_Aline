<?php

namespace App\Models\Avaliacao;

use Illuminate\Database\Eloquent\Model;
use App\Models\Funcionario;

class Avaliacao extends Model
{
    // Nome correto da tabela
    protected $table = 'avaliacoes';

    protected $fillable = [
        'funcionario_id',
        'avaliador_id',
        'data',
        'descricao',
    ];

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class, 'funcionario_id');
    }

    public function avaliador()
    {
        return $this->belongsTo(Funcionario::class, 'avaliador_id');
    }

    public function avaliado()
    {
    return $this->belongsTo(Funcionario::class, 'avaliado_id');
    }

    public function criterios()
    {
        return $this->belongsToMany(Criterio::class, 'avaliacao_criterios')
                    ->withPivot('peso_id', 'resultado_id')
                    ->withTimestamps();
    }

    public function resultados()
    {
        return $this->hasMany(Resultado::class);
    }
}
