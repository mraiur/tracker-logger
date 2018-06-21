<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TrackLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_types', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('end_event_type_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned();
            $table->integer('duration')->default(0);
            $table->string('hex_color')->default("#675aff");
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::table('event_types', function (Blueprint $table)
        {
            $table->foreign('end_event_type_id')
                ->references('id')->on('event_types')
                ->onDelete('cascade');
        });

        Schema::create('track_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_type_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('event_type_id')->references('id')->on('event_types')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::disableForeignKeyConstraints();

        Schema::table('track_log', function ($table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['event_type_id']);
        });
        Schema::dropIfExists('track_log');
        Schema::dropIfExists('event_type');

        Schema::enableForeignKeyConstraints();
    }
}
