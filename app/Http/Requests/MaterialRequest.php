<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class MaterialRequest extends FormRequest
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
                        Rule::unique('materials', 'name')->where('client_id', Auth::user()->client_id)->whereNull('deleted_at'),
                        'max:191'
                    ],
                    'description' => 'max:500',
                    'opening_stock' => 'required|numeric|min:0',
                    'alert_quantity' => 'required|numeric|min:0',
                    'category_id' => 'required',
                    'unit_id' => 'required',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name'  =>
                    [
                        'required',
                        Rule::unique('materials', 'name')->whereNull('deleted_at')->where('client_id', Auth::user()->client_id)->ignore($this->material->id),
                        'max:191'
                    ],
                    'description' => 'max:500',
                    'alert_quantity' => 'required|numeric|min:0',
                    'category_id' => 'required',
                    'unit_id' => 'required',
                ];
            }
            default:break;
        }
    }
}
