<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
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
            'name'       => 'required',
            'level'       => 'required|in:user,vendor,company',
            'email'      => 'required|email|unique:users,email,' . $this->id,
            'password'   => 'sometimes|nullable|min:6',
        ];
    }
}
