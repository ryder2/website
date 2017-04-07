<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfferapplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offreapplications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('offre_id');
            $table->double('montant');
            $table->boolean('accepted')->default(false);
            $table->boolean('sedeplace')->default(false);
            $table->boolean('fournitpiece')->default(false);
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
        Schema::dropIfExists('offreapplications');
    }
}
