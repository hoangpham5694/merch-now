<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDesignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('designs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('brand')->nullable();
            $table->string('title')->nullable();
            $table->text('key_product_1')->nullable();
            $table->text('key_product_2')->nullable();
            $table->string('image')->nullable();
            $table->float('price')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('account_id')->nullable();
            $table->string('mode')->nullable();
            $table->string('status')->nullable()->default('pending');
            $table->text('note');
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
        Schema::dropIfExists('design');
    }
}
