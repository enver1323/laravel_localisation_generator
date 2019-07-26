<?php

namespace App\Http\Requests\Translations;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class TranslationSearchRequest
 * @package App\Http\Requests\Translations
 *
 * @property integer $id
 * @property string $key
 * @property array $languages
 * @property array $groups
 */
class TranslationSearchRequest extends FormRequest
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
            'id' => 'nullable|numeric|exists:translations,id',
            'key' => 'nullable|string',
            'languages' => 'nullable|array',
            'languages.*' => 'nullable|string|max:2|exists:languages,code',
            'groups' => 'nullable|array',
            'groups.*' => 'nullable|numeric|exists:groups,id'
        ];
    }
}
