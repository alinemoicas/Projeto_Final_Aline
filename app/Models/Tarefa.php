<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Tarefa extends Model
{
    use HasFactory;
    protected $list_tarefas = [
    'funcionario_id',
    'titulo_taf',
    'descricao_taf',
    'data_fim',
    'importancia_taref',
    'estado_tarefa',
    ]; 
    public function funcionario(){
        return $this->belongsTo(funcionario::class); //belongsTo aponta que um funcionario tem varias tarefas atribuidas permanentemente
    }
    public function atraso_tarefa(): bool
    {
        return $this->estado_tarefa !== 'Concluída' 
        && $this->data_fim && 
        Carbon::parse($this->data_fim)->isPast(); 

    }
     public function dias_restantes(): ?int 
    {
        return $this->data_fim ? Carbon::now()->diffInDays(Carbon::parse($this->data_fim), false):null; 
    }
     public function importancia_tarefa(): string
    {
        return match($this->importancia_taref){
            1 => 'Muito Alto',
            2 => 'Alto',
            3 => 'Média',
            4 => 'Baixo',
            5 => 'Muito Baixo',
            default => 'Não Definida',
        };
    }
}
