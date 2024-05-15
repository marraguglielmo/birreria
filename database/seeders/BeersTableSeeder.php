<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BeersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data_string = file_get_contents('https://api.sampleapis.com/beers/ale');
        $data = json_decode($data_string);
        dump($data);
    }
}
