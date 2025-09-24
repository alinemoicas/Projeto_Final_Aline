<?php

namespace App\Models\Avaliacao\Avaliacao;
namespace App\Models;

use App\Models\Avaliacao\Avaliacao;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{
    use HasFactory;
   protected $fillable = [
    'descricao_taf',
    'funcionario_id',
   'titulo_taf',
   'data_inicio',
   'data_fim',
   'importancia_taref',
   'estado_tarefa',
   'avaliacao_id'
   ];
   public function funcionario(){
       return $this->belongsTo(Funcionario::class); //belongsTo aponta que um funcionario tem varias tarefas atribuidas permanentemente
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

     public function avaliacao()
    {
        return $this->belongsTo(Avaliacao::class);
    }

}
