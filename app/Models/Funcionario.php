<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Avaliacao\Avaliacao;

class Funcionario extends Model
{
    use HasFactory;

    protected $table = 'funcionarios';

    protected $fillable = [
        'nome',
        'sobrenome',
        'telefone',
        'email',
        'cargo_id',
        'dept_id',
        'data_admissao',
        'gestor_id',
        'categoria',
        'estado',
    ];

    /**
     * Funcionário pertence a um departamento
     */
    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'dept_id');
    }

    /**
     * Funcionário pertence a um cargo
     */
    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }

    /**
     * Funcionário pertence a um gestor (superior hierárquico)
     */
    public function gestor()
    {
        return $this->belongsTo(Gestor::class, 'gestor_id');
    }

    /**
     * Funcionário pode ter várias tarefas
     */
    public function tarefas()
    {
        return $this->hasMany(Tarefa::class);
    }

    /**
     * Funcionário pode ter várias avaliações
     */
    public function avaliacoes()
    {
        return $this->hasMany(Avaliacao::class);
    }

    /**
     * Relação com User (para login/autenticação)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope: apenas gestores/chefes (se aplicável)
     */
    public function scopeGestores($query)
    {
        return $query->whereHas('cargo', function ($q) {
            $q->where('nome', 'like', '%Gestor%')
              ->orWhere('nome', 'like', '%Chefe%');
        });
    }
     public function chefe()
    {
        // self reference: chefe_id aponta para outro funcionario
        return $this->belongsTo(Funcionario::class, 'chefe_id')
            ->withDefault();
    }
}