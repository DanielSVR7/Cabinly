<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Cabin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
/*
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
*/
        Admin::query()->updateOrCreate(
            ['email' => 'admin@pine.local'],
            [
                'name' => 'Администратор',
                'password' => Hash::make('change-me'),
            ]
        );

        Cabin::query()->updateOrCreate(
            ['name' => 'Домик у озера'],
            [
                'location' => 'Берег озера',
                'description' => 'Уютный домик с видом на воду и собственной террасой.',
                'capacity' => 4,
                'price_per_night' => 4200,
                'is_active' => true,
            ]
        );

        Cabin::query()->updateOrCreate(
            ['name' => 'Семейный коттедж'],
            [
                'location' => 'Сосновая поляна',
                'description' => 'Просторный коттедж для семьи, рядом зона барбекю.',
                'capacity' => 6,
                'price_per_night' => 5600,
                'is_active' => true,
            ]
        );

        Cabin::query()->updateOrCreate(
            ['name' => 'Домик на двоих'],
            [
                'location' => 'Тихая опушка',
                'description' => 'Идеально для романтического отдыха и прогулок.',
                'capacity' => 2,
                'price_per_night' => 3200,
                'is_active' => true,
            ]
        );
    }
}
