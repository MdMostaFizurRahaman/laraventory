<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class ProductionCostRequest extends FormRequest
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
        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                    return [];
                }
            case 'POST': {
                    return [
                        'category_id'  => 'required',
                        'amount' => 'required',
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'category_id'  => 'required',
                        'amount' => 'required'
                    ];
                }
            default:
                break;
        }
    }
}
