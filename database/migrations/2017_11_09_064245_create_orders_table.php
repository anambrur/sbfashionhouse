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
            $table->unsignedInteger("user_id")->index();
            $table->string("customer_name")->nullable();
            $table->string("contact_email")->nullable();
            $table->integer("qty", false, true)->default(0);
            $table->float("sub_total", 10, 2);
            $table->float("discount", 5, 2);
            $table->string("coupon_code")->nullable();
            $table->float("coupon_amount", 6, 2)->default(0);
            $table->float("tax", 6, 2)->default(0);
            $table->float("grand_total", 10, 2)->index();
            $table->float("paid", 10, 2)->index();
            $table->unsignedInteger("payment_method_id")->index()->nullable();
            $table->text("order_note")->nullable();
            $table->text("attachments")->nullable();
            $table->text("completed_files")->nullable();
            $table->integer("created_by", false, true);
            $table->integer('modified_by', false, true)->nullable();
            $table->tinyInteger('order_status')->index()->default(3)
                ->comment('1=Completed, 2=Processing, 3=Pending, 4=Cancelled');
            $table->tinyInteger('payment_status')->index()->default(3)
                ->comment('1=Completed, 2=Pending, 3=Cancelled');
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
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
