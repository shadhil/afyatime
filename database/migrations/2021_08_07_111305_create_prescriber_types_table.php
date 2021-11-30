<?php

use App\Models\PrescriberType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePrescriberTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescriber_types', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('title', 50);
            $table->string('initial', 20)->nullable();
            $table->foreignId('org_id')->constrained('organizations')->nullable();
            $table->timestamps();
        });

        DB::table('prescriber_types')->insert([
            [
                'initial' => 'Dr.',
                'title' => 'Doctor'
            ],
            [
                'initial' => NULL,
                'title' => 'Nurse'
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prescriber_types');
    }
}
