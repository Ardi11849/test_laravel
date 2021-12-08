<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePajaksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pajaks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_item')->unsigned();
            $table->string('nama');
            $table->decimal('rate');
            $table->timestamps();
            $table->index(['id', 'id_item', 'nama', 'rate']);

            $table->foreign('id_item')
                    ->references('id')->on('items')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pajaks');
    }
}
