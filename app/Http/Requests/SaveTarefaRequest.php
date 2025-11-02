<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveTarefaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo_tarefa'              => 'required|string|max:255',
            'descricao_taf'           => 'required|string',
            'departamento_id'     => 'required|exists:departamentos,id',
            'gestor_id'           => 'required|exists:gestores,id',
            'dias_paraCompletar' => 'required|integer|min:1',
            'numero_de_nivel'     => 'required|integer|min:1',
            'data_limite'         => 'required|date|after_or_equal:today',
        ];
    }

    public function attributes(): array
    {
        return [
            'titulo'              => 'título da tarefa',
            'descricao'           => 'descrição da tarefa',
            'departamento_id'     => 'departamento',
            'gestor_id'           => 'gestor responsável',
            'dias_para_completar' => 'dias para completar',
            'numero_de_nivel'     => 'número de nível',
            'data_limite'         => 'data limite',
        ];
    }
}
