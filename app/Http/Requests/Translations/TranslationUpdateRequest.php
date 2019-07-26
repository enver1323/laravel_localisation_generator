<?php

namespace App\Http\Requests\Translations;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class TranslationUpdateRequest
 * @package App\Http\Requests\Translations
 *
 * @property string $key
 * @property array $entries
 * @property array $groups
 */
class TranslationUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (bool)$this->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'key' => 'required|string|min:3|max:255',
            'entries' => 'nullable|array',
            'entries.*' => 'nullable|string|max:255',
            'groups' => 'nullable|array',
            'groups.*' => 'nullable|numeric|exists:groups,id',
        ];
    }
}
