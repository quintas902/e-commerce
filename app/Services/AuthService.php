<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\LoginDTO;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

final class AuthService
{
    // Inyección de dependencias a través del constructor
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {}

    public function authenticate(LoginDTO $dto): bool
    {
        $credentials = [
            "email" => $dto->email,
            "password" => $dto->password,
        ];

        if (!Auth::attempt($credentials, $dto->remember)) {
            // Si las credenciales fallan, lanzamos una excepción nativa de validación estructurada
            throw ValidationException::withMessages([
                "email" => __("auth.failed"),
            ]);
        }

        // Regenerar la sesión para mitigar ataques de fijación de sesión
        request()->session()->regenerate();

        return true;
    }
}
