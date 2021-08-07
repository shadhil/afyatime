<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateFullRegionsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE OR REPLACE VIEW `full_regions` AS SELECT  `districts`.`id` as `district_id`, `districts`.`name` AS `district`, `regions`.`id` as `region_id`, `regions`.`name` AS `region` FROM regions JOIN districts ON (`regions`.`id` = `districts`.`region_id`)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW full_regions");
    }
}
