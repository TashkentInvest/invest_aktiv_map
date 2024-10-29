<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UzbekName implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

     protected $pattern = '/^[a-zçğııjklnmopqrstuvwxyzə\s]+$/iu';

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
        return preg_match($this->pattern, $value);

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute faqat toʻgʻri Oʻzbek lotin harflaridan iborat boʻlishi kerak.';
    }
}
