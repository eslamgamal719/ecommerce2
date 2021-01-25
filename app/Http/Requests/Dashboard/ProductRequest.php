<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'title'          => 'required',
            'content'        => 'required',
            'stock'          => 'required|numeric',
            'price'          => 'required|numeric',
            'status'         => 'nullable|in:active,refused,pending',
            'reason'         => 'nullable',
            'start_at'       => 'required|date',
            'end_at'         => 'required|date',
            'price_offer'    => 'nullable|numeric',
            'start_offer_at' => 'nullable|date',
            'end_offer_at'   => 'nullable|date',
            'department_id'  => 'required|numeric',
            'trade_id'       => 'required|numeric',
            'manu_id'        => 'required|numeric',
            'color_id'       => 'nullable|numeric',
            'size_id'        => 'nullable|numeric',
            'weight'         => 'nullable',
            'weight_id'      => 'nullable|numeric',
            'currency_id'    => 'nullable|numeric'
        ];
    }
}
