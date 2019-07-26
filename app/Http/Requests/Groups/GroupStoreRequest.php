<?php

namespace App\Http\Requests\Groups;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class GroupStoreRequest
 * @package App\Http\Requests\Groups
 *
 * @property string $name
 * @property string $description
 * @property array $projects
 */
class GroupStoreRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:groups,name',
            'description' => 'required|string',
            'projects' => 'nullable|array',
            'projects.*' => 'nullable|numeric|exists:projects,id'
        ];
    }
}
