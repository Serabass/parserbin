<?php

namespace Parserbin\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    const DEFAULT = 'js';

    public static function default()
    {
        return self::whereCode(self::DEFAULT)->first();
    }

    public function scripts()
    {
        return $this->hasMany(Script::class, 'languageId');
    }
}
