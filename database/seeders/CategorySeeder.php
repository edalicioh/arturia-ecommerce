<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' =>  "Telefonia"],
            ['name' =>  "Eletrodomésticos"],
            ['name' =>  "TVs e Vídeo"],
            ['name' =>  "Móveis"],
            ['name' =>  "Eletroportáteis"],
            ['name' =>  "Informática"],
        ];

        Category::insert($categories);
    }
}
