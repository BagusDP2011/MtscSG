<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AddAdminUserToUsersTable extends Migration
{
    public function up(): void
    {
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => null,
            'password' => '$2y$10$7dN5zrYhA2OdWUHZHINWj.oi.2xMRYp7bCZyJaTzq1cb2xu47/H9q',
            'remember_token' => 'b36mRP1DAX24bRhparPpIJMkiIWeB7hP2TDZu1cgqhLe1vnx6Aomkm3FNtX9',
            'created_at' => Carbon::parse('2025-04-21 01:04:06'),
            'updated_at' => null,
            'role' => 'admin',
        ]);
    }

    public function down(): void
    {
        DB::table('users')->where('id', 1)->delete();
    }
}
