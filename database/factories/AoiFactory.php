<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AoiFactory extends Factory
{
    public function definition(): array
    {
        return [
            'PartNum'        => $this->faker->unique()->bothify('####-####'),
            'PartDesc'       => $this->faker->words(2, true),
            'WareHouseCode'  => 'BATAM',
            'BinNum'         => 'AOI',
            'MainTranQty'    => 10,
            'PhysicalQty'    => 10,
            'mtscbat_remarks'=> null,
            'pictures'       => '',
        ];
    }
}