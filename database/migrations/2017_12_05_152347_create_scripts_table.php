<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Parserbin\Models\Script;

class CreateScriptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scripts', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('content');
            $table->integer('parserId');
            $table->integer('languageId');
            $table->timestamps();
            $table->softDeletes();
        });

        $script = new Script();
        $script->content = 'return input + input;';
        $script->parser()->associate(\Parserbin\Models\Parser::find(1));
        $script->language()->associate(\Parserbin\Models\Language::default());
        $script->save();

        $script = new Script();
        $script->content = 'return input + input + input;';
        $script->parser()->associate(\Parserbin\Models\Parser::find(1));
        $script->language()->associate(\Parserbin\Models\Language::default());
        $script->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scripts');
    }
}
