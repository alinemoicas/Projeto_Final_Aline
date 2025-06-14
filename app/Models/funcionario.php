<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class funcionario extends Model
{
    use HasFactory;
    protected $list_func = [
    'nome', 
    'sobrenome',
    'telefone',
    'email',
    'data_nascimento',
    'cargo',
    'categoria',
    'dept_id',
    'estado',
    ];
    //relação com o departamento (todo o funcionario deve pertencer pelo menos há um departamento)
     public function departamento(){
        return $this->belongsTo(Departamento::class);
     }

     public function avaliacao(){
         return $this->hasMany(Avaliacao::class); //hasMany varias tarefas atribuidas mas não são permanentes
     }
     public function tarefa(){
         return $this->hasMany(Tarefa::class); 
     }
}
