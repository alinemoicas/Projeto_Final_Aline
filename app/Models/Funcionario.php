<?php

namespace App\Models;

use App\Models\Avaliacao\Avaliacao;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    use HasFactory;

    protected $fillable = [
   'nome',
   'sobrenome',
   'telefone',
   'email',
   'cargo_id',
   'dept_id',
   'data_admissao',
   'chefe_id', //caso existir auto referencia
   'categoria',
   'estado',
   ];


   public function departamento(){
       return $this->belongsTo(Departamento::class, "dept_id");
    }

        public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }

    public function chefe()
    {
        return $this->belongsTo(Funcionario::class, 'chefe_id');
    }

    public function subordinados()
    {
        return $this->hasMany(Funcionario::class, 'chefe_id');
    }

    public function tarefas()
    {
        return $this->hasMany(Tarefa::class);
    }

    public function avaliacoes()
    {
        return $this->hasMany(Avaliacao::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);

    }
}
