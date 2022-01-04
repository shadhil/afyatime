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
            $table->unsignedBigInteger('org_id')->nullable();
            $table->timestamps();

            //FOREIGN KEY CONSTRAINTS
            $table->foreign('org_id')->references('id')->on('organizations')->onUpdate('cascade')->onDelete('set null');
        });

        DB::table('prescriber_types')->insert([
            [
                'initial' => 'Dr.',
                'title' => 'Doctor',
                'org_id' => NULL
            ],
            [
                'initial' => NULL,
                'title' => 'Nurse',
                'org_id' => NULL
            ],
            [
                'initial' => NULL,
                'title' => 'Admin',
                'org_id' => NULL
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
