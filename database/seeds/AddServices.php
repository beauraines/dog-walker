<?php

use App\Service;
use Illuminate\Database\Seeder;

class AddServices extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Service::create(
            [
                'name'                  => 'walk',
                'description'           => 'Walk',
                'base_price'            => 20.0,
                'incremental_pet_price' => 10,
            ]
        );
        Service::create(
            [
                'name'                  => 'visit',
                'description'           => 'Visit and play',
                'base_price'            => 15.0,
                'incremental_pet_price' => 5,
            ]
        );
    }
}
