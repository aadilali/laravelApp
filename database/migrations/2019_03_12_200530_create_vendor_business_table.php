<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorBusinessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_business', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_name', 150);
            $table->string('business_website', 150)->nullable();
            $table->mediumText('business_address');
            $table->string('business_phone', 100);
            $table->string('business_type', 100)->nullable();
            $table->mediumText('business_desc');
            $table->string('business_logo', 200)->nullable();
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_business');
    }
}
