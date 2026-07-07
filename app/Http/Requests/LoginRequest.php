<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Cualquiera puede intentar loguearse
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            "email" => ["required", "string", "email"],
            "password" => ["required", "string"],
            "remember" => ["nullable", "boolean"],
        ];
    }
}
