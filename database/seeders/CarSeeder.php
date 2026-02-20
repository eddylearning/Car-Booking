<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        $cars = [
            [
                'name' => 'Toyota Land Cruiser Sahara',
                'model' => '2023',
                'type' => 'SUV',
                'mileage' => 12000,
                'description' => 'Premium SUV suitable for family and long-distance travel.',
                'price_per_day' => 18000,
                'image' => 'images/toyota landcruzer sahara.avif',
                'available' => true,
            ],
            [
                'name' => 'Toyota Prado TX',
                'model' => '2018',
                'type' => 'SUV',
                'mileage' => 54000,
                'description' => 'Reliable SUV for urban and off-road use.',
                'price_per_day' => 14000,
                'image' => 'images/prado tx 2018.jpg',
                'available' => true,
            ],
            [
                'name' => 'Toyota Camry',
                'model' => '2021',
                'type' => 'Sedan',
                'mileage' => 35000,
                'description' => 'Comfortable sedan for business and daily trips.',
                'price_per_day' => 8000,
                'image' => 'images/toyota camry.jpg',
                'available' => true,
            ],
            [
                'name' => 'Nissan Leaf',
                'model' => '2022',
                'type' => 'Electric',
                'mileage' => 18000,
                'description' => 'Efficient electric car for city commuting.',
                'price_per_day' => 7500,
                'image' => 'images/nissan leaf.avif',
                'available' => true,
            ],
            [
                'name' => 'Audi Q7',
                'model' => '2020',
                'type' => 'SUV',
                'mileage' => 42000,
                'description' => 'Luxury SUV with spacious interior.',
                'price_per_day' => 16000,
                'image' => 'images/AUDI Q7.jpg',
                'available' => true,
            ],
            [
                'name' => 'BMW X6',
                'model' => '2021',
                'type' => 'SUV',
                'mileage' => 30000,
                'description' => 'Sporty premium SUV for executive travel.',
                'price_per_day' => 17000,
                'image' => 'images/BMW X6.jpg',
                'available' => true,
            ],
            [
                'name' => 'Volkswagen Polo',
                'model' => '2019',
                'type' => 'Hatchback',
                'mileage' => 50000,
                'description' => 'Compact and affordable hatchback.',
                'price_per_day' => 5000,
                'image' => 'images/vw polo.jpg',
                'available' => true,
            ],
            [
                'name' => 'Ford F-150',
                'model' => '2022',
                'type' => 'Pickup',
                'mileage' => 26000,
                'description' => 'Powerful pickup truck for utility and travel.',
                'price_per_day' => 15000,
                'image' => 'images/ford f-150.avif',
                'available' => true,
            ],
        ];

        foreach ($cars as $data) {
            Car::updateOrCreate(
                ['name' => $data['name'], 'model' => $data['model']],
                $data
            );
        }
    }
}
