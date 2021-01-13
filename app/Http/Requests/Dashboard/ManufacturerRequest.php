<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class ManufacturerRequest extends FormRequest
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
            'name_ar'      => 'required',
            'name_en'      => 'required',
            'facebook'     => 'sometimes|nullable|url',
            'twitter '     => 'sometimes|nullable|url',
            'website'      => 'sometimes|nullable|url',
            'address'      => 'sometimes|nullable',
            'contact_name' => 'sometimes|nullable|string',
            'mobile'       => 'sometimes|nullable|numeric',
            'email'        => 'sometimes|nullable|email',
            'lat'          => 'sometimes|nullable',
            'lng'          => 'sometimes|nullable',
            'icon'         => 'sometimes|nullable|' . validate_image(),
        ];
    }
}
