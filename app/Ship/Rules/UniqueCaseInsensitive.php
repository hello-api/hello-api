<?php

namespace App\Ship\Rules;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class UniqueCaseInsensitive implements ValidationRule
{
    public function __construct(
        private readonly string $table,
        private readonly string $column,
    ) {
    }

    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        // TODO: (Maybe?) Don't use DB::table() directly, use a repository instead
        $exists = DB::table($this->table)
            ->whereRaw("lower({$this->column}) = lower(?)", [$value])
            ->exists();

        if ($exists) {
            $fail('The :attribute has already been taken.');
        }
    }
}
