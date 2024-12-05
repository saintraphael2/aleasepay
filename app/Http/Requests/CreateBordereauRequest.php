<?php

namespace App\Http\Requests;

use App\Models\Bordereau;
use Illuminate\Foundation\Http\FormRequest;

class CreateBordereauRequest extends FormRequest
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
        return Bordereau::$rules;
    }
}
