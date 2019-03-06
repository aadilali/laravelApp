<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_id');
            $table->timestamp('event_date')->useCurrent();
            $table->string('participants', 100)->nullable()->default('0');
            $table->string('event_time', 100)->nullable();
            $table->string('zip_code', 100);
            $table->mediumText('event_notes')->nullable();
            $table->unsignedInteger('sub_total')->default(0); 
            $table->unsignedInteger('customer_id'); 
            $table->mediumText('cart_details')->nullable();
            $table->foreign('customer_id')->references('id')->on('users');           
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
        Schema::dropIfExists('orders');
    }
}
