<?php

namespace Database\Seeders;

use App\Models\Type;
use Faker\Generator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Generator $faker): void
    {
        $labels = ['FrontEnd', 'BackEnd', 'FullStack'];

        foreach ($labels as $label) {
            $types = new Type();
            $types->label = $label;
            $types->color = $faker->hexColor();
            $types->save();
        }
    }
}
