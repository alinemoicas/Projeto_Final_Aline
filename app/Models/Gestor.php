<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gestor extends Model
{
    use HasFactory;

    protected $table = 'gestores';

    protected $fillable = [
        'user_id',
        'departamento_id',
        'cargo_id',
        'chefe_directo',
        'nome',
        'sobrenome',
        'telefone',
        'genero',
        'categoria',
        'data_admissao',
        'endereco',
        'estado',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIONAMENTOS
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }

    public function chefe()
    {
        return $this->belongsTo(Gestor::class, 'chefe_directo');
    }

    public function subordinados()
    {
        return $this->hasMany(Gestor::class, 'chefe_directo');
    }

    public function funcionarios()
{
    return $this->hasMany(Funcionario::class, 'gestor_id');
}
}