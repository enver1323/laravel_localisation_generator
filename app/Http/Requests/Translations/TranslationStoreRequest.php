<?php

namespace App\Http\Requests\Translations;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class TranslationStoreRequest
 * @package App\Http\Requests\Translations
 *
 * @property string $key
 * @property array $entries
 * @property array $groups
 */
class TranslationStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'key' => 'required|string|max:255|min:3|unique:translations,key',
            'entries' => 'nullable|array',
            'entries.*' => 'nullable|string|max:255',
            'groups' => 'nullable|array',
            'groups.*' => 'nullable|numeric|exists:groups,id',
        ];
    }
}
