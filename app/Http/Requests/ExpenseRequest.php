<?php

namespace App\Http\Requests;

use App\Rules\ExpenseAmountRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ExpenseRequest extends FormRequest
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
    public function rules(Request $request)
    {
        return [
            'expense_date' => 'required',
            'description' => 'required|max:191',
            'amount' => ['required', 'numeric', 'min:1', new ExpenseAmountRule($request->account_id)],
            'account_id' => 'required'
        ];
    }
}
