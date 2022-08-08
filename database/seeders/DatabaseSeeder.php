<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
class DatabaseSeeder extends Seeder
{


    public function run()
    {
        $faker=Faker::create('ru_RU');
        foreach (range(1,500) as $index)
        {
            \DB::table('employees')->insert([
                'name' => $faker->name(),
                'position' => $faker->realText(10),
                'date' => $faker->date(),
                'salary' => $faker->randomNumber(4),
                'boss' => $faker->randomNumber(3),
                'image'=>' '
            ]);
        }

    }
}
