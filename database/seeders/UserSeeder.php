<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Laravel\Passport\Bridge\ClientRepository;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run( ): void
    {

        User::factory(15)->create();
    }
}
