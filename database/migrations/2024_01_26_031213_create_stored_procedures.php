<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('DROP PROCEDURE IF EXISTS sp_insert_user');
        DB::statement('
            CREATE PROCEDURE sp_insert_user(
                IN _name VARCHAR(255),
                IN _email VARCHAR(255),
                IN _password VARCHAR(255),
                OUT last_id INT
            )
            BEGIN
                INSERT INTO users (name, email, password)
                VALUES (_name, _email, _password);
                
                SET last_id = LAST_INSERT_ID();
            END
        ');
            
        DB::statement('DROP PROCEDURE IF EXISTS sp_update_user');
        DB::statement('
            CREATE PROCEDURE sp_update_user(
                IN _id BIGINT,
                IN _name VARCHAR(255),
                IN _email VARCHAR(255)
            )
            BEGIN
                UPDATE users SET name = _name, email = _email
                WHERE id = _id;
            END
        ');

        DB::statement('DROP PROCEDURE IF EXISTS sp_delete_user');
        DB::statement('
            CREATE PROCEDURE sp_delete_user(
                IN _id BIGINT
            )
            BEGIN
                DELETE FROM users WHERE id = _id;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP PROCEDURE IF EXISTS sp_insert_user');
        DB::statement('DROP PROCEDURE IF EXISTS sp_update_user');
        DB::statement('DROP PROCEDURE IF EXISTS sp_delete_user');
    }
};
