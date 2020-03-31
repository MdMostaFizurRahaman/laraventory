<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;


class ProductRequest extends FormRequest
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
                        Rule::unique('products', 'name')->where('client_id', Auth::user()->client_id)->whereNull('deleted_at'),
                        'max:191'
                    ],
                    'code'  =>
                    [
                        'required',
                        Rule::unique('products', 'code')->where('client_id', Auth::user()->client_id)->whereNull('deleted_at'),
                        'max:191'
                    ],
                    'description' => 'max:500',
                    'sale_price' => 'required|numeric|min:0',
                    // 'opening_quantity' => 'required|numeric|min:0',
                    'batch_quantity' => 'required|numeric|min:1',
                    'category_id' => 'required',
                    'unit_id' => 'required',
                    'currency_id' => 'required',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name'  =>
                    [
                        'required',
                        Rule::unique('products', 'name')->where('client_id', Auth::user()->client_id)->whereNull('deleted_at')->ignore($this->product->id),
                        'max:191'
                    ],
                    'code'  =>
                    [
                        'required',
                        Rule::unique('products', 'code')->where('client_id', Auth::user()->client_id)->whereNull('deleted_at')->ignore($this->product->id),
                        'max:191'
                    ],
                    'description' => 'max:500',
                    'sale_price' => 'required|numeric|min:0',
                    'category_id' => 'required',
                    'batch_quantity' => 'required|numeric|min:1',
                    'unit_id' => 'required',
                    'currency_id' => 'required',
                ];
            }
            default:break;
        }
    }
}
