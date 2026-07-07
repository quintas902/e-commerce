<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Eliminamos el procedimiento si ya existía para evitar errores de duplicación
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_authenticate_user");

        // Creamos el procedimiento almacenado para autenticar usuarios
        DB::unprepared("
            CREATE PROCEDURE sp_authenticate_user(
                IN p_email VARCHAR(255)
            )
            BEGIN
                -- Buscamos el usuario por su email y devolvemos las columnas necesarias
                SELECT id, name, email, password
                FROM users
                WHERE email = p_email
                LIMIT 1;
            END;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Si hacemos un rollback, destruimos el procedimiento del motor relacional
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_authenticate_user");
    }
};
