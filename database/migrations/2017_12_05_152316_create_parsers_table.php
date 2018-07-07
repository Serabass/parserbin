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
            $table->increments('id');
            $table->string('hash', 64)->unique();
            $table->integer('user_id')->nullable();
            $table->longText('input');
            $table->dateTime('last_activity')->nullable()->useCurrent();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['user_id', 'hash']);
        });

        $parser = new \Parserbin\Models\Parser();
        $parser->hash = '123';
        $parser->input = '123';
        $parser->last_activity = \Carbon\Carbon::now()->toDateTimeString();
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
