<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ZoneNameMatchesKzId implements Rule
{
    protected $kzId;
    protected $errorMessage;

    public function __construct($kzId)
    {
        $this->kzId = $kzId;
    }

    public function passes($attribute, $value)
    {
        // Ensure that the zone name matches "{kz_id}-zona"
        $expectedZoneName = "{$this->kzId}-zona";

        if ($value !== $expectedZoneName) {
            $this->errorMessage = "The zone name must be '{$expectedZoneName}'.";
            return false;
        }

        return true;
    }

    public function message()
    {
        return $this->errorMessage;
    }
}
