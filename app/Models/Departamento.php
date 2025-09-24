<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    /**
     * Campos que podem ser preenchidos em massa.
     */
    protected $fillable = [
        'nome_dept',
        'sigla',
        'descricao_dept',
        'chefe_dpt_id',
    ];

    /**
     * Conversões de atributos para tipos nativos.
     * (útil caso venhas a ter datas, JSON, etc.)
     */
    protected $casts = [
        'chefe_dpt_id' => 'integer',
    ];

    /**
     * Um departamento possui muitos funcionários.
     */
    public function funcionarios()
    {
        return $this->hasMany(Funcionario::class);
    }

    /**
     * O chefe do departamento (um funcionário).
     */
    public function chefe()
    {
        return $this->belongsTo(Funcionario::class, 'chefe_dpt_id');
    }

    /**
     * Escopo para filtrar departamentos activos (exemplo).
     */
    public function scopeActivos($query)
    {
        return $query->whereHas('funcionarios', function ($q) {
            $q->where('status', 'activo');
        });
    }

    /**
     * Helper para retornar o nome do chefe, caso exista.
     */
    public function getNomeChefeAttribute()
    {
        return $this->chefe ? $this->chefe->nome : 'Sem chefe definido';
    }
}
