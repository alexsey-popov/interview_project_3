<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePriceListItemRequest extends FormRequest
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
            'price_list_id' => 'required|exists:price_lists,id',
            'name' => 'required|string|max:255',
            'article_number' => 'required|string|max:255',
            'price' => 'required|numeric',
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
            'price_list_id.required'    => 'Прайслист не указан',
            'price_list_id.exists'      => 'Указанный прайслист не найден',
            'name.required'             => 'Имя не указано',
            '*.string'                  => 'Указан некорректный тип данных',
            '*.max'                     => 'Превышена максимальная длина поля. Поле должно быть длиной до :max символов',
            'provider.required'         => 'Поставщик не указан',
            'article_number.required'   => 'Артикул не указан',
            'price.numeric'             => 'Указан некорректный тип данных',
            'price.required'            => 'Цена не указана',
        ];
    }
}
