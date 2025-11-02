<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{
    use HasFactory;

    protected $table = 'tarefas';

    protected $fillable = [
        'titulo_tarefa',
        'descricao_taf',
        // 'funcionario_id',
        'departamento_id',
        'gestor_id',
        'dias_paraCompletar',
        // 'data_inicio',
        'data_limite',
        'numero_de_nivel',
        // 'importancia_tarefa',
        // 'estado_tarefa',
        // 'avaliacao_id',
    ];

    /**
     * Relação com Funcionário
     */
    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class);
    }

    /**
     * Relação com Departamento
     */
    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    /**
     * Relação com Gestor/Manager (chefe)
     */
    public function manager()
    {
        return $this->belongsTo(Funcionario::class, 'manager_id');
    }

    /**
     * Relação com Avaliação
     */
    public function avaliacao()
    {
        return $this->belongsTo(\App\Models\Avaliacao\Avaliacao::class);
    }
    public function gestor()
{
    return $this->belongsTo(Gestor::class, 'gestor_id');
}

}
