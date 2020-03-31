<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
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
                    'name'  =>
                    [
                        'required',
                        Rule::unique('branches', 'name')->where('client_id', Auth::user()->client_id)->whereNull('deleted_at'),
                        'max:191'
                    ],
                    'mobile' => 'required|regex:/^(01)[1,5,6,7,8,9]{1}[0-9]{8}$/',
                    'email' =>
                    [
                        'required',
                        Rule::unique('branches', 'email')->where('client_id', Auth::user()->client_id)->whereNull('deleted_at'),
                        'email'
                    ],
                    'address' => 'required|max:191',
                    'manager_id' => 'required',
                    'type' => 'required',
                    'status' => 'required',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name'  =>
                    [
                        'required',
                        Rule::unique('branches', 'name')->whereNull('deleted_at')->where('client_id', Auth::user()->client_id)->ignore($this->branch->id),
                        'max:191'
                    ],
                    'mobile' => 'required|regex:/^(01)[1,5,6,7,8,9]{1}[0-9]{8}$/',
                    'email' =>
                    [
                        'required',
                        Rule::unique('branches', 'email')->whereNull('deleted_at')->where('client_id', Auth::user()->client_id)->ignore($this->branch->id),
                        'email'
                    ],
                    'manager_id' => 'required',
                    'type' => 'required',
                    'status' => 'required',
                ];
            }
            default:break;
        }
    }
}
