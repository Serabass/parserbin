<?php

namespace Parserbin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Parserbin\Models\Script.
 *
 * @property int $id
 * @property string $content
 * @property int $parser_id
 * @property int $language_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Parserbin\Models\Language $language
 * @property-read \Parserbin\Models\Parser $parser
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\Parserbin\Models\Script onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Parserbin\Models\Script whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Parserbin\Models\Script whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Parserbin\Models\Script whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Parserbin\Models\Script whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Parserbin\Models\Script whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Parserbin\Models\Script whereParserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Parserbin\Models\Script whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Parserbin\Models\Script withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Parserbin\Models\Script withoutTrashed()
 * @mixin \Eloquent
 */
class Script extends Model
{
    use SoftDeletes;

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    public function parser()
    {
        return $this->belongsTo(Parser::class, 'parser_id');
    }
}
