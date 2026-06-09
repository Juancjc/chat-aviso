<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ProfileEmoji implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (
            ! is_string($value)
            || mb_strlen($value) > 32
            || preg_match('/[\p{Extended_Pictographic}\p{Regional_Indicator}\x{20E3}]/u', $value) !== 1
        ) {
            $fail('Escolha um emoji válido para o perfil.');
        }
    }
}
