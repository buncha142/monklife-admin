<?php

namespace Database\Seeders;

use App\Models\CRS\Car;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * ข้อมูลรถ
     */
    public function run(): void
    {
        $cars = [
            ['name' => 'รถตู้ Toyota Commuter', 'is_active' => true, 'is_default' => true],
            ['name' => 'รถกระบะ Isuzu D-Max', 'is_active' => true, 'is_default' => false],
            ['name' => 'รถเก๋ง Toyota Camry', 'is_active' => true, 'is_default' => false],
        ];

        foreach ($cars as $car) {
            Car::updateOrCreate(['name' => $car['name']], $car);
        }
    }
}
