<?php

namespace Database\Seeders;

use App\Models\Property;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(database_path('seeders/data/property-data.csv'), 'r');

        $cols = [
            'name',
            'price',
            'bedrooms',
            'bathrooms',
            'storeys',
            'garages',
        ];

        $isHeader = true;
        while (($data = fgetcsv($csvFile, 2000, ',')) !== false) {
            if (! $isHeader) {
                Property::create(array_combine($cols, $data));
            }

            $isHeader = false;
        }

        fclose($csvFile);
    }
}
