<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreGrupoConviteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manageParticipants', $this->route('grupo'));
    }

    public function rules(): array
    {
        return [
            'duracao_horas' => ['required', 'integer', Rule::in([1, 24, 72, 168])],
        ];
    }
}
