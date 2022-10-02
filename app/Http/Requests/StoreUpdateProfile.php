<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateProfile extends FormRequest
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
        return [
            'address' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'min:2', 'max:2'],
            'city' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'min:8' ,'max:8'],
            'state' => ['required', 'uf', 'min:2', 'max:2'],
            'phone_number' => ['required', 'string', 'min:11', 'max:11']
        ];
    }
}
