<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdminIdInOrgSubscriprionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organization_subscriptions', function (Blueprint $table) {
            $table->unsignedBigInteger('confirmed_by')->nullable()->after('status');

            //FOREIGN KEY CONSTRAINTS
            $table->foreign('confirmed_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organization_subscriptions', function (Blueprint $table) {
            $table->dropForeign('confirmed_by');
        });
    }
}
