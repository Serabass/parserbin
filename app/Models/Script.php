<?php

namespace Parserbin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Script extends Model
{
    use SoftDeletes;

    public function language()
    {
        return $this->belongsTo(Language::class, 'languageId');
    }

    public function parser()
    {
        return $this->belongsTo(Parser::class, 'parserId');
    }
}
