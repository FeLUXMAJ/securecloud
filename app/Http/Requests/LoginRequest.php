<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'name' => 'required|exists:users,name',
            'photo' => 'required',
        ];
    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Bitte gib deinen Username ein.',
            'name.exists' => 'Dein Username existiert nicht.',
            'photo.required' => 'Bitte mache ein Foto von dir um dich zu authentifizieren.',
        ];
    }

}
