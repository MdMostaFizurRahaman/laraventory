<?php

namespace App\Rules;

use App\Models\PurchaseMaterial;
use Illuminate\Contracts\Validation\Rule;

class ProductionQuantityValidation implements Rule
{
    protected $receiveMaterial;
    protected $quantity;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($id, $quantity = 0)
    {
        $this->purchaseMaterial = PurchaseMaterial::find($id);
        $this->quantity = $quantity;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->purchaseMaterial->remainingQuantity + $this->quantity >= $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This quantity field can not greater than remaining quantity';
    }
}
