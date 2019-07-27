<?php

namespace App\Http\Requests\Projects;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ProjectSearchRequest
 * @package App\Http\Requests\Projects
 *
 * @property integer $id
 * @property string $name
 */
class ProjectSearchRequest extends FormRequest
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
            'id' => 'nullable|numeric|exists:projects,id',
            'name' => 'nullable|string|max:255'
        ];
    }
}
