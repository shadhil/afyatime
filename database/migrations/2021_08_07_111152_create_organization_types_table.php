<?php

// use App\Models\OrganizationType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_types', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('type', 50);
        });


        \App\Models\OrganizationType::create(['type' => 'Hospital']);
        \App\Models\OrganizationType::create(['type' => 'Clinic']);
        \App\Models\OrganizationType::create(['type' => 'NGO']);
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organization_types');
    }
}
