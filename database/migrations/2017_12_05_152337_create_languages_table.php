<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Parserbin\Models\Language;

class CreateLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 8)->unique();
            $table->string('name', 32);
            $table->timestamps();
        });

        $langs = [
            'js' => 'Javascript',
            'cs' => 'Coffeescript',
        ];
        foreach ($langs as $code => $name) {
            $lang = new Language();
            $lang->code = $code;
            $lang->name = $name;
            $lang->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('languages');
    }
}
