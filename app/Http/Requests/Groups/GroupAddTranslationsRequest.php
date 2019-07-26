<?php


namespace App\Http\Requests\Groups;


use Illuminate\Foundation\Http\FormRequest;

/**
 * Class GroupAddTranslationsRequest
 * @package App\Http\Requests\Groups
 *
 * @property integer $group
 * @property array $translations
 */
class GroupAddTranslationsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (bool) $this->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'group' => 'required|numeric|exists:groups,id',
            'translations' => 'required|array',
            'translations.*' => 'required|numeric|exists:translations,id',
        ];
    }
}
