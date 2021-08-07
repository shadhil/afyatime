<?php

namespace Database\Seeders;

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
        DB::table('districts')->insert(array(
            0 =>
            array(
                'id' => 1,
                'name' => 'Arusha Municipal',
                'region_id' => 1,
            ),
            1 =>
            array(
                'id' => 2,
                'name' => 'Arusha',
                'region_id' => 1,
            ),
            2 =>
            array(
                'id' => 3,
                'name' => 'Arumeru',
                'region_id' => 1,
            ),
            3 =>
            array(
                'id' => 4,
                'name' => 'Monduli',
                'region_id' => 1,
            ),
            4 =>
            array(
                'id' => 5,
                'name' => 'Longido',
                'region_id' => 1,
            ),
            5 =>
            array(
                'id' => 6,
                'name' => 'Karatu',
                'region_id' => 1,
            ),
            6 =>
            array(
                'id' => 7,
                'name' => 'Ngorongoro',
                'region_id' => 1,
            ),
            7 =>
            array(
                'id' => 8,
                'name' => 'Ilala',
                'region_id' => 2,
            ),
            8 =>
            array(
                'id' => 9,
                'name' => 'Kinondoni',
                'region_id' => 2,
            ),
            9 =>
            array(
                'id' => 10,
                'name' => 'Ubungo',
                'region_id' => 2,
            ),
            10 =>
            array(
                'id' => 11,
                'name' => 'Temeke',
                'region_id' => 2,
            ),
            11 =>
            array(
                'id' => 12,
                'name' => 'Kigamboni',
                'region_id' => 2,
            ),
            12 =>
            array(
                'id' => 13,
                'name' => 'Dodoma Municipal',
                'region_id' => 3,
            ),
            13 =>
            array(
                'id' => 14,
                'name' => 'Dodoma',
                'region_id' => 3,
            ),
            14 =>
            array(
                'id' => 15,
                'name' => 'Bahi ',
                'region_id' => 3,
            ),
            15 =>
            array(
                'id' => 16,
                'name' => 'Chamwino',
                'region_id' => 3,
            ),
            16 =>
            array(
                'id' => 17,
                'name' => 'Kongwa',
                'region_id' => 3,
            ),
            17 =>
            array(
                'id' => 18,
                'name' => 'Mpwapwa',
                'region_id' => 3,
            ),
            18 =>
            array(
                'id' => 19,
                'name' => 'Kondoa',
                'region_id' => 3,
            ),
            19 =>
            array(
                'id' => 20,
                'name' => 'Chemba',
                'region_id' => 3,
            ),
            20 =>
            array(
                'id' => 21,
                'name' => 'Geita',
                'region_id' => 4,
            ),
            21 =>
            array(
                'id' => 22,
                'name' => 'Nyang\'hwale',
                'region_id' => 4,
            ),
            22 =>
            array(
                'id' => 23,
                'name' => 'Chato',
                'region_id' => 4,
            ),
            23 =>
            array(
                'id' => 24,
                'name' => 'Mbogwe',
                'region_id' => 4,
            ),
            24 =>
            array(
                'id' => 25,
                'name' => 'Bukombe',
                'region_id' => 4,
            ),
            25 =>
            array(
                'id' => 26,
                'name' => 'Iringa Municipal',
                'region_id' => 5,
            ),
            26 =>
            array(
                'id' => 27,
                'name' => 'Iringa',
                'region_id' => 5,
            ),
            27 =>
            array(
                'id' => 28,
                'name' => 'Kilolo',
                'region_id' => 5,
            ),
            28 =>
            array(
                'id' => 29,
                'name' => 'Mufindi',
                'region_id' => 5,
            ),
            29 =>
            array(
                'id' => 30,
                'name' => 'Bukoba Municipal',
                'region_id' => 6,
            ),
            30 =>
            array(
                'id' => 31,
                'name' => 'Bukoba',
                'region_id' => 6,
            ),
            31 =>
            array(
                'id' => 32,
                'name' => 'Missenyi',
                'region_id' => 6,
            ),
            32 =>
            array(
                'id' => 33,
                'name' => 'Karagwe',
                'region_id' => 6,
            ),
            33 =>
            array(
                'id' => 34,
                'name' => 'Muleba',
                'region_id' => 6,
            ),
            34 =>
            array(
                'id' => 35,
                'name' => 'Biharamulo',
                'region_id' => 6,
            ),
            35 =>
            array(
                'id' => 36,
                'name' => 'Ngara',
                'region_id' => 6,
            ),
            36 =>
            array(
                'id' => 37,
                'name' => 'Kyerwa',
                'region_id' => 6,
            ),
            37 =>
            array(
                'id' => 38,
                'name' => 'Mpanda Municipal',
                'region_id' => 7,
            ),
            38 =>
            array(
                'id' => 39,
                'name' => 'Tanganyika',
                'region_id' => 7,
            ),
            39 =>
            array(
                'id' => 40,
                'name' => 'Mlele',
                'region_id' => 7,
            ),
            40 =>
            array(
                'id' => 41,
                'name' => 'Kigoma Municipal',
                'region_id' => 8,
            ),
            41 =>
            array(
                'id' => 42,
                'name' => 'Kigoma',
                'region_id' => 8,
            ),
            42 =>
            array(
                'id' => 43,
                'name' => 'Kasulu',
                'region_id' => 8,
            ),
            43 =>
            array(
                'id' => 44,
                'name' => 'Kibondo',
                'region_id' => 8,
            ),
            44 =>
            array(
                'id' => 45,
                'name' => 'Buhigwe',
                'region_id' => 8,
            ),
            45 =>
            array(
                'id' => 46,
                'name' => 'Uvinza',
                'region_id' => 8,
            ),
            46 =>
            array(
                'id' => 47,
                'name' => 'Kakonko',
                'region_id' => 8,
            ),
            47 =>
            array(
                'id' => 48,
                'name' => 'Moshi Municipal',
                'region_id' => 9,
            ),
            48 =>
            array(
                'id' => 49,
                'name' => 'Moshi',
                'region_id' => 9,
            ),
            49 =>
            array(
                'id' => 50,
                'name' => 'Hai',
                'region_id' => 9,
            ),
            50 =>
            array(
                'id' => 51,
                'name' => 'Siha',
                'region_id' => 9,
            ),
            51 =>
            array(
                'id' => 52,
                'name' => 'Mwanga',
                'region_id' => 9,
            ),
            52 =>
            array(
                'id' => 53,
                'name' => 'Same',
                'region_id' => 9,
            ),
            53 =>
            array(
                'id' => 54,
                'name' => 'Rombo',
                'region_id' => 9,
            ),
            54 =>
            array(
                'id' => 55,
                'name' => 'Lindi Municipal',
                'region_id' => 10,
            ),
            55 =>
            array(
                'id' => 56,
                'name' => 'Lindi',
                'region_id' => 10,
            ),
            56 =>
            array(
                'id' => 57,
                'name' => 'Nachingwea',
                'region_id' => 10,
            ),
            57 =>
            array(
                'id' => 58,
                'name' => 'Kilwa',
                'region_id' => 10,
            ),
            58 =>
            array(
                'id' => 59,
                'name' => 'Liwale',
                'region_id' => 10,
            ),
            59 =>
            array(
                'id' => 60,
                'name' => 'Ruangwa',
                'region_id' => 10,
            ),
            60 =>
            array(
                'id' => 61,
                'name' => 'Babati Municipal',
                'region_id' => 11,
            ),
            61 =>
            array(
                'id' => 62,
                'name' => 'Babati',
                'region_id' => 11,
            ),
            62 =>
            array(
                'id' => 63,
                'name' => 'Hanang\'',
                'region_id' => 11,
            ),
            63 =>
            array(
                'id' => 64,
                'name' => 'Mbulu',
                'region_id' => 11,
            ),
            64 =>
            array(
                'id' => 65,
                'name' => 'Kiteto',
                'region_id' => 11,
            ),
            65 =>
            array(
                'id' => 66,
                'name' => 'Simanjiro',
                'region_id' => 11,
            ),
            66 =>
            array(
                'id' => 67,
                'name' => 'Musoma',
                'region_id' => 12,
            ),
            67 =>
            array(
                'id' => 68,
                'name' => 'Butiama',
                'region_id' => 12,
            ),
            68 =>
            array(
                'id' => 69,
                'name' => 'Rorya',
                'region_id' => 12,
            ),
            69 =>
            array(
                'id' => 70,
                'name' => 'Tarime',
                'region_id' => 12,
            ),
            70 =>
            array(
                'id' => 71,
                'name' => 'Bunda',
                'region_id' => 12,
            ),
            71 =>
            array(
                'id' => 72,
                'name' => 'Serengeti',
                'region_id' => 12,
            ),
            72 =>
            array(
                'id' => 73,
                'name' => 'Mbeya Municipal',
                'region_id' => 13,
            ),
            73 =>
            array(
                'id' => 74,
                'name' => 'Mbeya',
                'region_id' => 13,
            ),
            74 =>
            array(
                'id' => 75,
                'name' => 'Rungwe',
                'region_id' => 13,
            ),
            75 =>
            array(
                'id' => 76,
                'name' => 'Mbarali',
                'region_id' => 13,
            ),
            76 =>
            array(
                'id' => 77,
                'name' => 'Kyela',
                'region_id' => 13,
            ),
            77 =>
            array(
                'id' => 78,
                'name' => 'Chunya',
                'region_id' => 13,
            ),
            78 =>
            array(
                'id' => 79,
                'name' => 'Morogoro Municipal',
                'region_id' => 14,
            ),
            79 =>
            array(
                'id' => 80,
                'name' => 'Morogoro',
                'region_id' => 14,
            ),
            80 =>
            array(
                'id' => 81,
                'name' => 'Mvomero',
                'region_id' => 14,
            ),
            81 =>
            array(
                'id' => 82,
                'name' => 'Kilosa',
                'region_id' => 14,
            ),
            82 =>
            array(
                'id' => 83,
                'name' => 'Kilombero',
                'region_id' => 14,
            ),
            83 =>
            array(
                'id' => 84,
                'name' => 'Ulanga',
                'region_id' => 14,
            ),
            84 =>
            array(
                'id' => 85,
                'name' => 'Gairo',
                'region_id' => 14,
            ),
            85 =>
            array(
                'id' => 86,
                'name' => 'Malinyi',
                'region_id' => 14,
            ),
            86 =>
            array(
                'id' => 87,
                'name' => 'Mtwara Municipal',
                'region_id' => 15,
            ),
            87 =>
            array(
                'id' => 88,
                'name' => 'Mtwara',
                'region_id' => 15,
            ),
            88 =>
            array(
                'id' => 89,
                'name' => 'Tandahimba',
                'region_id' => 15,
            ),
            89 =>
            array(
                'id' => 90,
                'name' => 'Newala',
                'region_id' => 15,
            ),
            90 =>
            array(
                'id' => 91,
                'name' => 'Masasi',
                'region_id' => 15,
            ),
            91 =>
            array(
                'id' => 92,
                'name' => 'Nanyumbu',
                'region_id' => 15,
            ),
            92 =>
            array(
                'id' => 93,
                'name' => 'Nyamagana',
                'region_id' => 16,
            ),
            93 =>
            array(
                'id' => 94,
                'name' => 'Ilemela',
                'region_id' => 16,
            ),
            94 =>
            array(
                'id' => 95,
                'name' => 'Sengerema',
                'region_id' => 16,
            ),
            95 =>
            array(
                'id' => 96,
                'name' => 'Magu',
                'region_id' => 16,
            ),
            96 =>
            array(
                'id' => 97,
                'name' => 'Misungwi',
                'region_id' => 16,
            ),
            97 =>
            array(
                'id' => 98,
                'name' => 'Ukerewe',
                'region_id' => 16,
            ),
            98 =>
            array(
                'id' => 99,
                'name' => 'Kwimba',
                'region_id' => 16,
            ),
            99 =>
            array(
                'id' => 100,
                'name' => 'Njombe Municipal',
                'region_id' => 17,
            ),
            100 =>
            array(
                'id' => 101,
                'name' => 'Njombe',
                'region_id' => 17,
            ),
            101 =>
            array(
                'id' => 102,
                'name' => 'Wanging\'onmbe',
                'region_id' => 17,
            ),
            102 =>
            array(
                'id' => 103,
                'name' => 'Ludewa',
                'region_id' => 17,
            ),
            103 =>
            array(
                'id' => 104,
                'name' => 'Makete',
                'region_id' => 17,
            ),
            104 =>
            array(
                'id' => 105,
                'name' => 'Kibaha Municipal',
                'region_id' => 18,
            ),
            105 =>
            array(
                'id' => 106,
                'name' => 'Kibaha',
                'region_id' => 18,
            ),
            106 =>
            array(
                'id' => 107,
                'name' => 'Bagamoyo',
                'region_id' => 18,
            ),
            107 =>
            array(
                'id' => 108,
                'name' => 'Kisarawe',
                'region_id' => 18,
            ),
            108 =>
            array(
                'id' => 109,
                'name' => 'Mkuranga',
                'region_id' => 18,
            ),
            109 =>
            array(
                'id' => 110,
                'name' => 'Rufiji',
                'region_id' => 18,
            ),
            110 =>
            array(
                'id' => 111,
                'name' => 'Mafia',
                'region_id' => 18,
            ),
            111 =>
            array(
                'id' => 112,
                'name' => 'Kibiti',
                'region_id' => 18,
            ),
            112 =>
            array(
                'id' => 113,
                'name' => 'Sumbawanga Municpal',
                'region_id' => 19,
            ),
            113 =>
            array(
                'id' => 114,
                'name' => 'Sumbawanga',
                'region_id' => 19,
            ),
            114 =>
            array(
                'id' => 115,
                'name' => 'Nkasi',
                'region_id' => 19,
            ),
            115 =>
            array(
                'id' => 116,
                'name' => 'Kalambo',
                'region_id' => 19,
            ),
            116 =>
            array(
                'id' => 117,
                'name' => 'Songea Municipal',
                'region_id' => 20,
            ),
            117 =>
            array(
                'id' => 118,
                'name' => 'Songea',
                'region_id' => 20,
            ),
            118 =>
            array(
                'id' => 119,
                'name' => 'Namtumbo',
                'region_id' => 20,
            ),
            119 =>
            array(
                'id' => 120,
                'name' => 'Mbinga',
                'region_id' => 20,
            ),
            120 =>
            array(
                'id' => 121,
                'name' => 'Nyasa',
                'region_id' => 20,
            ),
            121 =>
            array(
                'id' => 122,
                'name' => 'Tunduru',
                'region_id' => 20,
            ),
            122 =>
            array(
                'id' => 123,
                'name' => 'Shinyanga Municipal',
                'region_id' => 21,
            ),
            123 =>
            array(
                'id' => 124,
                'name' => 'Shinyanga',
                'region_id' => 21,
            ),
            124 =>
            array(
                'id' => 125,
                'name' => 'Kahama',
                'region_id' => 21,
            ),
            125 =>
            array(
                'id' => 126,
                'name' => 'Kishapu',
                'region_id' => 21,
            ),
            126 =>
            array(
                'id' => 127,
                'name' => 'Bariadi',
                'region_id' => 22,
            ),
            127 =>
            array(
                'id' => 128,
                'name' => 'Bariadi',
                'region_id' => 22,
            ),
            128 =>
            array(
                'id' => 129,
                'name' => 'Itilima',
                'region_id' => 22,
            ),
            129 =>
            array(
                'id' => 130,
                'name' => 'Maswa',
                'region_id' => 22,
            ),
            130 =>
            array(
                'id' => 131,
                'name' => 'Meatu',
                'region_id' => 22,
            ),
            131 =>
            array(
                'id' => 132,
                'name' => 'Busega',
                'region_id' => 22,
            ),
            132 =>
            array(
                'id' => 133,
                'name' => 'Singida Municipal',
                'region_id' => 23,
            ),
            133 =>
            array(
                'id' => 134,
                'name' => 'Singida',
                'region_id' => 23,
            ),
            134 =>
            array(
                'id' => 135,
                'name' => 'Iramba',
                'region_id' => 23,
            ),
            135 =>
            array(
                'id' => 136,
                'name' => 'Manyoni',
                'region_id' => 23,
            ),
            136 =>
            array(
                'id' => 137,
                'name' => 'Mkalama',
                'region_id' => 23,
            ),
            137 =>
            array(
                'id' => 138,
                'name' => 'Ikungi',
                'region_id' => 23,
            ),
            138 =>
            array(
                'id' => 139,
                'name' => 'Songwe',
                'region_id' => 24,
            ),
            139 =>
            array(
                'id' => 140,
                'name' => 'Mbozi',
                'region_id' => 24,
            ),
            140 =>
            array(
                'id' => 141,
                'name' => 'Ileje',
                'region_id' => 24,
            ),
            141 =>
            array(
                'id' => 142,
                'name' => 'Momba',
                'region_id' => 24,
            ),
            142 =>
            array(
                'id' => 143,
                'name' => 'Tabora',
                'region_id' => 25,
            ),
            143 =>
            array(
                'id' => 144,
                'name' => 'Uyui',
                'region_id' => 25,
            ),
            144 =>
            array(
                'id' => 145,
                'name' => 'Sikonge',
                'region_id' => 25,
            ),
            145 =>
            array(
                'id' => 146,
                'name' => 'Nzega',
                'region_id' => 25,
            ),
            146 =>
            array(
                'id' => 147,
                'name' => 'Urambo',
                'region_id' => 25,
            ),
            147 =>
            array(
                'id' => 148,
                'name' => 'Igunga',
                'region_id' => 25,
            ),
            148 =>
            array(
                'id' => 149,
                'name' => 'Kaliua',
                'region_id' => 25,
            ),
            149 =>
            array(
                'id' => 150,
                'name' => 'Tanga Municipal',
                'region_id' => 26,
            ),
            150 =>
            array(
                'id' => 151,
                'name' => 'Tanga',
                'region_id' => 26,
            ),
            151 =>
            array(
                'id' => 152,
                'name' => 'Pangani',
                'region_id' => 26,
            ),
            152 =>
            array(
                'id' => 153,
                'name' => 'Muheza',
                'region_id' => 26,
            ),
            153 =>
            array(
                'id' => 154,
                'name' => 'Mkinga',
                'region_id' => 26,
            ),
            154 =>
            array(
                'id' => 155,
                'name' => 'Korogwe',
                'region_id' => 26,
            ),
            155 =>
            array(
                'id' => 156,
                'name' => 'Lushoto',
                'region_id' => 26,
            ),
            156 =>
            array(
                'id' => 157,
                'name' => 'Handeni',
                'region_id' => 26,
            ),
            157 =>
            array(
                'id' => 158,
                'name' => 'Kilindi',
                'region_id' => 26,
            ),
        ));
    }
}
