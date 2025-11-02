<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignTarefa extends Model
{
    use HasFactory;

    protected $table = 'assign_tarefas';

    protected $fillable = [
        'departamento_id',
        'gestor_id',           // funcionário que é gestor
        'funcionario_id',      // funcionário a quem a tarefa é atribuída
        'tarefa_id',
        'resultado',           // nota ou feedback final
        'peso',                // peso da tarefa na avaliação
        'gestor_peso_status',  // confirmação do gestor sobre o peso (aprovado, pendente, rejeitado)
    ];

    /**
     * Relação com o Departamento
     */
    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }

    /**
     * Relação com o Gestor (funcionário que atribui a tarefa)
     */
    public function gestor()
    {
        return $this->belongsTo(Funcionario::class, 'gestor_id');
    }

    /**
     * Relação com o Funcionário (colaborador que recebe a tarefa)
     */
    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class, 'funcionario_id');
    }

    /**
     * Relação com a Tarefa
     */
    public function tarefa()
    {
        return $this->belongsTo(Tarefa::class, 'tarefa_id');
    }
}
