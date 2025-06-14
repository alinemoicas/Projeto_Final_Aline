<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;
    protected $list_dept = [
    'nome_dept',
    'descricao_dept',
    ];
    public function funcionario(){
        //essa funcionação permite ler os dados sobre avalições, metas e o controle de assiduidade
        return $this->hasMany(funcionario::class);
    }
}
