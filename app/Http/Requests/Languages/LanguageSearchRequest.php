<?php

namespace App\Http\Requests\Languages;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class LanguageSearchRequest
 * @package App\Http\Requests\Languages
 *
 * @property string $code
 * @property string $name
 */
class LanguageSearchRequest extends FormRequest
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
            'code' => 'nullable|alpha|max:2',
            'name' => 'nullable|string|max:255',
        ];
    }
}
