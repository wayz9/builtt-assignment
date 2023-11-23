<?php

namespace Database\Seeders;

use App\Enum\SizeUnit;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect([
            [
                'name' => 'Coconut Butter',
                'price' => 67200,
                'size' => 200,
                'size_unit' => SizeUnit::Gram,
            ], [
                'name' => 'Chia Seeds',
                'price' => 12000,
                'size' => 100,
                'size_unit' => SizeUnit::Gram,
            ], [
                'name' => 'Evening Primrose Oil',
                'price' => 120000,
                'size' => 100,
                'size_unit' => SizeUnit::Mililiter,
            ], [
                'name' => 'Grape Seed Extract',
                'price' => 65000,
                'size' => 100,
                'size_unit' => SizeUnit::Gram,
            ], [
                'name' => 'Cold Pressed Grapeseed Oil',
                'price' => 115000,
                'size' => 100,
                'size_unit' => SizeUnit::Mililiter,
            ], [
                'name' => 'Hazelnut Butter',
                'price' => 75000,
                'size' => 200,
                'size_unit' => SizeUnit::Gram,
            ], [
                'name' => 'Protein Bar with Cranberry',
                'price' => 25000,
                'size' => 30,
                'size_unit' => SizeUnit::Gram,
            ], [
                'name' => 'Protein Bar with Hazelnut',
                'price' => 45000,
                'size' => 60,
                'size_unit' => SizeUnit::Gram,
            ], [
                'name' => 'Protein Bar with Pumpkin Seed',
                'price' => 35000,
                'size' => 45,
                'size_unit' => SizeUnit::Gram,
            ], [
                'name' => 'Naturela with Carob and Agave Sugar',
                'price' => 145000,
                'size' => 200,
                'size_unit' => SizeUnit::Gram,
            ], [
                'name' => 'Cold Pressed Light Sesame Oil',
                'price' => 75000,
                'size' => 1,
                'size_unit' => SizeUnit::Liter,
            ], [
                'name' => 'Protein Bar with Sunflower Seed & Flaxseed',
                'price' => 225000,
                'size' => 200,
                'size_unit' => SizeUnit::Gram,
            ]
        ])->each(function (array $data, int $index): void {
            $product = Product::create($data + [
                'stock' => rand(10, 100),
            ]);

            $product->updateImage(new UploadedFile(
                database_path("seeders/images/{$index}.webp"),
                "{$index}.webp"
            ));
        });
    }
}
