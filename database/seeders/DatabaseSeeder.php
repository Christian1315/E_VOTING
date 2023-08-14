<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'admin',
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => '$2y$10$CI5P59ICr/HOihqlnYUrLeKwCajgMKd34HB66.JsJBrIOQY9fazrG', #admin
                'is_super_admin' => true,
                'phone' => "22961765591",
            ],
            [
                'name' => 'Joel PPJ',
                'username' => 'ppjjoel',
                'email' => 'ppjjoel@gmail.com',
                'password' => '$2y$10$ZT2msbcfYEUWGUucpnrHwekWMBDe1H0zGrvB.pzQGpepF8zoaGIMC', #ppjjoel
                'is_super_admin' => true,
                'phone' => "22961765592",
            ]
        ];

        foreach ($users as $user) {
            \App\Models\User::factory()->create($user);
        }

        ###========CREATION DES STATUS DE VOTE PAR DEFAUT ==========###
        $vote_status = [
            [
                'name' => 'En Attente',
            ],
            [
                'name' => 'En Cour',
            ],
            [
                'name' => 'Terminé',
            ],
            [
                'name' => 'Annulé',
            ],
        ];

        foreach ($vote_status as $status) {
            \App\Models\VoteStatus::factory()->create($status);
        }
    }
}
