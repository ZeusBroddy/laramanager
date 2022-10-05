<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateUniversity extends FormRequest
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

        return [
            'name' => ['required', 'string', 'min:3', 'max:50', "unique:universities,name,{$id},id"],
            'avatar' => ['nullable', 'image'],
            'address' => ['nullable', 'string', 'max:80'],
            'district' => ['nullable', 'string', 'max:80'],
            'city' => ['nullable', 'string', 'max:80']
        ];
    }
}
