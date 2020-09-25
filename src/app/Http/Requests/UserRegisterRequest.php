<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
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
            'name' => [
                'required', 'string', 'max:20',
                function($attribute, $value, $fail) {
                    // NOTE: 新規ユーザー登録を凍結
                    return $fail(__('message.VALIDATION.SIGNUP.DISABLED'));
                },
            ],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'c_alpha_num', 'min:8', 'confirmed'],
        ];
    }
}
