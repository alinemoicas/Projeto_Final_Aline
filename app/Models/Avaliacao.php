<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model
{
    use HasFactory;
    protected $list_avaliacao = [
        'funcionario_id',
        'data_avaliacao',
        'resultado', 
        'campo_comentario',  
    ];

    public function funcionario(){
        return $this->belongsTo(funcionario::class);
    }

    public function nivel(): string 
    {
        if($this->resultado >= 90) return 'Muito alto';
        if($this->resultado >= 75) return 'Alto';
        if($this->resultado >= 60) return 'Médio';
        if($this->resultado >= 45) return 'Baixo';
        return 'Muito Baixo';
    } 
    public function nivel_Excelente(): bool
    {
        return $this->resultado >= 85;
    }

    public static function media_produtividade_funcionario($func_Id){
        return self::where('funcionario_id', $func_Id)->avg('resultado');
    }

    public static function total_dia_aval($func_Id){
        return self::where('funcionario_id', $func_Id)->count();
    }

    public static function ausencia($func_Id){
        return self::where('funcionario_id', $func_Id)->where(function ($query){
            $query->whereNull('resultado')->orwhere('resultado', 0);
        })->count();
    }
    public static function taxa_assiduidade($func_Id): float
    {
        $total = self::total_dia_aval($func_Id);
        $faltas =self::ausencia($func_Id);
        return $total > 0 ? round((($total - $faltas)/ $total)*100, 2):0; //formula assiduidade rever, para justificar na revisão literaria
    }

    public static function assiduidade_nivel($func_Id): string
    {
        $percentagem = self::taxa_assiduidade($func_Id);
        if($percentagem >= 95) return 'Excelente';
        if($percentagem >= 85) return 'Bom';
        if($percentagem >= 70) return 'Regular';
        return 'Fraco';
    }
    public function tarefa_concluidas(){
         return Tarefa::where('funcionario_id', $this->funcionario_id)->whereBetween('data_fim', 
         [
            Carbon::parse($this->data_avaliacao)->startOfMonth(), 
            Carbon::parse($this->data_avaliacao)->endOfMonth()
         ])->where('estado_tarefa', 'Concluída')->count();
     }
}
