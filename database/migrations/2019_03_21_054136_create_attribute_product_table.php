<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributeProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_product', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('attribute_id')->nullable();
            $table->unsignedInteger('product_id')->nullable();
            $table->unsignedInteger('color_id')->nullable();
            $table->string('attribute_image')->nullable();
            $table->integer('attribute_qty')->nullable();
            $table->string('attribute_legnth', 50)->nullable();
            $table->string('attribute_front', 50)->nullable();
            $table->string('attribute_back', 50)->nullable();
            $table->string('attribute_chest', 50)->nullable();
            $table->decimal('attribute_price', 10, 2)->nullable();
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
        Schema::dropIfExists('attribute_product');
    }
}
