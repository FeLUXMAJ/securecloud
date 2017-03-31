<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|unique:users,name',
            'photo' => 'required',
            'password' => 'required',
            'passwordConfirm' => 'required|same:password'
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
            'name.required'   => 'Bitte gib dir einen Username. Damit loggst du dich später ein.',
			'name.unique'  => 'Der Name ist bereits vergeben.',
			'photo.required'  => 'Bitte mach ein Foto von dir, damit du dich später authentifizieren kannst.',
            'password.required' => 'Bitte gib ein Passwort ein, dass du im Notfall verwenden kannst, wenn du nicht erkannt wirst.',
            'passwordConfirm.required' => 'Bitte gib ein Passwort ein, dass du im Notfall verwenden kannst, wenn du nicht erkannt wirst.',
            'passwordConfirm.same' => 'Deine Passwörter stimmen nicht überein.',
        ];
    }

}
