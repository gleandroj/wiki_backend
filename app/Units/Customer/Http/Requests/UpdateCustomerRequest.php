<?php

namespace Wiki\Units\Customer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nome' => 'required|string',
            'dt_nascimento' => 'required|date_format:d/m/Y',
            'rg' => ['required|integer', Rule::unique('customers')->ignore($this->customer->id)],
            'cpf' => ['required|string|regex:/[0-9]{3}\.[0-9]{3}\.[0-9]{3}\-[0-9]{2}/', Rule::unique('customers')->ignore($this->customer->id)],
            'telefone' => 'required|string|regex:/\([0-9]{2}\) ([0-9]{4,5}-[0-9]{4})/'
        ];
    }
}
