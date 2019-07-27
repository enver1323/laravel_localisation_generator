<?php

namespace App\Http\Requests\Projects;

use App\Models\Services\Projects\ProjectExportService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectExportRequest extends FormRequest
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
            'languages' => 'required|array',
            'languages.*' => 'required|string|exists:languages,code',
            'type' => [
                'required',
                'string',
                Rule::in(ProjectExportService::$types)
            ],
        ];
    }
}
