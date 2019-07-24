<?php


namespace App\Http\Requests\Groups;


use Illuminate\Foundation\Http\FormRequest;

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
