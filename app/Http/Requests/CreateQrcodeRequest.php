<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Qrcode;

class CreateQrcodeRequest extends FormRequest
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
        //return Qrcode::$rules;
        return [
            'product_name' => 'required|max:255',
            'company_name' => 'required|max:255',
            'callback_url' => 'required',
            'user_id' => 'required',
            'amount' => 'required',
        ];
    }
}
