<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parsers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url');
            $table->string('selector');
            $table->string('search_link_selector');
            $table->json('targets');

            $table->string('img_selector')->nullable();
            $table->string('internal_link_selector')->nullable();

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
        Schema::dropIfExists('parsers');
    }
}
