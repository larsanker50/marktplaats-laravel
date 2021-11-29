<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Postalcode;

class IsPostalCode implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $postalcode = Postalcode::where('postcode', '=', substr($value,0,4))->first();
        if ($postalcode) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The postal code does not exist.';
    }
}
