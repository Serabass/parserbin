<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('hash', 64)->unique();
            $table->integer('userId')->nullable();
            $table->text('input');
            $table->dateTime('lastActivity')->useCurrent();
            $table->timestamps();
            $table->softDeletes();
        });

        $parser = new \Parserbin\Models\Parser();
        $parser->hash = '123';
        $parser->input = '123';
        $parser->lastActivity = \Carbon\Carbon::now()->toDateTimeString();
        $parser->save();
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
