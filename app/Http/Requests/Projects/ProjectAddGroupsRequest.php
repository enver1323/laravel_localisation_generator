<?php


namespace App\Http\Requests\Projects;


use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ProjectAddGroupsRequest
 * @package App\Http\Requests\Projects
 *
 * @property integer $project
 * @property array $groups
 */
class ProjectAddGroupsRequest extends FormRequest
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
            'project' => 'required|numeric|exists:projects,id',
            'groups' => 'required|array',
            'groups.*' => 'required|numeric|exists:groups,id',
        ];
    }
}
