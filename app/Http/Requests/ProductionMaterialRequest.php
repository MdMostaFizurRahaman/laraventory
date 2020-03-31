<?php

namespace App\Http\Requests;

use App\Rules\ProductionQuantityValidation;
use Illuminate\Foundation\Http\FormRequest;

class ProductionMaterialRequest extends FormRequest
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
                        'purchase_material_id' => 'required',
                        'quantity' => ['required', 'numeric', 'min:1', new ProductionQuantityValidation($this->request->get('purchase_material_id'))],
                        'note' => 'nullable|string|max:191',
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'purchase_material_id' => 'required',
                        'quantity' => ['required', 'numeric', 'min:1', new ProductionQuantityValidation($this->request->get('purchase_material_id'))],
                        'note' => 'nullable|string|max:191',
                    ];
                }
            default:
                break;
        }
    }
}
