<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductionRequest extends FormRequest
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
            case 'POST':
            case 'PUT': {
                    return [
                        'name' => 'required|max:191',
                        // 'quantity' => 'required|numeric|min:1',
                        'production_date' => 'required|date',
                    ];
                }
            case 'PATCH': {
                    return [
                        'quantity' => 'required|numeric|min:1',
                        'finish_date' => 'required|date',
                        'note' => 'nullable|string|max:191',
                    ];
                }
            default:
                break;
        }
    }
}
