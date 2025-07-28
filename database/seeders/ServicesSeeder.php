<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'service_title' => 'Asmeninė treniruotė'
            ],
            [
                'service_title' => 'Asmeninė konsultacija'
            ],
            [
                'service_title' => 'Mitybos plano sudarymas'
            ],
            [
                'service_title' => 'Atletinis testavimas'
            ]
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
