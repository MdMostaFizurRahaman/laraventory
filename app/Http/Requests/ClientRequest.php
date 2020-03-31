<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientRequest extends FormRequest
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
                    'name' => 'required',
                    'email' => [
                        'required',
                        Rule::unique('clients', 'email')->whereNull('deleted_at'),
                        'email'
                    ],
                    'secondary_email' => 'sometimes|nullable|email',
                    'phone' => [
                        'required',
                        'regex:/^(01)[1,5,6,7,8,9]{1}[0-9]{8}$/',
                    ],
                    'client_url' => [
                        'required',
                        'regex:/^[\w-]*$/',
                        Rule::unique('clients', 'client_url')->whereNull('deleted_at'),
                    ],
                    'contact_person_name' => 'required',
                    'contact_person_phone' => 'required',
                    'contact_person_email' => 'required|email',
                    'address' => 'required',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name' => 'required',
                    'email' => [
                        'required',
                        Rule::unique('clients', 'email')->whereNull('deleted_at')->ignore($this->client->id),
                        'email'
                    ],
                    'secondary_email' => 'sometimes|nullable|email',
                    'phone' => [
                        'required',
                        'regex:/^(01)[1,5,6,7,8,9]{1}[0-9]{8}$/',
                    ],
                    'client_url' => [
                        'required',
                        'regex:/^[\w-]*$/',
                        Rule::unique('clients', 'client_url')->whereNull('deleted_at')->ignore($this->client->id),
                    ],
                    'contact_person_name' => 'required',
                    'contact_person_phone' => 'required',
                    'contact_person_email' => 'required|email',
                    'address' => 'required',
                ];
            }
            default:break;
        }
    }
}
