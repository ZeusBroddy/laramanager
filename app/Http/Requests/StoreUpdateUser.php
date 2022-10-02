<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;

class StoreUpdateUser extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $id = $this->segment(3);

        $rules = [
            'cpf' => ['required', 'cpf', "unique:profiles,cpf,{$id},id"],
            'role' => ['required', Rule::in(['admin', 'user'])],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', "unique:users,email,{$id},id"],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];

        if ($this->method() == 'PUT') {
            $rules['password'] = 'nullable';
        };

        return $rules;
    }
}
