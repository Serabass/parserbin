<?php

namespace Parserbin\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Parserbin\Models\Language
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Parserbin\Models\Script[] $scripts
 * @method static \Illuminate\Database\Eloquent\Builder|\Parserbin\Models\Language whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Parserbin\Models\Language whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Parserbin\Models\Language whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Parserbin\Models\Language whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Parserbin\Models\Language whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Language extends Model
{
    const DEFAULT = 'js';

    public static function default()
    {
        return self::whereCode(self::DEFAULT)->first();
    }

    public function scripts()
    {
        return $this->hasMany(Script::class, 'language_id');
    }
}
