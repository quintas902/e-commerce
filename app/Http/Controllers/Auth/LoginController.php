<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\DTOs\LoginDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class LoginController extends Controller
{
    public function __construct(private readonly AuthService $authService) {}

    public function showLoginForm(): View
    {
        return view("auth.login");
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        // Construimos el DTO inmutable garantizando la limpieza de tipos
        $dto = new LoginDTO(
            email: $request->validated("email"),
            password: $request->validated("password"),
            remember: (bool) $request->validated("remember", false),
        );

        $this->authService->authenticate($dto);

        return redirect()->intended(route("dashboard"));
    }
}
