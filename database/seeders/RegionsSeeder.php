<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('regions')->insert(array(
            0 =>
            array(
                'id' => 1,
                'name' => 'Arusha',
            ),
            1 =>
            array(
                'id' => 2,
                'name' => 'Dar es salaam',
            ),
            2 =>
            array(
                'id' => 3,
                'name' => 'Dodoma',
            ),
            3 =>
            array(
                'id' => 4,
                'name' => 'Geita',
            ),
            4 =>
            array(
                'id' => 5,
                'name' => 'Iringa',
            ),
            5 =>
            array(
                'id' => 6,
                'name' => 'Kagera',
            ),
            6 =>
            array(
                'id' => 7,
                'name' => 'Katavi',
            ),
            7 =>
            array(
                'id' => 8,
                'name' => 'Kigoma',
            ),
            8 =>
            array(
                'id' => 9,
                'name' => 'Kilimanjaro',
            ),
            9 =>
            array(
                'id' => 10,
                'name' => 'Lindi',
            ),
            10 =>
            array(
                'id' => 11,
                'name' => 'Manyara',
            ),
            11 =>
            array(
                'id' => 12,
                'name' => 'Mara',
            ),
            12 =>
            array(
                'id' => 13,
                'name' => 'Mbeya',
            ),
            13 =>
            array(
                'id' => 14,
                'name' => 'Morogoro',
            ),
            14 =>
            array(
                'id' => 15,
                'name' => 'Mtwara',
            ),
            15 =>
            array(
                'id' => 16,
                'name' => 'Mwanza',
            ),
            16 =>
            array(
                'id' => 17,
                'name' => 'Njombe',
            ),
            17 =>
            array(
                'id' => 18,
                'name' => 'Pwani',
            ),
            18 =>
            array(
                'id' => 19,
                'name' => 'Rukwa',
            ),
            19 =>
            array(
                'id' => 20,
                'name' => 'Ruvuma',
            ),
            20 =>
            array(
                'id' => 21,
                'name' => 'Shinyanga',
            ),
            21 =>
            array(
                'id' => 22,
                'name' => 'Simiyu',
            ),
            22 =>
            array(
                'id' => 23,
                'name' => 'Singida',
            ),
            23 =>
            array(
                'id' => 24,
                'name' => 'Songwe',
            ),
            24 =>
            array(
                'id' => 25,
                'name' => 'Tabora',
            ),
            25 =>
            array(
                'id' => 26,
                'name' => 'Tanga',
            ),
        ));
    }
}
