<?php

namespace App\Http\Requests\Admin;

use App\Rules\CheckOldPassword;
use Illuminate\Foundation\Http\FormRequest;

class ProfilePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        return [
            'old_password' => ['required',new CheckOldPassword],
            'password' => 'required|confirmed',


        ];

    }//end of rules


}
