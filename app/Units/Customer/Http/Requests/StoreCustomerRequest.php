<?php

namespace Wiki\Units\Customer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
            'rg' => 'required|unique:customers,rg|integer',
            'cpf' => 'required|unique:customers,cpf|string|regex:/[0-9]{3}\.[0-9]{3}\.[0-9]{3}\-[0-9]{2}/',
            'telefone' => 'required|string|regex:/\([0-9]{2}\) ([0-9]{4,5}-[0-9]{4})/'
        ];
    }
}
