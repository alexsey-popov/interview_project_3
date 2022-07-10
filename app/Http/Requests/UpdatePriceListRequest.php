<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePriceListRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'provider' => 'required|string|max:255',
            'validity_period' => 'required|date',
            'currency' => 'required|string|max:255'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required'             => 'Имя не указано',
            '*.string'                  => 'Указан некорректный тип данных',
            '*.max'                     => 'Превышена максимальная длина поля. Поле должно быть длиной до :max символов',
            'provider.required'         => 'Поставщик не указан',
            'validity_period.required'  => 'Срок действия не указан',
            'validity_period.date'      => 'Указан некорректный тип данных',
            'currency.required'         => 'Валюта не указана',
        ];
    }
}
