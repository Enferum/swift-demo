<?php

namespace App\Models;

use Faker\Generator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Redbastie\Swift\Traits\SwiftModel;

class Dashboard extends Model
{
    use SwiftModel;

    public function migration(Blueprint $table)
    {
        $table->id();
        $table->string('name');
        $table->string('universe');
        $table->string('color');
        $table->string('superpower');
        $table->timestamps();
    }

    public function definition(Generator $faker)
    {
        return [
            'name' => $faker->name,
            'universe' => $faker->randomElement(['DC','Marvel']),
            'color' => $faker->randomElement(['Red','Green','Black']),
            'superpower' => $faker->randomElement([true,false]),
        ];
    }
}
