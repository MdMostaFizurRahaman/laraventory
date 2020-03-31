<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UnitRequest extends FormRequest
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
                        Rule::unique('units', 'name')->where('client_id', Auth::user()->client_id),
                        'max:191'
                    ],
                    'display_name'  =>
                    [
                        'required',
                        Rule::unique('units', 'display_name')->where('client_id', Auth::user()->client_id),
                        'max:191'
                    ],
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name'  =>
                    [
                        'required',
                        Rule::unique('units', 'name')->where('client_id', Auth::user()->client_id)->ignore($this->unit->id),
                        'max:191'
                    ],
                    'display_name'  =>
                    [
                        'required',
                        Rule::unique('units', 'display_name')->where('client_id', Auth::user()->client_id)->ignore($this->unit->id),
                        'max:5'
                    ],
                ];
            }
            default:break;
        }
    }
}
