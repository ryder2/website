<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('rue');
            $table->string('codepostal');
            $table->string('ville');
            $table->string('province');
            $table->string('pays');
            $table->boolean('mecano');
            $table->boolean('approuved');
            $table->string('cartemecano');
            $table->string('apropos');
            $table->string('experience');
            $table->integer('stars');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('rue');
            $table->dropColumn('codepostal');
            $table->dropColumn('ville');
            $table->dropColumn('province');
            $table->dropColumn('pays');
            $table->dropColumn('mecano');
            $table->dropColumn('approuved');
            $table->dropColumn('cartemecano');
            $table->dropColumn('apropos');
            $table->dropColumn('experience');
            $table->dropColumn('stars');
        });
    }
}
