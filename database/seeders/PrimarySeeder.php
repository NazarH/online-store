<?php

namespace Database\Seeders;

use App\Models\StaticPage;
use App\Models\User;
use Illuminate\Database\Seeder;

class PrimarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = ['admin', 'client'];

        foreach($users as $user) {
            User::factory()->create(
                [
                    'name' => $user,
                    'email' => $user.'@app.com',
                    'role' => $user
                ]
            );
        }

        $pages = ['home', 'about', 'policy', 'delivery'];

        foreach ($pages as $page) {
            StaticPage::factory()->create(
                [
                    'type' => $page,
                    'name' => $page,
                    'slug' => $page
                ]
            );
        }

    }
}
