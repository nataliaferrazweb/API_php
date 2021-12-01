<?php

declare(strict_types=1);

namespace App\Controllers;

class ValidateController
{
    /**
     * ValidateController constructor.
     */
    public function __construct()
    {
    }

    public function validateVars($val): bool
    {
        if (is_null($val) || $val == '') {
            return true;
        }
        return false;
    }

}

