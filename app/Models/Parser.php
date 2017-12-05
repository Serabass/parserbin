<?php

namespace Parserbin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parser extends Model
{
    use SoftDeletes;

    protected $appends = ['isMine'];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function scripts()
    {
        return $this->hasMany(Script::class, 'parserId');
    }

    public function getIsMineAttribute()
    {
        return Auth::check() && $this->userId === Auth::id();
    }
}
