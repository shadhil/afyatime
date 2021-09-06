<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paid_by')->nullable();
            $table->unsignedBigInteger('organization_id');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->unsignedTinyInteger('package_id');
            $table->string('payment_ref', 50)->nullable();
            $table->bigInteger('total_price')->nullable();
            $table->enum('status', ['Paid', 'Subscribed', 'UnSubscribed', 'Blocked']);
            $table->timestamps();

            //FOREIGN KEY CONSTRAINTS
            $table->foreign('organization_id')->references('id')->on('organizations')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('paid_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('package_id')->references('id')->on('subscription_packages')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organization_subscriptions');
    }
}
