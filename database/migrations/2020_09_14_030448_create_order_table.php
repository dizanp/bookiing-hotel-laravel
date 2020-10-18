<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->increments('id');
            $table->date('tgl_checkin');
            $table->date('tgl_checkout');
            $table->integer('kamar');
            $table->integer('tempat_tidur');
            $table->integer('total_harga');
            $table->string('bukti_bayar', 50)->nullable();
            $table->string('konfirmasi', 7)->nullable();
            $table->string('status_checkout', 7)->nullable();
            $table->integer('user_id')->unsigned();
            $table->integer('hotel_id')->unsigned();
            $table->timestamps();

            $table->foreign('hotel_id')->references('id')->on('hotel')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order');
    }
}
