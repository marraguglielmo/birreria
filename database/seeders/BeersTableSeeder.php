<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Beer;
use Illuminate\Support\Str;

class BeersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // effettuo la chiamata API e salvo il dato in una varibile
        $data_str = file_get_contents('https://api.sampleapis.com/beers/ale');
        // trasformo la striga in un array di oggetti PHP
        $data = json_decode($data_str);

        foreach($data as $beer){
            $new_beer = new Beer();
            $new_beer->price = $beer->price;
            $new_beer->name = $beer->name;
            $new_beer->slug = $this->generateSlug($beer->name);
            $new_beer->rating_average = $beer->rating->average;
            $new_beer->rating_reviews = $beer->rating->reviews;
            $new_beer->image = $beer->image;
            $new_beer->save();
        }


    }

    private function generateSlug($string){
        /*
            1. ricevo la stringa da "sluggare"
            2. genero lo slug
            3. faccio una query per vedere se lo slug è già presente nel db
            4. SE non è presente restituisco lo slug
            5. SE è presnte ne genero un'altro con un valore incrementale e ad ogni generazione verifico che non sia presente
            6. una volta trovato uno slug non presente lo restituisco
        */

        // 2.
        $slug = Str::slug($string, '-');
        $original_slug = $slug;

        // 3.
        $exixts = Beer::where('slug', $slug)->first();
        $c = 1;

        while($exixts){
            $slug = $original_slug . '-' . $c;
            $exixts = Beer::where('slug', $slug)->first();
            $c++;
        }

        // 5.
        return $slug;
    }
}












