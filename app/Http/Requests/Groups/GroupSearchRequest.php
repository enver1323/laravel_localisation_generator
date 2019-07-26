<?php

namespace App\Http\Requests\Groups;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class GroupSearchRequest
 * @package App\Http\Requests\Groups
 *
 * @property integer $id
 * @property string $name
 * @property array $projects
 */
class GroupSearchRequest extends FormRequest
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
            'id' => 'nullable|numeric|exists:groups,id',
            'name' => 'nullable|string|max:255',
            'projects' => 'nullable|array',
            'projects.*' => 'nullable|numeric|exists:projects,id'
        ];
    }
}
