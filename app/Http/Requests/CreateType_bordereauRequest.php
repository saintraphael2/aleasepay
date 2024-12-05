<?php

namespace App\Http\Requests;

use App\Models\Type_bordereau;
use Illuminate\Foundation\Http\FormRequest;

class CreateType_bordereauRequest extends FormRequest
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
        return Type_bordereau::$rules;
    }
}
