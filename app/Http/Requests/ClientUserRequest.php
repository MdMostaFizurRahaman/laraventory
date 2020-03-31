<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientUserRequest extends FormRequest
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
        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
                    'client_id' => 'required',
                    'role_id' => 'required',
                    'name' => 'required',
                    'email' => [
                        'required',
                        Rule::unique('users', 'email')->where('client_id', request()->client_id)->whereNull('deleted_at'),
                        'email'
                    ],
                    'password' => 'required|min:6|confirmed',
                    'password_confirmation' => 'required|min:6',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'role_id' => 'required',
                    'name' => 'required',
                    'email' => [
                        'required',
                        Rule::unique('users', 'email')->where('client_id', $this->client_user->client_id)->whereNull('deleted_at')->ignore($this->client_user->id),
                        'email'
                    ],
                ];
            }
            default:break;
        }
    }

    public function messages()
    {
        return [
            'client_id.required' => 'Client field is required',
            'role_id.required' => 'Role field is required',
            'name.required' => 'Name field is required',
            'email.required' => 'Email field is required',
            'email.unique' => 'Email already exists',
            'password.required' => 'Password field is required',
            'password_confirmation.required' => 'Confirm Password field is required',
        ];
    }
}
