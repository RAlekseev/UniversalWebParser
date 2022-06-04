<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParserResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parser_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parser_id');
            $table->foreign('parser_id')->references('id')->on('parsers')->onDelete('cascade');
            $table->string('url');

            $table->json('targets_result');
            $table->json('images')->nullable();
            $table->json('internal_links')->nullable();

            //Для последующей проверки результата таргетов на уникальность
            $table->string('result_hash');
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
        Schema::dropIfExists('parser_results');
    }
}
