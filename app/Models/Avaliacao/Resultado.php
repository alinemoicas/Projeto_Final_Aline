<?php

namespace App\Models\Avaliacao;

use Illuminate\Database\Eloquent\Model;

class Resultado extends Model
{
    protected $table = 'resultados'; // nome da tabela, caso seja diferente, ajusta aqui

    protected $fillable = [
        'tarefa_id',
        'departamento_id',
        'funcionario_id',
        'gestor_id',
        'report_file',  // ficheiro (upload PDF, DOC, etc.)
        'report',       // conteúdo textual
        'comentario',   // observações do gestor/avaliador
    ];

    /**
     * Relacionamentos
     */
    public function tarefa()
    {
        return $this->belongsTo(\App\Models\Tarefa::class, 'tarefa_id');
    }

    public function departamento()
    {
        return $this->belongsTo(\App\Models\Departamento::class, 'departamento_id');
    }

    public function funcionario()
    {
        return $this->belongsTo(\App\Models\Funcionario::class, 'funcionario_id');
    }

    public function gestor()
    {
        return $this->belongsTo(\App\Models\Funcionario::class, 'gestor_id');
    }
}
