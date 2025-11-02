<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTarefaRequest extends FormRequest
{
    /**
     * Determina se o utilizador pode fazer esta requisição.
     */
    public function authorize(): bool
    {
        // Mais tarde podes verificar se o user é dono da tarefa ou chefe do depto
        return true;
    }

    /**
     * Regras de validação.
     */
    public function rules(): array
    {
        return [
            'depat_id'   => 'sometimes|exists:departamentos,id',
            'gestor_id'        => 'sometimes|exists:funcionarios,id',
            'titulo_tarefa'     => 'sometimes|string|min:3|max:30',
            'tarefa_id'         => 'nullable|exists:tarefas,id', // se for sub-tarefa
            'dias_paraCompletar'=> 'sometimes|integer|min:1',
            'data_limite'       => 'sometimes|date|after_or_equal:today',
            'numero_de_nivel'   => 'sometimes|integer|min:1',
            'descricao_taf'     => 'sometimes|string|min:5',
            'estado_tarefa'     => 'sometimes|in:Pendente,Em_Andamento,Concluida,Cancelada',
        ];
    }

    /**
     * Mensagens personalizadas.
     */
    public function messages(): array
    {
        return [
            'depart_id.exists' => 'O departamento seleccionado não existe.',
            'gestor_id.exists'      => 'O gestor seleccionado não existe.',
            'titulo_tarefa.min'      => 'O título deve ter pelo menos 3 caracteres.',
            'titulo_tarefa.max'      => 'O título não pode ultrapassar 30 caracteres.',
            'data_limite.after_or_equal' => 'A data limite deve ser hoje ou uma data futura.',
            'estado_tarefa.in'       => 'O estado da tarefa deve ser: Pendente, Em Andamento, Concluída ou Cancelada.',
        ];
    }
}
