<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExportPriceListRequest extends FormRequest
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
            'lists' => 'required|array',
            'format' => 'required|in:JSON,XLSX'
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
            'lists.required'    => 'Прайслисты не указаны',
            'lists.array'       => 'Некорректный формат списка прайслистов',
            'format.required'   => 'Формат вывода не указан',
            'format.in'         => 'Указан некорректный формат данных',
        ];
    }
}
