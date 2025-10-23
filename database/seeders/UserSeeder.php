<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
           'name' => 'rifqi maulana',
           'username' => 'rifqimaulana',
           'email' => 'admin@example.com',
           'email_verified_at' => now(),
           'password' => bcrypt('password'),
           'remember_token' => Str::random(10),
           'is_admin' => true, // <<< SET SEBAGAI ADMIN
       ]);
        User::factory(10)->create();
    }
}
