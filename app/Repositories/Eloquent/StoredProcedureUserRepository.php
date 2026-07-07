<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

final class StoredProcedureUserRepository implements UserRepositoryInterface
{
    public function findByEmail(string $email): ?User
    {
        // Invocamos el Stored Procedure de forma segura usando placeholders (?)
        $results = DB::select("CALL sp_authenticate_user(?)", [$email]);

        if (empty($results)) {
            return null;
        }

        $rawUser = $results[0];

        $user = new User();
        $user->exists = true; // Le indicamos a Laravel que este registro ya existe

        $user->forceFill([
            "id" => $rawUser->id,
            "name" => $rawUser->name,
            "email" => $rawUser->email,
            "password" => $rawUser->password,
        ]);

        return $user;
    }
}
