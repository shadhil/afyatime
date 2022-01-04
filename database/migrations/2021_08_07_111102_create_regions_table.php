<?php

use App\Models\Region;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('name', 50);
        });

        DB::table('regions')->insert([
            ['name' => 'Arusha'],
            ['name' => 'Dar es salaam'],
            ['name' => 'Dodoma'],
            ['name' => 'Geita'],
            ['name' => 'Iringa'],
            ['name' => 'Kagera'],
            ['name' => 'Katavi'],
            ['name' => 'Kigoma'],
            ['name' => 'Kilimanjaro'],
            ['name' => 'Lindi'],
            ['name' => 'Manyara'],
            ['name' => 'Mara'],
            ['name' => 'Mbeya'],
            ['name' => 'Morogoro'],
            ['name' => 'Mtwara'],
            ['name' => 'Mwanza'],
            ['name' => 'Njombe'],
            ['name' => 'Pwani'],
            ['name' => 'Rukwa'],
            ['name' => 'Ruvuma'],
            ['name' => 'Shinyanga'],
            ['name' => 'Simiyu'],
            ['name' => 'Singida'],
            ['name' => 'Songwe'],
            ['name' => 'Tabora'],
            ['name' => 'Tanga'],
            // ['name' => 'Kaskazini Pemba'],
            // ['name' => 'Kusini Pemba'],
            // ['name' => 'Kaskazini Unguja'],
            // ['name' => 'Kusini Unguja'],
            // ['name' => 'Mjini Magharibi']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regions');
    }
}
