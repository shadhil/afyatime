<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        District::create([
            [
                'name' => 'Arusha Municipal',
                'region_id' => 1,
            ],
            [
                'name' => 'Arusha',
                'region_id' => 1,
            ],
            [
                'name' => 'Arumeru',
                'region_id' => 1,
            ],
            [
                'name' => 'Monduli',
                'region_id' => 1,
            ],
            [
                'name' => 'Longido',
                'region_id' => 1,
            ],
            [
                'name' => 'Karatu',
                'region_id' => 1,
            ],
            [
                'name' => 'Ngorongoro',
                'region_id' => 1,
            ],
            [
                'name' => 'Ilala',
                'region_id' => 2,
            ],
            [
                'name' => 'Kinondoni',
                'region_id' => 2,
            ],
            [
                'name' => 'Ubungo',
                'region_id' => 2,
            ],
            [
                'name' => 'Temeke',
                'region_id' => 2,
            ],
            [
                'name' => 'Kigamboni',
                'region_id' => 2,
            ],
            [
                'name' => 'Dodoma Municipal',
                'region_id' => 3,
            ],
            [
                'name' => 'Dodoma',
                'region_id' => 3,
            ],
            [
                'name' => 'Bahi ',
                'region_id' => 3,
            ],
            [
                'name' => 'Chamwino',
                'region_id' => 3,
            ],
            [
                'name' => 'Kongwa',
                'region_id' => 3,
            ],
            [
                'name' => 'Mpwapwa',
                'region_id' => 3,
            ],
            [
                'name' => 'Kondoa',
                'region_id' => 3,
            ],
            [
                'name' => 'Chemba',
                'region_id' => 3,
            ],
            [
                'name' => 'Geita',
                'region_id' => 4,
            ],
            [
                'name' => 'Nyang\'hwale',
                'region_id' => 4,
            ],
            [
                'name' => 'Chato',
                'region_id' => 4,
            ],
            [
                'name' => 'Mbogwe',
                'region_id' => 4,
            ],
            [
                'name' => 'Bukombe',
                'region_id' => 4,
            ],
            [
                'name' => 'Iringa Municipal',
                'region_id' => 5,
            ],
            [
                'name' => 'Iringa',
                'region_id' => 5,
            ],
            [
                'name' => 'Kilolo',
                'region_id' => 5,
            ],
            [
                'name' => 'Mufindi',
                'region_id' => 5,
            ],
            [
                'name' => 'Bukoba Municipal',
                'region_id' => 6,
            ],
            [
                'name' => 'Bukoba',
                'region_id' => 6,
            ],
            [
                'name' => 'Missenyi',
                'region_id' => 6,
            ],
            [
                'name' => 'Karagwe',
                'region_id' => 6,
            ],
            [
                'name' => 'Muleba',
                'region_id' => 6,
            ],
            [
                'name' => 'Biharamulo',
                'region_id' => 6,
            ],
            [
                'name' => 'Ngara',
                'region_id' => 6,
            ],
            [
                'name' => 'Kyerwa',
                'region_id' => 6,
            ],
            [
                'name' => 'Mpanda Municipal',
                'region_id' => 7,
            ],
            [
                'name' => 'Tanganyika',
                'region_id' => 7,
            ],
            [
                'name' => 'Mlele',
                'region_id' => 7,
            ],
            [
                'name' => 'Kigoma Municipal',
                'region_id' => 8,
            ],
            [
                'name' => 'Kigoma',
                'region_id' => 8,
            ],
            [
                'name' => 'Kasulu',
                'region_id' => 8,
            ],
            [
                'name' => 'Kibondo',
                'region_id' => 8,
            ],
            [
                'name' => 'Buhigwe',
                'region_id' => 8,
            ],
            [
                'name' => 'Uvinza',
                'region_id' => 8,
            ],
            [
                'name' => 'Kakonko',
                'region_id' => 8,
            ],
            [
                'name' => 'Moshi Municipal',
                'region_id' => 9,
            ],
            [
                'name' => 'Moshi',
                'region_id' => 9,
            ],
            [
                'name' => 'Hai',
                'region_id' => 9,
            ],
            [
                'name' => 'Siha',
                'region_id' => 9,
            ],
            [
                'name' => 'Mwanga',
                'region_id' => 9,
            ],
            [
                'name' => 'Same',
                'region_id' => 9,
            ],
            [
                'name' => 'Rombo',
                'region_id' => 9,
            ],
            [
                'name' => 'Lindi Municipal',
                'region_id' => 10,
            ],
            [
                'name' => 'Lindi',
                'region_id' => 10,
            ],
            [
                'name' => 'Nachingwea',
                'region_id' => 10,
            ],
            [
                'name' => 'Kilwa',
                'region_id' => 10,
            ],
            [
                'name' => 'Liwale',
                'region_id' => 10,
            ],
            [
                'name' => 'Ruangwa',
                'region_id' => 10,
            ],
            [
                'name' => 'Babati Municipal',
                'region_id' => 11,
            ],
            [
                'name' => 'Babati',
                'region_id' => 11,
            ],
            [
                'name' => 'Hanang\'',
                'region_id' => 11,
            ],
            [
                'name' => 'Mbulu',
                'region_id' => 11,
            ],
            [
                'name' => 'Kiteto',
                'region_id' => 11,
            ],
            [
                'name' => 'Simanjiro',
                'region_id' => 11,
            ],
            [
                'name' => 'Musoma',
                'region_id' => 12,
            ],
            [
                'name' => 'Butiama',
                'region_id' => 12,
            ],
            [
                'name' => 'Rorya',
                'region_id' => 12,
            ],
            [
                'name' => 'Tarime',
                'region_id' => 12,
            ],
            [
                'name' => 'Bunda',
                'region_id' => 12,
            ],
            [
                'name' => 'Serengeti',
                'region_id' => 12,
            ],
            [
                'name' => 'Mbeya Municipal',
                'region_id' => 13,
            ],
            [
                'name' => 'Mbeya',
                'region_id' => 13,
            ],
            [
                'name' => 'Rungwe',
                'region_id' => 13,
            ],
            [
                'name' => 'Mbarali',
                'region_id' => 13,
            ],
            [
                'name' => 'Kyela',
                'region_id' => 13,
            ],
            [
                'name' => 'Chunya',
                'region_id' => 13,
            ],
            [
                'name' => 'Morogoro Municipal',
                'region_id' => 14,
            ],
            [
                'name' => 'Morogoro',
                'region_id' => 14,
            ],
            [
                'name' => 'Mvomero',
                'region_id' => 14,
            ],
            [
                'name' => 'Kilosa',
                'region_id' => 14,
            ],
            [
                'name' => 'Kilombero',
                'region_id' => 14,
            ],
            [
                'name' => 'Ulanga',
                'region_id' => 14,
            ],
            [
                'name' => 'Gairo',
                'region_id' => 14,
            ],
            [
                'name' => 'Malinyi',
                'region_id' => 14,
            ],
            [
                'name' => 'Mtwara Municipal',
                'region_id' => 15,
            ],
            [
                'name' => 'Mtwara',
                'region_id' => 15,
            ],
            [
                'name' => 'Tandahimba',
                'region_id' => 15,
            ],
            [
                'name' => 'Newala',
                'region_id' => 15,
            ],
            [
                'name' => 'Masasi',
                'region_id' => 15,
            ],
            [
                'name' => 'Nanyumbu',
                'region_id' => 15,
            ],
            [
                'name' => 'Nyamagana',
                'region_id' => 16,
            ],
            [
                'name' => 'Ilemela',
                'region_id' => 16,
            ],
            [
                'name' => 'Sengerema',
                'region_id' => 16,
            ],
            [
                'name' => 'Magu',
                'region_id' => 16,
            ],
            [
                'name' => 'Misungwi',
                'region_id' => 16,
            ],
            [
                'name' => 'Ukerewe',
                'region_id' => 16,
            ],
            [
                'name' => 'Kwimba',
                'region_id' => 16,
            ],
            [
                'name' => 'Njombe Municipal',
                'region_id' => 17,
            ],
            [
                'name' => 'Njombe',
                'region_id' => 17,
            ],
            [
                'name' => 'Wanging\'onmbe',
                'region_id' => 17,
            ],
            [
                'name' => 'Ludewa',
                'region_id' => 17,
            ],
            [
                'name' => 'Makete',
                'region_id' => 17,
            ],
            [
                'name' => 'Kibaha Municipal',
                'region_id' => 18,
            ],
            [
                'name' => 'Kibaha',
                'region_id' => 18,
            ],
            [
                'name' => 'Bagamoyo',
                'region_id' => 18,
            ],
            [
                'name' => 'Kisarawe',
                'region_id' => 18,
            ],
            [
                'name' => 'Mkuranga',
                'region_id' => 18,
            ],
            [
                'name' => 'Rufiji',
                'region_id' => 18,
            ],
            [
                'name' => 'Mafia',
                'region_id' => 18,
            ],
            [
                'name' => 'Kibiti',
                'region_id' => 18,
            ],
            [
                'name' => 'Sumbawanga Municpal',
                'region_id' => 19,
            ],
            [
                'name' => 'Sumbawanga',
                'region_id' => 19,
            ],
            [
                'name' => 'Nkasi',
                'region_id' => 19,
            ],
            [
                'name' => 'Kalambo',
                'region_id' => 19,
            ],
            [
                'name' => 'Songea Municipal',
                'region_id' => 20,
            ],
            [
                'name' => 'Songea',
                'region_id' => 20,
            ],
            [
                'name' => 'Namtumbo',
                'region_id' => 20,
            ],
            [
                'name' => 'Mbinga',
                'region_id' => 20,
            ],
            [
                'name' => 'Nyasa',
                'region_id' => 20,
            ],
            [
                'name' => 'Tunduru',
                'region_id' => 20,
            ],
            [
                'name' => 'Shinyanga Municipal',
                'region_id' => 21,
            ],
            [
                'name' => 'Shinyanga',
                'region_id' => 21,
            ],
            [
                'name' => 'Kahama',
                'region_id' => 21,
            ],
            [
                'name' => 'Kishapu',
                'region_id' => 21,
            ],
            [
                'name' => 'Bariadi',
                'region_id' => 22,
            ],
            [
                'name' => 'Bariadi',
                'region_id' => 22,
            ],
            [
                'name' => 'Itilima',
                'region_id' => 22,
            ],
            [
                'name' => 'Maswa',
                'region_id' => 22,
            ],
            [
                'name' => 'Meatu',
                'region_id' => 22,
            ],
            [
                'name' => 'Busega',
                'region_id' => 22,
            ],
            [
                'name' => 'Singida Municipal',
                'region_id' => 23,
            ],
            [
                'name' => 'Singida',
                'region_id' => 23,
            ],
            [
                'name' => 'Iramba',
                'region_id' => 23,
            ],
            [
                'name' => 'Manyoni',
                'region_id' => 23,
            ],
            [
                'name' => 'Mkalama',
                'region_id' => 23,
            ],
            [
                'name' => 'Ikungi',
                'region_id' => 23,
            ],
            [
                'name' => 'Songwe',
                'region_id' => 24,
            ],
            [
                'name' => 'Mbozi',
                'region_id' => 24,
            ],
            [
                'name' => 'Ileje',
                'region_id' => 24,
            ],
            [
                'name' => 'Momba',
                'region_id' => 24,
            ],
            [
                'name' => 'Tabora',
                'region_id' => 25,
            ],
            [
                'name' => 'Uyui',
                'region_id' => 25,
            ],
            [
                'name' => 'Sikonge',
                'region_id' => 25,
            ],
            [
                'name' => 'Nzega',
                'region_id' => 25,
            ],
            [
                'name' => 'Urambo',
                'region_id' => 25,
            ],
            [
                'name' => 'Igunga',
                'region_id' => 25,
            ],
            [
                'name' => 'Kaliua',
                'region_id' => 25,
            ],
            [
                'name' => 'Tanga Municipal',
                'region_id' => 26,
            ],
            [
                'name' => 'Tanga',
                'region_id' => 26,
            ],
            [
                'name' => 'Pangani',
                'region_id' => 26,
            ],
            [
                'name' => 'Muheza',
                'region_id' => 26,
            ],
            [
                'name' => 'Mkinga',
                'region_id' => 26,
            ],
            [
                'name' => 'Korogwe',
                'region_id' => 26,
            ],
            [
                'name' => 'Lushoto',
                'region_id' => 26,
            ],
            [
                'name' => 'Handeni',
                'region_id' => 26,
            ],
            [
                'name' => 'Kilindi',
                'region_id' => 26,
            ],
        ]);
    }
}
