<?php

namespace App\Http\Requests\Languages;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class LanguageUpdateRequest
 * @package App\Http\Requests\Languages
 *
 * @property string $name
 */
class LanguageUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255'
        ];
    }
}
