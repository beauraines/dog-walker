<?php

use Illuminate\Database\Seeder;
use App\PetType;

class PetTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PetType::create(['pet_type' => 'cat']);
        PetType::create(['pet_type' => 'dog']);
    }
}
