<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class vlidateformadminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'admin_name' => 'required|regex:/^[\pL\s\-]+$/u',
            'admin_mobile' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [

            'admin_name.required' => 'Veillez entrer le nom de l\admin',
            'email.regex' => 'Le nom de l\admin est invalide',
            'admin_mobile.required' => 'Veillez entrer le numéro de téléphone ',
            'admin_mobile.required' => 'numéro de téléphone invalide ',
        ];
    }

    public function rule()
    {
        return [
            'admin_name' => 'required|regex:/^[\pL\s\-]+$/u',
            'admin_mobile' => 'required|numeric',
        ];
    }

    public function message()
    {
        return [

            'admin_name.required' => 'Veillez entrer le nom de l\admin',
            'email.regex' => 'Le nom de l\admin est invalide',
            'admin_mobile.required' => 'Veillez entrer le numéro de téléphone ',
            'admin_mobile.required' => 'numéro de téléphone invalide ',
        ];
    }
}
