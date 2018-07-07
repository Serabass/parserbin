<?php

namespace Parserbin\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Parserbin\User;

/**
 * Parserbin\Models\Parser
 *
 * @property int $id
 * @property string|null $title
 * @property string $hash
 * @property int|null $user_id
 * @property string $input
 * @property string|null $last_activity
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read mixed $is_mine
 * @property-read \Illuminate\Database\Eloquent\Collection|\Parserbin\Models\Script[] $scripts
 * @property-read \Parserbin\User|null $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\Parserbin\Models\Parser onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Parserbin\Models\Parser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Parserbin\Models\Parser whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Parserbin\Models\Parser whereHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Parserbin\Models\Parser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Parserbin\Models\Parser whereInput($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Parserbin\Models\Parser whereLastActivity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Parserbin\Models\Parser whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Parserbin\Models\Parser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Parserbin\Models\Parser whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Parserbin\Models\Parser withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Parserbin\Models\Parser withoutTrashed()
 * @mixin Eloquent
 * @property int|null $parentId
 * @method static \Illuminate\Database\Eloquent\Builder|\Parserbin\Models\Parser whereParentId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\Parserbin\Models\Parser[] $forks
 * @property-read \Parserbin\Models\Parser|null $parent
 * @property int $indexable
 * @property string $embed_code
 * @property bool $is_child
 * @property bool $is_parent
 * @method static \Illuminate\Database\Eloquent\Builder|\Parserbin\Models\Parser whereIndexable($value)
 * @property int|null $parent_id
 */
class Parser extends Model
{
    use SoftDeletes;

    protected $appends = ['isMine'];

    protected $dates = ['last_activity'];

    protected $casts = [
        "indexable" => "boolean",
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function parent()
    {
        return $this->belongsTo(Parser::class, 'parent_id');
    }

    public function forks()
    {
        return $this->hasMany(Parser::class, 'parent_id');
    }

    public function scripts()
    {
        return $this->hasMany(Script::class, 'parser_id');
    }

    public function getIsMineAttribute()
    {
        return $this->user_id
            && Auth::check()
            && $this->user_id === Auth::id();
    }

    public static function generateFreeHash()
    {
        do {
            $hash = str_random();
        } while (self::whereHash($hash)->count() > 0);

        return $hash;
    }

    public function getIsChildAttribute()
    {
        return $this->parentId !== null;
    }

    public function getIsParentAttribute()
    {
        return $this->forks->count() > 0;
    }

    public function updateLastActivity()
    {
        $this->last_activity = Carbon::now();
        $this->save();
        return $this;
    }

    public function fork()
    {
        /**
         * @var $new Parser
         */
        $new = $this->replicate();
        $new->hash = self::generateFreeHash();
        $new->parentId = $this->id;
        $new->push();

        return $new;
    }

    public function url()
    {
        if ($this->user) {
            $route = route('user.parser', [
                'user' => $this->user->name,
                'hash' => $this->hash
            ]);
        } else {
            $route = route('parser.index', [
                'hash' => $this->hash
            ]);
        }
        return $route;
    }

    public function embedUrl()
    {
        if ($this->user) {
            return route('user.parser.embed', [
                'user' => $this->user->name,
                'hash' => $this->hash
            ]);
        }
        return route('parser.embed', ['hash' => $this->hash]);
    }

    public function getEmbedCodeAttribute()
    {
        return '<iframe src="' . $this->embedUrl() . '"></iframe>';
    }
}
