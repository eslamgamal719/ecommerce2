<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
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
            'dep_name_ar' => 'required|max:50',
            'dep_name_en' => 'required|max:50',
            'description' => 'sometimes|nullable',
            'icon'        => 'sometimes|nullable|' . validate_image(),
            'keyword'     => 'sometimes|nullable',
            'parent'   => 'sometimes|nullable',
        ];
    }
}
