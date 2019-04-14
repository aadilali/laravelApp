<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsPost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events_post', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->mediumText('desc');
            $table->unsignedInteger('price');
            $table->string('product_type');
            $table->string('product_category')->nullable();
            $table->unsignedInteger('product_quantity');
            $table->string('availablity');
            $table->unsignedInteger('setup_time');
            $table->mediumText('product_options')->nullable();
            $table->mediumText('product_includes')->nullable();;
            $table->mediumText('product_logistics')->nullable();;
            $table->mediumText('product_fine_print')->nullable();;
            $table->boolval('is_featured')->default(false);
            $table->string('image_url')->nullable();
            $table->unsignedInteger('author_id');
            $table->timestamps();

            $table->foreign('author_id')->references('id')->on('users');
            
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events_post');
    }
}
