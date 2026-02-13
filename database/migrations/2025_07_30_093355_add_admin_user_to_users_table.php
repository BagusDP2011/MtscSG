<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class AddAdminUserToUsersTable extends Migration
{
    public function up(): void
    {
        DB::table('users')->insert([
            'user_id' => 1,
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => '$2y$10$7dN5zrYhA2OdWUHZHINWj.oi.2xMRYp7bCZyJaTzq1cb2xu47/H9q',
            'remember_token' => 'b36mRP1DAX24bRhparPpIJMkiIWeB7hP2TDZu1cgqhLe1vnx6Aomkm3FNtX9',
            'created_at' => Carbon::parse('2025-04-21 01:04:06'),
            'updated_at' => null,
            'role' => 'admin',
        ]);
        DB::table('users')->insert([
            'user_id' => 2,
            'name' => 'Bagus',
            'email' => 'bagusdp2011@gmail.com',
            'password' => Hash::make('123123'), // hash password baru
            'remember_token' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'role' => 'admin',
        ]);
    }

    public function down(): void
    {
        DB::table('users')->where('user_id', 1)->delete();
    }
}
